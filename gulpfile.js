var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix
    .rubySass('main.sass', 'public/assets/css')
    //.rubySass('center.sass', 'public/assets/css')
    .scripts([
	    '../../bower_components/jquery/dist/jquery.js',
		'../../bower_components/bootstrap-sass/dist/js/bootstrap.js',
		'../../bower_components/slick-carousel/slick/slick.min.js',
		'../../bower_components/jquery.payment/lib/jquery.payment.js'
    ], 'public/assets/js/lib.js')
    .scripts([
		'../assets/js/login.js',
		'../assets/js/main.js',
		'../assets/js/page-home.js',
		'../assets/js/page-support.js',
		'../assets/js/page-checkout.js',
		'../assets/js/page-transactions.js',
		'../assets/js/page-my-hvwc.js'
    ], 'public/assets/js/main.js');
});
