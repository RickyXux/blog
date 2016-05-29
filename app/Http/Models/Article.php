<?php

namespace App\http\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';
    protected $primaryKey = 'art_id';
    protected $guarded = [];

    public $timestamps = false;
}
