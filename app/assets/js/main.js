//= include ../../../bower_components/jquery/dist/jquery.js
//= include ../../../bower_components/bootstrap-sass/dist/js/bootstrap.js
//= include ../../../bower_components/slick-carousel/slick/slick.min.js
//= include ../../../bower_components/jquery.payment/lib/jquery.payment.js

$(function(){

	//= include login.js
	//= include page-home.js
	//= include page-support.js
	//= include page-checkout.js
	//= include page-transactions.js

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

	//support page: set up input masks
	$('input[data-stripe=number]').payment('formatCardNumber');
	$('input[data-stripe=cvc]').payment('formatCardCVC');
	$('input[data-numeric]').payment('restrictNumeric');

});
