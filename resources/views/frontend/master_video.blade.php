<!DOCTYPE HTML>
<html lang = "en">
  <head>
    <meta charset="utf-8" />
    <title>@yield('title') | VIDEO - Cerebro Digital</title>
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="@yield('keyword')" />
    <meta property="og:type" content="video" />
    <meta property="og:title" content="@yield('title') | Cerebro Digital" />
    <meta property="og:image" content="@yield('image')" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:url" content="{{\Request::url()}}" />
    <meta property="og:site_name" content="Proyecto Sinapsis | Cerebro Digital" />
    <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="/syn/css/reset.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/syn/css/font-awesome.min.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/syn/css/dat-menu.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/syn/css/main-stylesheet.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/syn/css/responsive.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Oswald:300,400,700|Source+Sans+Pro:300,400,600,700&amp;subset=latin,latin-ext" />
        <link type='text/css' rel='stylesheet' href='http://fonts.googleapis.com/css?family=Titillium+Web:400,600,700' />
    <link type="text/css" rel="stylesheet" href="/video/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="/video/css/ot-menu.css" />
    <link type="text/css" rel="stylesheet" href="/video/css/main-stylesheet.css" />
    <link type="text/css" rel="stylesheet" href="/video/css/shortcodes.css" />
    <link type="text/css" rel="stylesheet" href="/video/css/responsive.css" />
     

    <!--[if lte IE 8]>
    <link type="text/css" rel="stylesheet" href="css/ie-ancient.css" />
    <![endif]-->

    <!--[if lt IE 9 ]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
      /* Man content & sidebar top lne, default #256193 */
      #sidebar .panel,
      #main-box #main {
        border-top: 5px solid #256193;
      }

      /* Slider colors, default #256193 */
      a.featured-select,
      #slider-info .padding-box ul li:before,
      .home-article.right ul li a:hover {
        background-color: #256193;
      }

      /* Button color, default #256193 */
      .panel-duel-voting .panel-duel-vote a {
        background-color: #256193;
      }

      /* Menu background color, default #000 */
      #menu-bottom.blurred #menu > .blur-before:after {
        background-color: #000;
      }

      /* Top menu background, default #0D0D0D */
      #header-top {
        background: #0D0D0D;
      }

      /* Sidebar panel titles color, default #333333 */
      #sidebar .panel > h2 {
        color: #333333;
      }

      /* Main titles color, default #353535 */
      #main h2 span {
        color: #353535;
      }

      /* Selection color, default #256193 */
      ::selection {
        background: #256193;
      }

      /* Links hover color, default #256193 */
      .article-icons a:hover,
      a:hover {
        color: #256193;
      }

      /* Image hover background, default #256193 */
      .article-image-out,
      .article-image {
        background: #256193;
      }

      /* Image hover icons color, default #256193 */
      span.article-image span .fa {
        color: #256193;
      }
    </style>

  </head>
  <body class="no-slider">
  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.6&appId=616745428493845";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  <!-- <body class="has-top-menu"> -->
    <!-- BEGIN #slider-imgs -->
    <div id="slider-imgs">
      <div class="featured-img-box">
        <div id="featured-img-1" class="featured-img"></div>
        <div id="featured-img-2" class="featured-img invisible"></div>
        <div id="featured-img-3" class="featured-img invisible"></div>
        <div id="featured-img-4" class="featured-img invisible"></div>
      </div>
    <!-- END #slider-imgs -->
    </div>

    <!-- BEGIN #top-layer -->
    <div id="top-layer">
      @include('frontend.includes.headertop')
      <section id="content">
        @include('frontend.includes.header')

        @yield('video')
        <div id="main-box">
          
          <div id="main">
            @yield('main')
            
          </div>
          @yield('sidebar')
          <div class="clear-float"></div>
          
        </div>
      </div>
    </div>
      
    <div class="clear-float"></div>
    @include('frontend.widgets.shoutbox')
    <div class="wrapper">
      <!-- BEGIN .footer -->
      @include('frontend.includes.footer')
    </div>
    <script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/syn/jscript/modernizr.custom.50878.js'></script>
    <script type='text/javascript' src='/syn/jscript/iscroll.js'></script>
    <script type='text/javascript' src='/syn/jscript/dat-menu.js'></script>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/video/jscript/jquery-latest.min.js"></script>
    <script type="text/javascript" src="/video/jscript/ot-menu.js"></script>
    <script type="text/javascript" src="/video/jscript/theme-scripts.js"></script>
    
    
    <script type='text/javascript' src='/syn/jscript/theme-script.js'></script>
    <link rel="stylesheet" type="text/css" href="/shoutbox/shoutbox.css">
    <script src="/shoutbox/shoutbox.js"></script>
    @yield('bottomscripts')
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-61432082-1', 'auto');
      ga('send', 'pageview');
    </script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57573a52e1ddf843"></script>

  </body>
</html>