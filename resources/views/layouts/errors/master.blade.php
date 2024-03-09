 <!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Ansee Nails Care">
		<meta name="keywords" content="Ansee Nails Care">
		<meta name="author" content="Ansee Nails Care">
		<link rel="icon" href="{{asset(config('settings.site_icon'))}}" type="image/x-icon">
    	<link rel="shortcut icon" href="{{asset(config('settings.site_icon'))}}" type="image/x-icon"> 
		<title>Ansee Nails Care @yield('title')</title>
		@include('layouts.errors.css')
		@yield('style')
	</head>
	<body>
		<!-- Loader starts-->
		<div class="loader-wrapper">
			<div class="loader-index"><span></span></div>
			<svg>
				<defs></defs>
				<filter id="goo">
					<fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
					<fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">    </fecolormatrix>
				</filter>
			</svg>
		</div>
		<!-- Loader ends-->
		<!-- page-wrapper Start-->
		@yield('content')		
		<!-- latest jquery-->
		@include('layouts.errors.script')    
	</body>
</html>