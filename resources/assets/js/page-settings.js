//support page form handler
$('form#settings').submit(function(event) {

	var allGood = true;

	//loop through to check required field values
	$(this).find('.required').each(function(){
		if ($(this).val().length) {
			$(this).parent().removeClass("has-error");
		} else {
			$(this).parent().addClass("has-error");
			allGood = false;
		}
	});
	
	//compare passwords if present
	if ($('input[name=password]').val()) {
		if ($('input[name=password]').val() != $('input[name=password_confirmation]').val()) {
			$('input[name=password]').closest('.form-group').addClass("has-error");
			allGood = false;
		} else {
			$('input[name=password]').closest('.form-group').removeClass("has-error");
		}
	}

	return allGood;
	
});
