<?php

namespace App\Http\Controllers;

use App\MMSProject;
use Illuminate\Http\Request;
use App\Http\Requests\MMSProjectRequest;
use Illuminate\Support\Facades\Storage;
use File;
use Intervention\Image\Facades\Image as Image;

class MMSProjectController extends Controller
{

  /* LOGIN PROTECTION */
  protected $user;
  protected $signedIn;

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function __construct()
   {
       $this->middleware('auth');
   }

  public function index()
  {
//    $projects=MMSProject::orderBy('pub_date', 'DESC')->get();
    $projects=MMSProject::orderBy('id', 'DESC')->get();
    return view('pages.projects-list',['projects'=>$projects]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
     return view('pages.project-new');
   }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(MMSProjectRequest $request)
  {
    $result=MMSProject::create(request()->all());
    return redirect('/project-edit/' . $result->id)->with('info','New project added.');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Project  $project
   * @return \Illuminate\Http\Response
   */
   public function edit(MMSProject $project)
   {
       return view('pages.project-edit')->with(compact('project'));
   }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Project  $project
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, MMSProject $project)
  {
    // validate
    $this->validate($request, [
            'title' => 'required',
            'status' => 'required',
            'content' => 'required',
            'pub_date' => 'required',
            'metadesc' => 'required',
            'slug' => 'required|unique:m_m_s_projects,slug,'.$project->id
    ]);

    // process image upload
    if ($request->hasFile('upload')){
      if ($request->file('upload')->isValid()) {
          $allowable_file_types="|jpg|jpeg|";
          $path = $request->upload->path();
          $extension = $request->upload->extension();
          //$filename=$request->file('upload')->getClientOriginalName();
          $filename= $project->id . "." . $extension;
          if (substr_count($allowable_file_types,"|".$extension."|")>0){
            // upload to remote
            $localFile = File::get($path);
            Storage::disk('s3')->put('remote/images/projects/'.$filename, $localFile);
            // Create thumbnail
            $originalImage = $request->file('upload');
            $thumbnailImage = Image::make($originalImage);
            $img_thumb_filename='thumb--' . $filename;

            $thumbnailImage->save('tmp');
            $thumbnailImage->fit(350,350);
            $thumbnailImage->save('tmp');
            Storage::disk('s3')->put('remote/images/projects/'.$img_thumb_filename, $thumbnailImage);
          }
        }
    }

    for($i=1;$i<=6;$i++){
        if ($request->hasFile('upload_' . $i)){
          if ($request->file('upload_' . $i)->isValid()) {
              $allowable_file_types="|jpg|jpeg|";
              $path = $request['upload_' . $i]->path();
              $extension = $request['upload_' . $i]->extension();
              $filename= $project->id . "-" . $i . "." . $extension;
              if (substr_count($allowable_file_types,"|".$extension."|")>0){
                // upload to remote
                $localFile = File::get($path);
                Storage::disk('s3')->put('remote/images/projects/'.$filename, $localFile);
                // Create thumbnail
                $originalImage = $request->file('upload_' . $i);
                $thumbnailImage = Image::make($originalImage);
                $img_thumb_filename='thumb--' . $filename;

                $thumbnailImage->save('tmp');
                $thumbnailImage->fit(350,350);
                $thumbnailImage->save('tmp');
                Storage::disk('s3')->put('remote/images/projects/'.$img_thumb_filename, $thumbnailImage);
              }
            }
        }
    }


    $project->update($request->all());
    return redirect()->back()->with('message', 'Project Saved');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Project  $project
   * @return \Illuminate\Http\Response
   */
   public function destroy(MMSProject $project)
   {
     $project->delete();
     return redirect('/projects/')->with('info','Project removed.');
   }


   public function import()
   {
     echo "Start<br />\n";
     MMSProject::truncate(); // remove all existing items
     $xmlstring=Storage::disk('local')->get('imports/projects.xml');
     $xmlstring = str_replace("<content:encoded>","<contentEncoded>",$xmlstring);
     $xmlstring = str_replace("</content:encoded>","</contentEncoded>",$xmlstring);
     //$xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
     $xml = simplexml_load_string($xmlstring);
     $items=$xml->channel->item;
     foreach($items as $item){
       $data=array();
       $data['content']=(string)ltrim($item->contentEncoded);
       if (strlen($data['content'])<=160){
         $data['metadesc']=$data['content'];
       } else {
         $data['metadesc']='';
         $words=explode(" ", $data['content']);
         foreach($words as $word){
           if (strlen($data['metadesc']) + strlen($word)<160){
             $data['metadesc'].=" ".$word;
           }
         }
         if ( substr_count('.,"!?' , substr($data['metadesc'],-1) )<1){
           $data['metadesc'].="...";
         }
       }
       $data['title']=ltrim($item->title);
       $data['slug']=ltrim($item->link);
       $data['slug']=str_replace("https://www.markmakesstuff.com/portfolio_page/","",$data['slug']);
       $data['slug']=str_replace("/","",$data['slug']);
       $data['status']=1;
       $data['pub_date']=date("Y-m-d", strtotime($item->pubDate) );
       $result=MMSProject::create($data);

     }
     return redirect('/projects/')->with('info','Projects imported.');
   }


}
