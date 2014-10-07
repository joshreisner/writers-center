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
