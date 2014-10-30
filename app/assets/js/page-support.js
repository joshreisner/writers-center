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
