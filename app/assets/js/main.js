//= include ../../../bower_components/jquery/dist/jquery.js
//= include ../../../bower_components/bootstrap-sass/dist/js/bootstrap.js
//= include ../../../bower_components/slick-carousel/slick/slick.min.js
//= include ../../../bower_components/jquery.payment/lib/jquery.payment.js

$(function(){

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
			$(".page .content .inner div.target").html(data);
		});
	}

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

	//support page: set up input masks
	$("input[data-stripe=number]").payment('formatCardNumber');
	$("input[data-stripe=cvc]").payment('formatCardCVC');

	//support page form handler
	$('form#support').submit(function(event) {
		var $form = $(this);
		var $amount = $form.find('input[name=amount]');
		var $name = $form.find('input[name=name]');
		var $email = $form.find('input[name=email]');
		var $number = $form.find('input[data-stripe=number]');
		var $cvc = $form.find('input[data-stripe=cvc]');

		//first, check easy inputs
		var hasError = false;
		if ($amount.val().length) {
			$amount.closest(".row").removeClass("error");
		} else {
			$amount.closest(".row").addClass("error");
			hasError = true;
		}

		if ($name.val().length) {
			$name.removeClass("error");
		} else {
			$name.addClass("error");
			hasError = true;
		}

		if ($email.val().length) {
			$email.removeClass("error");
		} else {
			$email.addClass("error");
			hasError = true;
		}

		if ($number.val().length) {
			$number.removeClass("error");
		} else {
			$number.addClass("error");
			hasError = true;
		}

		if ($cvc.val().length) {
			$cvc.removeClass("error");
		} else {
			$cvc.addClass("error");
			hasError = true;
		}

		if (hasError) return false;

		//disable the submit button to prevent repeated clicks
		$form.find('input[type=submit]').prop('disabled', true);

		Stripe.card.createToken($form, stripeResponseHandler);

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

});
