$("form#checkout table input").change(function(){

	//loop through and add up all the values
	var total = 0, publications = 0;
	$("form#checkout tbody tr").each(function(){
		var quantity = $(this).find("input").val() - 0;
		var price = $(this).attr("data-price") - 0;
		var row_total = quantity * price;

		//set row total
		$(this).find("td.total").html(format_money(row_total));

		//increment main total
		total += row_total;

		//increment shipping total
		if ($(this).attr("data-type") == 'publications') {
			publications += quantity;
		}

	});

	//update footer totals
	var shipping = publications * 2;
	$("form#checkout tfoot tr.subtotal td.value").html(format_money(total));
	$("form#checkout tfoot tr.shipping td.value").html(format_money(shipping));
	$("form#checkout tfoot tr.total td.value").html(format_money(total + shipping));

	//save the new value to the session


});

function format_money(number) {
	return '$' + parseFloat(Math.round(number * 100) / 100).toFixed(2);
}