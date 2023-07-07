const DELAY = 250;
const DELAY_SLIDE = 7000;

$(window).on('load', function () {
    if ($("#left").height() > $("#right").height()) {
        var height = $("#left").height() - 55;
        if ($("#pagination").length) height -= $("#pagination").height() + 30;
        $("#right").height(height);
    }
    else {
        var height = $("#right").height() - 10;
        $("#other").height(height);
    }
});

$(document).ready(function() {
	var items = $(".slider_item");
	var bullets = $("#bullets div");
	var courses = $("#courses .course");
	var minicourses = $("#minicourses .course");
	
	var i = 0;
	var i_course = 0;
	var i_minic = 0;
	var block = false;

	var timer = setInterval(nextSlide, DELAY_SLIDE);
    
    if (typeof(VK) != "undefined") {
        VK.init({apiId: 3233942, onlyWidgets: true});
        if ($("*").is("#vk_comments")) VK.Widgets.Comments("vk_comments", {limit: 10, width: "496", attach: "graffiti,photo,link"});
        if ($("*").is("#vk_like")) VK.Widgets.Like("vk_like", {type: "button", verb: 1});
    }
    
	
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "https://connect.facebook.net/ru_RU/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);
	}
	(document, 'script', 'facebook-jssdk'));
		
	$("#bullets div").on("click", function(event) {
		clearInterval(timer);
		old = i;
		i = $(event.target).prevAll("div").length;
		showSlide();
	});
	
	$("#courses .left img").on("click", function(event) {
		if (block) return;
		var old = i_course;
		i_course--;
		if (i_course < 0) i_course = courses.length - 1;
		showCourse(courses, i_course, old);
	});
	
	$("#courses .right img").on("click", function(event) {
		if (block) return;
		var old = i_course;
		i_course++;
		if (i_course == courses.length) i_course = 0;
		showCourse(courses, i_course, old);
	});

	$("#minicourses .left img").on("click", function(event) {
		if (block) return;
		var old = i_minic;
		i_minic--;
		if (i_minic < 0) i_minic = minicourses.length - 1;
		showCourse(minicourses, i_minic, old);
	});
	
	$("#minicourses .right img").on("click", function(event) {
		if (block) return;
		var old = i_minic;
		i_minic++;
		if (i_minic == minicourses.length) i_minic = 0;
		showCourse(minicourses, i_minic, old);
	});

	$("#slider").on("mouseleave", function(event) {
		clearInterval(timer);
		timer = setInterval(nextSlide, DELAY_SLIDE);
	});
	
	function showCourse(courses, i, i_old) {
		block = true;
		$(courses.get(i_old)).fadeOut(DELAY, function() {
			block = false;
			$(courses.get(i)).fadeIn(DELAY);
		});
	}
	
	function showSlide() {
		if ($(bullets.get(i)).hasClass("active")) return;
		$(items.get(old)).fadeOut(DELAY, function() {
			$(items.get(i)).fadeIn(DELAY);
		});
		bullets.removeClass("active");
		$(bullets.get(i)).addClass("active");
	}
	
	function nextSlide() {
		old = i;
		i++;
		if (i == bullets.length) i = 0;
		showSlide();
	}
	
});

function SR_IsListSelected(el) {
	for (var i = 0; i < el.length; i ++)
		if (el[i].selected || el[i].checked) return i;
	return -1;
}

function SR_trim(f) {
	return f.toString().replace(/^[ ]+/, '').replace(/[ ]+$/, '');
}

function SR_submit(f) {
	f["email"].value = SR_trim(f["email"].value);
	f["name"].value = SR_trim(f["name"].value);
	if (f["name"].value == "Ваше имя") {
		alert("Укажите Ваше имя");
		return false;
	}
	if ((SR_focus = f["email"]) && f["email"].value.replace(/^[ ]+/, '').replace(/[ ]+$/, '').length < 1 || (SR_focus = f["name"]) && f["name"].value.replace(/^[ ]+/, '').replace(/[ ]+$/, '').length < 1) {
		alert("Укажите значения всех полей!");
		SR_focus.focus();
		return false;
	}
	if (!f["email"].value.match(/^[A-Za-z0-9][A-Za-z0-9\._-]*[A-Za-z0-9_]*@([A-Za-z0-9]+([A-Za-z0-9-]*[A-Za-z0-9]+)*\.)+[A-Za-z]+$/)) {
		alert("Некорректный синтаксис email-адреса!");
		f["email"].focus();
		return false;
	} 
	return true;
}