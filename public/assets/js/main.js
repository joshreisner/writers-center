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
		$(this).closest(".btn-group.dropdown").find('span.selected').html($(this).html());
	});

	//checkbox
	$("div.checkbox label").click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$(this).find(".chkbox").toggleClass("active");
	});

});