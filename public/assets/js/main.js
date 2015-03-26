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
		$.post('/my-hvwc/login', $(this).serialize(), function(data) {
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
		$.post('/my-hvwc/reset', $(this).serialize(), function(data) {
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
	$modal_body = $('#login .modal-body');
	if ($modal_body.find('.alert').size()) {
		$modal_body.find('.alert').first().html(message);
		//todo ding the alert somehow if it's a repeat
	} else {
		$('<div class="alert alert-info" style="display:none;">' + message + '</div>').prependTo($modal_body).slideDown('fast');
	}
}

//vertically center the login modal
function centerModal() {
	//$('#login').css('display', 'block');
	var $dialog = $('#login .modal-dialog').first();
	var offset = ($('#login').height() - $dialog.height()) / 3;
	$dialog.css('margin-top', offset);
}

$(window).on('resize', centerModal);

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

	//set random, unique wallpaper image on each .wallpaper
	var wallpapers = [
    	'grayscale-hvwc-area-by-ronnie-levine-july2014-1.jpg',
    	'grayscale-hvwc-area-by-ronnie-levine-july2014-2.jpg',
    	'grayscale-hvwc-area-by-ronnie-levine-july2014-3.jpg',
    	'grayscale-hvwc-area-by-ronnie-levine-july2014-4-cropped.jpg',
    	'grayscale-hvwc-area-by-ronnie-levine-july2014-5.jpg',
    	'grayscale-hvwc-area-by-ronnie-levine-july2014-6.jpg',
    	'grayscale-hvwc-june13-1.jpg',
    	'grayscale-hvwc-june13-2a-full-image.jpg',
    	'grayscale-hvwc-june13-3.jpg',
    	'grayscale-hvwc-june13-4.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-1.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-2.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-3.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-4.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-5.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-6.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-7.jpg'
	];

	$('.wallpaper').each(function(){
		var random = Math.floor(Math.random() * wallpapers.length);
		$(this).prepend('<div class="image" style="background-image:url(/assets/img/wallpapers/' + wallpapers[random] + ')"/>');
		wallpapers.splice(random, 1);
	})

	//scroll background
	$(window).scroll(function(e){
		if ($(window).scrollTop() > 100) {
			$('body').addClass('scrolled');
		} else {
			$('body').removeClass('scrolled');
		}

	});

	//dropdowns
	$('.btn-group.dropdown a').click(function(e){
		e.preventDefault();
		var parent = $(this).closest('.btn-group.dropdown');
		parent.find('span.selected').html($(this).html());
		parent.find('input').val($(this).attr('data-id'));
		parent.find('li').removeClass('active');
		$(this).closest('li').addClass('active');
		var switchboard = $(this).closest('form.switchboard');
		if (switchboard.size()) updateSwitchboard(switchboard);
	});

	//checkbox
	$('div.checkbox label').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$(this).find('input').prop(
			'checked', 
			$(this).find('.chkbox').toggleClass('active').hasClass('active')
		);
		var switchboard = $(this).closest('form.switchboard');
		if (switchboard.size()) updateSwitchboard(switchboard);
	});

	//capture switchboard submit
	$('form.switchboard').submit(function(){
		updateSwitchboard($(this));
		return false;
	});

	//update any switchboard
	function updateSwitchboard(which) {
		$.get('/' + which.attr('data-model') + '/ajax', which.serializeArray(), function(data){
			$('.page .content .inner div.target').html(data);
		});
	}

	//set up input masks
	$('input[data-stripe=number]').payment('formatCardNumber');
	$('input[data-stripe=cvc]').payment('formatCardCVC');
	$('input[data-numeric]').payment('restrictNumeric');

});

//home form, prevent empty vals
$("form#find-a-class").submit(function(){
    $(this).find('input').each(function() {
		if (!$(this).val()) $(this).remove();
    });
	return true;
});

//home carousel
$('.carousel').slick({
	arrows: true,
	centerMode: true,
	centerPadding: '260px',
	slidesToShow: 1,
	infinite: true,
	responsive: [
		{
			breakpoint: 400,
			settings: {
				infinite: false,
				centerPadding: 0,
				arrows: false
			}
		}
	]
});

//support page: click on a preset
$("form#support").on("click", "label.choice", function(){
	$("form#support label.choice").removeClass("active");
	$("form#support input[name=amount-manual]").val("");
	$("form#support input[name=amount]").val($(this).find("input").val());
	$(this).addClass("active");
});

//support page: change manual amount
$("form#support input[name=amount-manual]").change(function(){
	$("form#support label.choice").removeClass("active");
	$("form#support label.choice input").prop("checked", false);
	$("form#support input[name=amount]").val($(this).val());
});

//support page form handler
$('form#support').submit(function(event) {
	
	//loop through to check required field values
	var hasError = false;
	$(this).find('.required').each(function(){
		if ($(this).val().length) {
			$(this).parent().removeClass("has-error");
		} else {
			$(this).parent().addClass("has-error");
			hasError = true;
		}
	});
	if (hasError) return false;
	
	//disable the submit button to prevent repeated clicks
	$(this).find('input[type=submit]').prop('disabled', true);

	//start stripe request
	Stripe.card.createToken($(this), stripeResponseHandler);

	//prevent the form from submitting with the default action
	return false;
});

function stripeResponseHandler(status, response) {
	var $form = $('form#support');

	if (response.error) {
		// Show the errors on the form
		if (!$(".content .inner .alert").size()) {
			$("<div>", { class: "alert alert-warning" }).prependTo(".content .inner");
		}
		$(".content .inner .alert").text(response.error.message);
		$form.find('input[type=submit]').prop('disabled', false);
	} else {
		$("<input>", {
			type: "hidden",
			name: "stripeToken",
			value: response.id
		}).appendTo($form);
		$form.get(0).submit();
	}
};

$("form#checkout table input").change(function(){

	//loop through and add up all the values
	var total = 0, publications = 0;
	$("form#checkout tbody tr").each(function(){
		var quantity = $(this).find("input").val() - 0;
		var price = $(this).attr("data-price") - 0;
		var row_total = quantity * price;

		//set row total
		$(this).find("td.total").html(row_total);

		//increment main total
		total += row_total;

		//increment shipping total
		if ($(this).attr("data-type") == 'publications') {
			publications += quantity;
		}

	});

	//update footer totals
	var shipping = publications * 2;
	$("form#checkout tfoot tr.subtotal td.value").html(total);
	$("form#checkout tfoot tr.shipping td.value").html(shipping);
	$("form#checkout tfoot tr.total td.value").html(total + shipping);

	//save the new value to the session


});

//auto submit form when changing a select, hide empty values from query string
$('nav.filter').on('change', 'select', function(){
	var $form = $(this).closest('form');
	$form.find('select').each(function(){
		if ($(this).val() == '') $(this).prop('disabled', true);
	});
	$form.submit();
	$form.find('select').prop('disabled', false);
});

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
//# sourceMappingURL=main.js.map