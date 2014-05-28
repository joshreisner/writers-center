$(function(){

	//open external links in new tab
	$('a').each(function() {
		var a = new RegExp('/' + window.location.host + '/');
		if (this.href && !a.test(this.href)) {
			$(this).click(function(e) {
				e.preventDefault();
				e.stopPropagation();
				window.open(this.href, '_blank');
			});
		}
	});	

	//login
	$("a.login").click(function(e){
		e.preventDefault();
	});

	//dropdowns
	$(".btn-group.dropdown a").click(function(e){
		e.preventDefault();
		var parent = $(this).closest(".btn-group.dropdown");
		parent.find("span.selected").html($(this).html());
		parent.find("input").val($(this).attr("data-id"));
		parent.find("li").removeClass("active");
		$(this).closest("li").addClass("active");
		var switchboard = $(this).closest('form.switchboard');
		if (switchboard.size()) updateSwitchboard(switchboard);
	});

	//checkbox
	$("div.checkbox label").click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$(this).find(".chkbox").toggleClass("active");
	});

	$("form.switchboard").submit(function(){
		updateSwitchboard($(this));
		return false;
	});

	//update any switchboard
	function updateSwitchboard(whichBoard) {
		if ($("body").hasClass("courses")) {
			$.getJSON("/courses/ajax", whichBoard.serialize(), function(data){
				var str = '';
				$.each(data, function(i, genre){
					str += "<h2>" + genre.title + "</h2><ul class='courses'>";
					$.each(genre.courses, function(i, course){
						str += "<li><a href='/courses/" + course.slug + "'>" + course.title + "</a> with " +
						course.instructor_string + "</li>";
					});
					str += "</ul>";
				});
				$(".page .content .inner div").html(str);
			});
		} else {
			console.log("body not defined");
		}
	}

});




