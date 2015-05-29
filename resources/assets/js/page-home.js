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
	prevArrow: '<button class="slick-prev" aria-label="previous" data-role="none" type="button" style="display: block;"></button>',
	nextArrow: '<button class="slick-next" aria-label="previous" data-role="none" type="button" style="display: block;"></button>',
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
