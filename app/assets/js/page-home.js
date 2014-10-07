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
