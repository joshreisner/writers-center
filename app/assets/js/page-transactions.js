
//auto submit form when changing a select, hide empty values from query string
$('nav.filter').on('change', 'select', function(){
	var $form = $(this).closest('form');
	$form.find('select').each(function(){
		if ($(this).val() == '') $(this).prop('disabled', true);
	});
	$form.submit();
	$form.find('select').prop('disabled', false);
});