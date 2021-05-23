<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

  protected $fillable = [

    'title',
    'content',
    'slug',
    'status',
    'pub_date',
    'template_id',
    'metadesc'

  ];

}
