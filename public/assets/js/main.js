$(function(){

	//home form, prevent empty vals
	$("form#find-a-class").submit(function(){
	    $(this).find('input').each(function() {
			if (!$(this).val()) $(this).remove();
	    });
		return true;
	});

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

	//scroll background
	$(window).scroll(function(e){
		if ($(window).scrollTop() > 100) {
			$("body").addClass("scrolled");
		} else {
			$("body").removeClass("scrolled");
		}

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
