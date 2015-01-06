
//posts!
$('form.message textarea').focus(function(){
	$(this).closest('form.message').addClass('active');
	$(this).animate({ height: '250px' });
});

$('form.message a[href=#cancel]').click(function(e){
	e.preventDefault();
	closeForm($(this).closest('form#message'));
});

$('form.message').submit(function(){
	var $form = $(this);
	$.post($(this).attr('action'), $(this).serialize(), function(data){
		closeForm($form);
		$('.my-hvwc .messages').html(data);
	});
	return false;
});

//comments!
$('form.reply textarea').focus(function(){
	$(this).closest('form.reply').addClass('active');
	$(this).animate({ height: '250px' });
});

$('form.reply a[href=#cancel]').click(function(e){
	e.preventDefault();
	closeForm($(this).closest('form#reply'));
});

$('form.reply').submit(function(){
	var $form = $(this);
	$.post($(this).attr('action'), $(this).serialize(), function(data){
		closeForm($form);
		$form.siblings('ul.replies').html(data);
	}).fail(function(XMLHttpRequest, textStatus, errorThrown) {
		console.log(XMLHttpRequest.responseJSON.error);
 	});
	return false;
});

function closeForm($form) {
	$form.removeClass('active').find('textarea').val('').animate({ height: '48px' });	
}