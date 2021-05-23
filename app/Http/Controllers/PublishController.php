<?php

namespace App\Http\Controllers;

use App\Page;
use App\Post;
use App\MMSProject;
use Illuminate\Support\Facades\Storage;


class PublishController extends Controller
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
  public function index(){
    return view('pages.publish');
  }
  public function push_pages_staging(){
    $pages=Page::all();
    $pages=json_encode($pages);
    // push to staing
    $filename='mms-pages--staging.json';
    Storage::disk('local')->put($filename, $pages);
    Storage::disk('s3')->put('remote/json/'.$filename, $pages);
    return redirect('/publish')->with('info','Pages published successfully to STAGING.');
  }
  public function push_pages_production(){
    $pages=Page::all();
    $pages=json_encode($pages);
    // push to staing
    $filename='mms-pages--production.json';
    Storage::disk('local')->put($filename, $pages);
    Storage::disk('s3')->put('remote/json/'.$filename, $pages);
    return redirect('/publish')->with('info','Pages published successfully to PRODUCTION.');
  }

  public function push_posts_staging(){
    $posts=Post::orderBy('pub_date','desc')->get();
    $posts=json_encode($posts);
    // push to staing
    $filename='mms-posts--staging.json';
    Storage::disk('local')->put($filename, $posts);
    Storage::disk('s3')->put('remote/json/'.$filename, $posts);
    return redirect('/publish')->with('info','Posts published successfully to STAGING.');
  }
  public function push_posts_production(){
    $posts=Post::orderBy('pub_date','desc')->get();
    $posts=json_encode($posts);
    // push to staing
    $filename='mms-posts--production.json';
    Storage::disk('local')->put($filename, $posts);
    Storage::disk('s3')->put('remote/json/'.$filename, $posts);
    return redirect('/publish')->with('info','Posts published successfully to PRODUCTION.');
  }

  public function push_projects_staging(){
    $projects=MMSProject::orderBy('pub_date','desc')->get();
    $projects=json_encode($projects);
    // push to staing
    $filename='mms-projects--staging.json';
    Storage::disk('local')->put($filename, $projects);
    Storage::disk('s3')->put('remote/json/'.$filename, $projects);
    return redirect('/publish')->with('info','Projects published successfully to STAGING.');
  }
  public function push_projects_production(){
    $projects=MMSProject::orderBy('pub_date','desc')->get();
    $projects=json_encode($projects);
    // push to staing
    $filename='mms-projects--production.json';
    Storage::disk('local')->put($filename, $projects);
    Storage::disk('s3')->put('remote/json/'.$filename, $projects);
    return redirect('/publish')->with('info','Projects published successfully to PRODUCTION.');
  }

}
