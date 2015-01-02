//pop the login modal
$('a[href=#login]').click(function(e){
	e.preventDefault();
	$('#login').modal(); //backdrop not working for me?
});

//modal, focus on the username
$('#login')
.on('show.bs.modal', centerModal)
.on('shown.bs.modal', function(e) {
	$('input[name=email]').focus();
});

$('#login form').submit(function(){
	console.log('ayo');
	return false;
});

function centerModal() {
	$('#login').css('display', 'block');
	var $dialog = $('#login .modal-dialog').first();
	var offset = ($('#login').height() - $dialog.height()) / 3;
	$dialog.css('margin-top', offset);
}

$(window).on('resize', centerModal);
