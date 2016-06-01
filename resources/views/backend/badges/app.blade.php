<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@section('title') - KPI @show</title>
     @section('meta_keywords')
        <meta name="keywords" content="gamify app,"/>
     @show @section('meta_author')
        <meta name="author" content="Mediasoftpro"/>
     @show @section('meta_description')
     
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
     <link href="/backend/gamify/paper/main.css" type="text/css" rel="stylesheet">
    
     @yield('styles')
     
</head>
<body>
    @include('partials.header')
    
  <div class="container">
     @yield('content')
  </div>
  
   @include('partials.footer')

<!-- Angular JS -->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.10/angular.min.js"></script>
<script src="https://code.angularjs.org/1.3.10/angular-route.min.js"></script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="/backend/gamify/js/bootstrap.min.js"></script>

 @yield('scripts')
 
</body>
</html>
