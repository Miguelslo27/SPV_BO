<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->

	<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

	@stack('styles')

	<style>
		body { padding-top: 70px; }
	</style>

	<title>v0.2 - Backoffice</title>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		@include('layouts.header')
	</nav>

	<main>
		<div class="container">
			@yield('content')
		</div>
	</main>

	@if (Auth::check())
	<footer class="panel-footer">
		<h6 class="text-center">Desarrollado por AppsXXI - Back Office vX.X - 2016 | Potenciado por PHP, MySQL, Laravel, cPanel, Bootstrap</h6>
	</footer>
	@endif

	<!-- Latest compiled and minified jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	@stack('scripts')

	<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('js/scripts.js') }}"></script>

</body>
</html>
