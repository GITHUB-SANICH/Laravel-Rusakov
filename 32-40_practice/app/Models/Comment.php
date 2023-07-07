<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory; 
	 Use SoftDeletes;

	 public function post(){
		return $this->belongsTo(Post::class);
	 }
}
