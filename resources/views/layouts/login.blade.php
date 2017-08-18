<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Administrator</title>
    <!-- Bootstrap core CSS -->
    {{Html::style('assets/css/bootstrap.css')}}
    <!--external css-->
    {{Html::style('assets/font-awesome/css/font-awesome.css')}}
        
    <!-- Custom styles for this template -->
    {{Html::style('assets/css/style.css')}}
    {{Html::style('assets/css/style-responsive.css')}}
</head>
<body>
    <div id="login-page">
	  	<div class="container">
          @yield('content')
	  	</div>
	</div>

    

     <!-- js placed at the end of the document so the pages load faster -->
    {{Html::script('assets/js/jquery.js')}}
    {{Html::script('assets/js/bootstrap.min.js')}}

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    {{Html::script('assets/js/jquery.backstretch.min.js')}}

</body>
</html>