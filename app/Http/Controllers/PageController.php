<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;

class PageController extends Controller
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
      $pages=Page::all();
      return view('pages.pages-list',['pages'=>$pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('pages.page-new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(PageRequest $request)
     {
         // dd($request);
         $result=Page::create(request()->all());
         return redirect('/page-edit/' . $result->id)->with('info','New page added.');
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
     public function edit(Page $page)
     {
         return view('pages.page-edit')->with(compact('page'));
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
      $page->update($request->all());
      return redirect()->back()->with('message', 'Page Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
      $page->delete();
      return redirect('/pages/')->with('info','Page removed.');
    }
}
