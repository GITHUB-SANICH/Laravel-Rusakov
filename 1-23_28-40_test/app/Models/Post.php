<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
	 use SoftDeletes;

	// protected $table = 'nameTable';
	// public $timestamps = false;
	//protected $primaryKey = 'alias';
	//protected $keyType = 'string';
	protected $attributes = [
		'title' => 'newPost',
		'is_publish' => false
	];

	protected $fillable = [
		'author',
		'is_publish',
	];

	//аксессор
	public function getAuthorAttribute($val){
		return mb_strtoupper($val);
	}

	//мутатор
	public function setAuthorAttribute($val){
		$this->attributes['author'] = $val;
		$this->attributes['title'] = 'Текст поста изменен автором - '.$val;
	}

	//1-й способ установки типа данных
	//public function getIsPublishAttribute($value){
	//	return (bool) $value;
	//}

	//2-й способ установки типа данных
	protected $casts = [
		'is_publish' => 'boolean',
	];
}
