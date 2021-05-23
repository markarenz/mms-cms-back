<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MMSProject extends Model
{
  protected $fillable = [
    'title',
    'content',
    'slug',
    'status',
    'pub_date',
    'template_id',
    'images',
    'link',
    'metadesc'
  ];
}
