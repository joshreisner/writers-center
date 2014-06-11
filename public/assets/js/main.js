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

	//init scroller
	win_height = $(window).height();

	//scroll banners & background
	$(window).scroll(function(e){
	    var height = $(window).scrollTop();
	    //console.log(height);
	    
	    /*
	    var banner_opacity = (100 - height) / 100;
	    if (banner_opacity < 0) banner_opacity = 0;
	    $(".banner").css("opacity", banner_opacity);
	    */

	    /*
		var background_opacity = height / 3000;
		if (background_opacity > .1) background_opacity = .1;
		$(".background").css("opacity", background_opacity);
		*/
		start_height = 400;
	    var offset = start_height - (height / 1.75);
	    $(".background").css("top", offset + 'px');


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
		$(this).find("input").prop(
			"checked", 
			$(this).find(".chkbox").toggleClass("active").hasClass("active")
		);
		var switchboard = $(this).closest('form.switchboard');
		if (switchboard.size()) updateSwitchboard(switchboard);
	});

	//capture switchboard submit
	$("form.switchboard").submit(function(){
		updateSwitchboard($(this));
		return false;
	});

	//update any switchboard
	function updateSwitchboard(which) {
		$.get("/" + which.attr("data-model") + "/ajax", which.serializeArray(), function(data){
			console.log('updating switchboard with ' + which.serializeArray());
			$(".page .content .inner div.target").html(data);
		});
	}

});
