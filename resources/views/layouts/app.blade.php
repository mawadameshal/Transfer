<html lang="{{ app()->getLocale() }}">
<head>
    <title>Pantry Zone - @yield('title')</title>

   <?php $locale = App::getLocale();

    if (App::isLocale('en')) { ?>
    <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
            integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
            crossorigin="anonymous">

    <link rel="stylesheet" href="css/main.css">


<?php }else{ ?>
    <link
            rel="stylesheet"
            href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css"
            integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If"
            crossorigin="anonymous">

    <link rel="stylesheet" href="css/main-rtl.css">
    <?php } ?>
</head>
<body>
@section('header')
    <header class="blog-header" id="header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#">
                <img src="/images/logo.svg"  class="d-inline-block align-top" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/en') }}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item {{Request::is('#features')?'active':''}}">
                        <a class="nav-link" href="{{ url('#features') }}">Features</a>
                    </li>
                    <li class="nav-item {{Request::is('#works')?'active':''}}">
                        <a class="nav-link" href="{{ url('#works') }}">How it works </a>
                    </li>
                    <li class="nav-item {{Request::is('#contact')?'active':''}}">
                        <a class="nav-link" href="{{ url('#contact') }}">Contact us</a>
                    </li>

                </ul>

                <ul class="navbar-nav mr-auto second-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Register</a>
                    </li>
                </ul>
                <ul class="navbar-nav mr-auto third-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                </ul>

            </div>
        </nav>

       <div class="container">
           <div id="demo" class="carousel slide" data-ride="carousel">

               <!-- Indicators -->
               <div data-spy="affix" id="dot-nav">
                   <ul class="carousel-indicators">
                       <li data-target="#demo" data-slide-to="0" class="active"></li>
                       <li data-target="#demo" data-slide-to="1"></li>
                       <li data-target="#demo" data-slide-to="2"></li>
                   </ul>
               </div>
               <!-- The slideshow -->
               <div class="carousel-inner">
                   <div class="carousel-item active">
                       <div class="row">
                           <div class="col-md-6">
                               <div class="title">
                                   <h2>Pantry Zone Mobile app</h2>
                                   <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                               </div>
                               <div class="icons">

                               </div>
                           </div>
                           <div class="col-md-6">
                               <img src="la.jpg" alt="Los Angeles">
                           </div>
                       </div>

                   </div>
               </div>
           </div>
       </div>
    </header>
@show

<div class="container">
    @yield('content')
</div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<?php if (App::isLocale('en')) { ?>
<script
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous">
</script>


<?php }else{ ?>
<script
        src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js"
        integrity="sha384-a9xOd0rz8w0J8zqj1qJic7GPFfyMfoiuDjC9rqXlVOcGO/dmRqzMn34gZYDTel8k"
        crossorigin="anonymous">
</script>
<?php } ?>

<script>
    $(document).ready(function(){
        $('.nav li').click(function(){
            $('.nav li').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>

</html>