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

//handle either login or reset password
$('#login form').submit(function(){
	if ($(this).hasClass('login')) {
		$.post('/public-login', $(this).serialize(), function(data) {
			//console.log(data);
			if (data.status == 'success') {
				$('#login').modal('hide');
				//be great to do this without leaving the page
				location.reload();
			} else {
				alertLoginModal(data.message);
			}
		});
	} else {
		$.post('/reset', $(this).serialize(), function(data) {
			alertLoginModal(data.message);
		});
	}
	$(this).find('input[type=submit]').blur();
	return false;
});

//toggle between login and reset password views
$('#login form a').click(function(e){
	e.preventDefault();
	$form = $(this).closest('form');
	if ($form.hasClass('login')) {
		//switch to reset
		$form.removeClass('login').addClass('reset');
		$form.find('h1').html('Reset Password');
		$form.find('.form-group.password').slideUp('fast');
		$(this).html('Cancel');
		$form.find('input[type=submit]').val('Send Reset Email');
	} else {
		//switch back to login
		$form.removeClass('reset').addClass('login');
		$form.find('h1').html('Please log in');
		$form.find('.form-group.password').slideDown('fast');
		$(this).html('Forgot Password');
		$form.find('input[type=submit]').val('Log In');
	}
	$(this).blur();
});

function alertLoginModal(message) {
	console.log('alerting ' + message);
	$modal_body = $('#login .modal-body');
	if ($modal_body.find('.alert').size()) {
		console.log('exists');
		$modal_body.find('.alert').first().html(message);
		//maybe find some way to ding the alert
	} else {
		$('<div class="alert alert-info" style="display:none;">' + message + '</div>').prependTo($modal_body).slideDown('fast');
	}
}

//vertically center the login modal
function centerModal() {
	$('#login').css('display', 'block');
	var $dialog = $('#login .modal-dialog').first();
	var offset = ($('#login').height() - $dialog.height()) / 3;
	$dialog.css('margin-top', offset);
}

$(window).on('resize', centerModal);
