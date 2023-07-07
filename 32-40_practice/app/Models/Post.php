<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
	 Use SoftDeletes;

	protected $casts = [
		'date_show' => 'date'
	];

	 public function comments(){
		return $this->hasMany(Comment::class);
	 }
}
