<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
	 use SoftDeletes;

	 public function client(){
		return $this->belongsTo(Client::class); 
	 }

	 public function products(){
		return $this->belongsToMany(Product::class); 
	 }
}
