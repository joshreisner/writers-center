
//posts!
$('form#post textarea').focus(function(){
	$(this).closest('form').addClass('active');
	$(this).animate({ height: '250px' });
});

$('form#post a[href=#cancel]').click(function(e){
	e.preventDefault();
	$(this).closest('form#post').removeClass('active').find('textarea').val('').animate({ height: '48px' });
});

$('form#post').submit(function(){
	$.post($(this).attr('action'), $(this).serialize(), function(data){
		alert(data);
	});
	return false;
});

//comments!
$('form#comment textarea').focus(function(){
	$(this).closest('form').addClass('active');
	$(this).animate({ height: '250px' });
});

$('form#comment a[href=#cancel]').click(function(e){
	e.preventDefault();
	$(this).closest('form#post').removeClass('active').find('textarea').val('').animate({ height: '48px' });
});

$('form#comment').submit(function(){
	$.post($(this).attr('action'), $(this).serialize(), function(data){
		alert(data);
	});
	return false;
});

