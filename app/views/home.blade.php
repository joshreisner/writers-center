<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hudson Valley Writers' Center</title>
	<link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/assets/css/main.css">
</head>
<body class="home">
	<div class="container">
		<div class="row banner">
			<div class="col-md-12">
				<a href="#"><img src="/assets/img/logo.png" width="330" height="127"></a>
			</div>
		</div>
		<div class="row nav">
			<div class="col-md-2"><a href="#">About</a></div>
			<div class="col-md-2"><a href="#">Courses</a></div>
			<div class="col-md-2"><a href="#">Events</a></div>
			<div class="col-md-2"><a href="#">Blog</a></div>
			<div class="col-md-2"><a href="#">Publications</a></div>
			<div class="col-md-2"><a href="#">Contact</a></div>
		</div>
	</div>
	<div class="carousel">
		<div class="inner">
			@foreach ($items as $item)
			<div class="item {{ $item['type'] }}">
				<h1>Write Flash Fiction!<br>with Peter Andrews</h1>
				6 Mondays, January 6&ndash;February 24<br>1:30&ndash;3:30 P.M.
				<a href="#">Learn more <i class="glyphicon glyphicon-arrow-right"></i></a>
			</div>
			@endforeach
		</div>
	</div>
	<div class="container">
		<div class="row promos">
			<div class="col-md-4"><a href="#">Events</a></div>
			<div class="col-md-4"><a href="#">Find a Class</a></div>
			<div class="col-md-4"><a href="#">Publications</a></div>
		</div>
	</div>
</body>
</html>
