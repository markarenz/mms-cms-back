<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MMSImage extends Model
{
  protected $fillable = [
      'filename', 'alt',
  ];
}
