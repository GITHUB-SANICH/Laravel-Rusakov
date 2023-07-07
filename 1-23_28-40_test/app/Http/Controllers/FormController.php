<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    
	public function testForm(Request $request){
		return view('testform');
	}
    
	public function send(Request $request){
		//$name = $request->name;
		//$text = $request->text;
		//$bd = $request->bd;
		//echo "Значения, введеныне в форму: <br>".$name.'<br>'.$text.'<br>'.$bd.'<br><hr>';
	}
    
	public function sendByRequest(TestForm $request){
		//$validate = $request->validate();
		$validate = $request->safe();
		print_r($validate);
		return 'Форма проверена';
	}
    
	public function testUpLoad(Request $request){
		//Storage::put('1.txt', 'Text...');
		//Storage::disk('local')->put('1.txt', 'Text...');
		//Storage::disk('public')->put('1.txt', 'Text...');
		//Storage::disk('local')->prepend('1.txt', 'Begin + ');
		//Storage::disk('local')->append('1.txt', ' + End');
		//Storage::disk('local')->delete('1.txt');
		//Storage::disk('local')->copy('1.txt', '2.txt');
		//echo Storage::disk('local')->get('1.txt').'<br>';
		//echo Storage::url('1.txt').'<br>';
		if ($request->submit) {
			$validator = Validator::make($request->all(), [
				'image' => 'required|file|max:1024|mimes:jpg,png,gif',
			]);
			$validator->validate();
				//echo $request->file('image')->getClientOriginalName().'<br>';
				//echo $request->file('image')->getClientOriginalExtension().'<br>';
				//echo $request->file('image')->extension().'<br>';
				//echo $request->file('image')->getSize().'<br>';
				//echo $request->file('image')->getMimeType().'<br>';
			$path = Storage::disk('public')->putFile('images', trim($request->file('image'))); 
			$url_pub = 'Публичная ссылка на картинку: '.Storage::disk('public')->url($path); 
			$url_loc = 'Локальная ссылка на картинку: '.Storage::url($path); 
			$img = Storage::disk('local')->url($path); //локальная сылка на какртинку
		}else{
			$img = '';
			$url_pub = '';
			$url_loc = '';
			return view('testupload', ['image' => $img, 'public_url' => $url_pub, 'local_url' => $url_loc]); 
		}
		return view('testupload', ['image' => $img, 'public_url' => $url_pub, 'local_url' => $url_loc]); 
	}

}
