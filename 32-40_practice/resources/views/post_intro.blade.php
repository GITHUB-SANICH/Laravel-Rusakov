<div class="post">
	@isset($number)
		<h4>Выпуск №{{$number}}.</h4>
	@endisset
	  <h1>{{$post->title}}</h1>
	  <div class="img">
		  <img src="/images/posts/{{ $post->alias }}.png" alt="{{$post->title}}" />
	  </div>
	  <div class="text">{!!$post->intro_text!!}</div>
	  <div class="more">
		  <a href="{{route('post', ['alias' => $post->alias])}}">ЧИТАТЬ ПОЛНОСТЬЮ &gt;</a>
	  </div>
	  <div class="info">
		  <div class="date">{{$post->date_show->translatedFormat('d F Y')}}</div>
		  <div class="hits">
			  <img src="images/hits.png" alt="" />Просмотров: {{$post->hits}}
		  </div>
			  <div class="clear"></div>
	  </div>	
  </div>	