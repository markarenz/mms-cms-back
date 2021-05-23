<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Post;
use App\MMSProject;
use Illuminate\Support\Facades\Storage;

class SitemapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   private function drawSitemapLines($urls, $url_prefix, $base_url){
     $str='';
     foreach($urls as $url){
       $updated=$url->updated_at;
       if ($updated==""){
           $updated=$url->created_at;
       }
       $str.="<url>\n";
       $str.="\t<loc>" . $base_url.$url_prefix;
         if ($url->slug!="mms-home"){
           $str.=$url->slug;
         }
       $str.="</loc>\n";
       $str.="\t<lastmod>"  .date("Y-m-d\TH:i:s-05:00", strtotime($updated)) . "</lastmod>\n";
       $str.="</url>\n";
     }
     return $str;
   }
   public function create_sitemap(){

     $str='<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';
     $str.="\n";
     $base_url='https://www.markmakesstuff.com/';
     $urls=array();
     $pages = Page::where('status', 1)->select('slug', 'updated_at', 'created_at')->orderBy('updated_at', 'desc')->get();
     $posts = Post::where('status', 1)->select('slug', 'updated_at', 'created_at')->orderBy('updated_at', 'desc')->get();
     $projects = MMSProject::where('status', 1)->select('slug', 'updated_at', 'created_at')->orderBy('updated_at', 'desc')->get();

     $str .= $this->drawSitemapLines($pages,'', $base_url);
     $str .= $this->drawSitemapLines($posts,'posts/', $base_url);
     $str .= $this->drawSitemapLines($projects,'projects/', $base_url);

     $str.='</urlset>';
     echo $str;
     // write sitemap.xml
     // File::put( public_path('sitemap.xml') , $str);
     Storage::disk('s3')->put('sitemap.xml', $str);

     return redirect('/');
   }
}
