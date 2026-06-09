<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	
    protected $fillable = [
    'title',
    'description',
    'content',
    'image',
    'source',
    'link',
	'slug',
	'original_link',
	'summary',
    'published_at'
	
	];
}