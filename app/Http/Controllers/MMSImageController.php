<?php

namespace App\Http\Controllers;

use App\MMSImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
use Intervention\Image\Facades\Image as Image;


class MMSImageController extends Controller
{
  /* LOGIN PROTECTION */
  protected $user;
  protected $signedIn;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $images=MMSImage::orderBy('id', 'desc')->get();
      return view('pages.images-list',['images'=>$images]);
  }

  public function list_images(){
    $images=MMSImage::orderBy('id', 'desc')->get();
    echo json_encode($images);
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function upload(Request $request)
  {
    if ($request->hasFile('upload')){
      if ($request->file('upload')->isValid()) {
          $allowable_file_types="|jpg|png|jpeg|gif|pdf|";
          $path = $request->upload->path();
          $extension = $request->upload->extension();
          $filename=$request->file('upload')->getClientOriginalName();

          if (substr_count($allowable_file_types,"|".$extension."|")>0){
            // upload to remote
            $localFile = File::get($path);
            Storage::disk('s3')->put('remote/images/'.$filename, $localFile);
            // Create thumbnail

            $originalImage = $request->file('upload');
            $thumbnailImage = Image::make($originalImage);
            $img_thumb_filename='thumb--' . $filename;

            $thumbnailImage->save('tmp');
            $thumbnailImage->fit(350,350);
            $thumbnailImage->save('tmp');

            Storage::disk('s3')->put('remote/images/'.$img_thumb_filename, $thumbnailImage);

            // store in db
            MMSImage::create([
              'filename' => $filename,
              'alt' => $request->input('alt'),
            ]);
            return redirect('/images')->with('info','Image uploaded successfully.');
          }
      }
      return redirect('/images')->with('info','There was an issue uploading your image.');
    } else {
      echo "No file to upload...";
    }
  }
  public function destroy($id)
  {
    // remove from FTP
    // remove from database;
    if ($image=MMSImage::find($id)){
      MMSImage::destroy($id);
      $exists = Storage::disk('s3')->has('remote/images/'.$image->filename);
      echo $image->filename;
      if($exists){
        Storage::disk('s3')->delete($image->filename);
        Storage::disk('s3')->delete('thumb--' . $image->filename);
        return redirect('/images')->with('info','Image removed successfully.');
      }
    }
    return redirect('/images')->with('info','There was an issue removing your image.');
  }


}
