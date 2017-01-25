<div class="container-fluid">
	<div class="navbar-header">
		@if (Auth::check())
		<a href="{{ route('logout') }}" role="button" class="btn btn-danger btn-logout pull-left">
			<span class="glyphicon glyphicon-off"></span>
		</a>
		@endif
		<a class="navbar-brand" href="{{ route('home') }}"><strong>Back Office</strong> - SeguroParaVos.com.uy</a>
	</div>
	@if (Auth::check())
		@include('layouts.navigation')
	@endif
</div>