<x-main-layout>
	<x-slot name="title">Михаил Русаков</x-slot>
	<x-slot name="description">Об авторе блога Русакове Михаиле Юрьевиче.</x-slot>
	<x-slot name="keywords">об авторе, михаил русаков, михаил юрьевич русаков</x-slot>
	<x-slot name="left">
		<div id="other">
			<h1>Выпуски рассылки</h1>
			<p class="center">
				 <img src="images/subscribe.png" alt="Выпуски рассылки">
			</p>
			<p>В этом разделе я решил выложить все выпуски своей рассылки. Раньше их видели только мои подписчики, но письма очень часто теряются, не доходят, случайно удаляются. В результате, человек просто не получил очень важный для него выпуск.</p>
			<p>Чтобы исправить эту проблему, я просто буду выкладывать в этом разделе все новые выпуски своей рассылки. Разумеется, узнавать о выходе новых выпусков будут только мои подписчики. Поэтому если Вы не хотите постоянно проверять появились ли новые выпуски или нет, просто подпишитесь на мою рассылку.</p>
			<p>Чтобы стать моим подписчиком, достаточно выбрать любой из мини-курсов, которые Вас заинтересует. Если Вы заинтересовали оба, то можете подписаться на оба, это не запрещается.</p>
			<p>Что такое мини-курс? Мини-курс - это бесплатная серия секретных видеоуроков, которые недоступны остальным пользователям. Эти видеоуроки направлены на то, чтобы Вы получили максимум знаний по выбранной теме курса.</p>
			<p>Итак, чтобы стать моим подписчиком и получить секретные видеоуроки, заполните форму рядом с одним из представленных курсов.</p>		
			<div id="minicourses">
				@foreach ($courses as $course)
				<div class="course">
					<h4>{{$course->title}}</h4>
					<img src="images/courses/{{$course->alias}}.png" alt="{{$course->title}}">
					<form name="subscribe_{{$course->alias}}" method="post" action="https://srs.myrusakov.ru/subscribe?utm_source=Blog.MyRusakov.ru&amp;utm_campaign={{ $course->alias }}" onsubmit="return SR_submit(this)">
						 <div>
							  <input type="text" name="name" placeholder="Ваше имя">
						 </div>
						 <div>
							  <input type="text" name="email" placeholder="Ваш email">
						 </div>
						 <div>
							  <input type="hidden" name="delivery_id" value="{{$course->delivery_id}}">
							  <input type="submit" name="subscribe_{{$course->alias}}" value="ПОЛУЧИТЬ ВИДЕОКУРС">
						 </div>
					</form>
			  </div>
				@endforeach
					<div class="arrows">
					  <div>
							<div class="left">
								 <img src="images/arrow_left.png" alt="">
							</div>
							<div>Бесплатные курсы</div>
							<div class="right">
								 <img src="images/arrow_right.png" alt="">
							</div>
					  </div>
				 </div>
			</div>
	  </div>
	  <h4 id="post_other">Выпуски рассылки</h4>
	  @foreach ($posts as $post)
	  		@include('post_intro', ['number' => $count - $loop->index - ($posts->currentPage() - 1)*env('USER_COUNT_ON_PAGE')])
	  @endforeach
  {{$posts->links('pagination')}}
	</x-slot>
</x-main-layout>