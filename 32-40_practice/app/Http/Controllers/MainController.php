<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use App\Models\FreeCourse;
use App\Models\Post;
use App\Models\Site;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PharIo\Manifest\Author;

class MainController extends Controller
{
    public function index(){
		$posts = Post::where('date_show', '<', Carbon::now())
		->orderByDesc('date_show')
		->paginate(env('USER_COUNT_ON_PAGE'));
		return view('index', ['posts' => $posts]);
	 }

	 public function author(){
		return view('author');
	 }

	 public function courses(){
		return view('courses', [
			'courses' => Course::orderByDesc('id')->get(),
			'free_courses' => FreeCourse::orderByDesc('id')->get()
		]);
	 }

	 public function releases(){
		$courses = FreeCourse::orderByDesc('id')->get();
		$posts = Post::orderByDesc('id')
			->where('is_release', 1)
			->where('date_show', '<', Carbon::now())
			->paginate(env('USER_COUNT_ON_PAGE'));
		$count = Post::where('is_release', 1)
		->where('date_show', '<', Carbon::now())
		->count();

		return view('releases', [
			'courses' => $courses,
			'posts' => $posts,
			'count' => $count
		]);
	 }

	 public function sites(){
		return view('sites', [
			'sites' => Site::where('is_active', 1)->orderByDesc('id')->get()
		]);
	 }

	public function addSite(Request $request) {
		/* https://laravel-recaptcha-docs.biscolab.com/docs/intro */
		$success_add = false;
		if ($request->add_site) {
			 $validated = $request->validate([
				  'address' => 'required|url|unique:sites',
				  'description' => 'required|min:10|max:200',
				  'g-recaptcha-response' => 'recaptcha', 
			 ]);
			 $site = new Site();
			 $site->address = $validated['address'];
			 $site->description = $validated['description'];
			 $site->save();
			 $success_add = true;
		}
		return view('site-add', ['success_add' => $success_add]);
  }

	public function post($alias, Request $request) {
		$post = Post::where('alias', $alias)->first();
		if (!$post) abort(404);
		$this->setAccessToken($request);
		if ($request->add_comment) {
			$redirect = redirect()->route('post.comments', ['alias' => $post]);
			$validator = Validator::make($request->all(), [
				'name' => 'required|alpha|max:100',
				'text' => 'required|string|max:500',
			]);
			//если проверка провалилась
			if ($validator->fails()) return $redirect->withErrors($validator->errors())->withInput();
			$validated = $validator->validate();
			$comment = new Comment();
			$comment->post_id = $post->id;
			$comment->name = $validated['name'];
			$comment->text = $validated['text'];
			$comment->access_token = $request->session()->get('access_token'); //присваивание токена пользователя комментарию
			$comment->save();
			return $redirect;
		}
		$comments = Comment::where('post_id', $post->id)
			->orderByDesc('created_at')
			->get();
		$posts = Post::where('id', '!=', $post->id)
			->inRandomOrder()->limit(env('USER_COUNT_OTHER_POSTS'))->get(); //вывод 3-х постов, которые не равны текущему + константа
		
		return view('post', [
			'comments' => $comments, 
			'posts' => $posts, 
			'post' => $post
		]);
  }

	public function setAccessToken(Request $request) {
		//if ($request->session()->missing('access_token')) {
		if ($request->session()->missing('access_token')) {
			$request->session()->put('access_token', Str::random(32));
		}
  	}

	public function deleteComment(Comment $comment) {
		$post = $comment->post;
		$comment->delete();
		return redirect()->route('post.comments', ['alisas' => $post->alias]);
  	}

	public function search(Request $request) {
		if ($request->search_query) {
			$validated = $request->validate([
				'search_query' => 'required|string|min:3|max:200'
			]);
			$search_query = $validated['search_query'];
			$posts = Post::where('title', 'LIKE', "%$search_query%")
			->orWhere('intro_text', 'LIKE', "%$search_query%")
			->orWhere('full_text', 'LIKE', "%$search_query%")
			->paginate(env('USER_COUNT_ON_PAGE'));
		}
		else return redirect()->route('index');
		return view('search', ['search_query' => $search_query, 'posts' => $posts]);
  	}
}
