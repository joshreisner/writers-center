$(function(){

	//open external links in new tab
	$("a[href^='http']").attr("target","_blank");

	//login
	$("a.login").click(function(e){
		e.preventDefault();
	});
	
});