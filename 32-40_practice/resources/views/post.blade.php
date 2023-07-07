<x-main-layout>
	<x-slot name="title">{{$post->title}}</x-slot>
	<x-slot name="description">{{$post->meta_desc}}</x-slot>
	<x-slot name="keywords">{{$post->meta_key}}</x-slot>
	<x-slot name="left">
			<div class="post" id="post_full">
				<h1>{{$post->title}}</h1>
				<div class="img">
					<img src="https://blog.myrusakov.ru/images/posts/{{ $post->alias }}.png" alt="{{$post->title}}">
				</div>
				<div class="info">
					<div class="hits">
						<img src="images/hits.png" alt="">Просмотров: {{$post->hits}}</div>
					<div class="clear"></div>
				</div>
				<div class="text">{!! $post->full_text !!}</div>
		</div>
		<div id="comments">
				<h3 id="count">Комментарии (<span>{{count($comments)}}</span>):</h3>
				<h4>Добавить комментарий:</h4>
				@if ($errors->any())
					 @foreach ($errors->all() as $message)
						  <p class="message">{{$message}}</p>
					 @endforeach
				@endif
					<form name="add_comment" action="{{url()->current()}}" method="post">
					@csrf
						{{--<input type="hidden" name="_token" value="i6yi4ysAPfHeWGPglYGnBrbKw9RZFWCk3iPmairH">                --}}
					<div>
						<input type="text" name="name" placeholder="Ваше имя" value="{{old('name')}}">
					</div>
					<div>
						<textarea name="text" placeholder="Ваш текст">{{old('text')}}</textarea>
					</div>
					{{-- рекапча --}}
					{{--{!! htmlFormSnippet() !!}--}}
					<div>
						<input type="submit" name="add_comment" value="Добавить комментарий">
					</div>
				</form>
				@foreach ($comments as $comment)
					<div class="comment" id="comment_{{$comment->id}}">
						<div class="name">{{$comment->name}}</div>
						<div class="date">{{$comment->created_at->translatedFormat('d F Y G:i:s')}}</div>
						<div class="clear"></div>
						<div class="text">{{$comment->text}}</div>
						@can('delete', $comment)
							<div class="functions"><a class="replay" href="{{route('comment.delete', ['comment' => $comment])}}">Удалить</a></div>
						@endcan
						<hr class="separator">
					</div>
				@endforeach
				</div>

		<h4 id="post_other">Выпуски, которые Вас могут заинтересовать:</h4>
			@each('post_intro', $posts, 'post')
			{{--@foreach ($posts as $post)
				 @include('post_intro')
			@endforeach--}}
	</x-slot>
</x-main-layout>