<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;
use File;
use Intervention\Image\Facades\Image as Image;


class PostController extends Controller
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
      $posts=Post::orderBy('pub_date', 'DESC')->get();
      return view('pages.posts-list',['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {
       return view('pages.post-new');
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
      $result=Post::create(request()->all());
      return redirect('/post-edit/' . $result->id)->with('info','New post added.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
     public function edit(Post $post)
     {
         return view('pages.post-edit')->with(compact('post'));
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
      // validate
      $this->validate($request, [
              'title' => 'required',
              'status' => 'required',
              'content' => 'required',
              'pub_date' => 'required',
              'metadesc' => 'required',
              'slug' => 'required|unique:posts,slug,'.$post->id
      ]);

      // process image upload
      if ($request->hasFile('upload')){
        if ($request->file('upload')->isValid()) {
            $allowable_file_types="|jpg|jpeg|";
            $path = $request->upload->path();
            $extension = $request->upload->extension();
            //$filename=$request->file('upload')->getClientOriginalName();
            $filename= $post->id . "." . $extension;
            if (substr_count($allowable_file_types,"|".$extension."|")>0){
              // upload to remote
              $localFile = File::get($path);
              Storage::disk('s3')->put('remote/images/posts/'.$filename, $localFile);
              // Create thumbnail
              $originalImage = $request->file('upload');
              $thumbnailImage = Image::make($originalImage);
              $img_thumb_filename='thumb--' . $filename;

              $thumbnailImage->save('tmp');
              $thumbnailImage->fit(350,350);
              $thumbnailImage->save('tmp');
              Storage::disk('s3')->put('remote/images/posts/'.$img_thumb_filename, $thumbnailImage);
            }
          }
      }
      $post->update($request->all());
      return redirect()->back()->with('message', 'Post Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
     public function destroy(Post $post)
     {
       echo $post->id;
       $post->delete();
       return redirect('/posts/')->with('info','Post removed.');
     }


     public function import()
     {
       // Post::truncate(); // remove all existing items
       $xmlstring=Storage::disk('local')->get('imports/posts.xml');
       $xmlstring = str_replace("<content:encoded>","<contentEncoded>",$xmlstring);
       $xmlstring = str_replace("</content:encoded>","</contentEncoded>",$xmlstring);
       $xml = simplexml_load_string($xmlstring);
       $items=$xml->channel->item;
       $i=1;
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
         $data['slug']=str_replace("/","",str_replace("https://www.markmakesstuff.com/","",ltrim($item->link)));
         $data['status']=1;
         $data['pub_date']=date("Y-m-d", strtotime($item->pubDate) );
         // FIX SLUGS
           // echo $i." ".$data['slug']."<br />";
           // $data2=array();
           // $data2['slug']=$data['slug'];
           // Post::where('id',$i)->update($data);
         $result=Post::create($data);
         $i++;
       }
       return redirect('/posts/')->with('info','Projects imported.');
     }



}
