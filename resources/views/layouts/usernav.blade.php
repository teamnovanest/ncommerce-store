<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90680653-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-90680653-2');
    </script>
    <!-- Required meta tags -->
     <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <!-- <meta name="twitter:site" content="@bootstrapdash">
    <meta name="twitter:creator" content="@bootstrapdash">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Azia">
    <meta name="twitter:description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="twitter:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png"> -->

    <!-- Facebook -->
    <!-- <meta property="og:url" content="https://www.bootstrapdash.com/azia">
    <meta property="og:title" content="Azia">
    <meta property="og:description" content="Responsive Bootstrap 4 Dashboard Template">

    <meta property="og:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
    <meta property="og:image:secure_url" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600"> -->

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="BootstrapDash">

    <title>Ncommerce</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

      
    <link rel="stylesheet" href="sweetalert2.min.css">

    <!-- vendor css -->
    <link href="{{ asset('/lib/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/lib/typicons.font/typicons.css')}}" rel="stylesheet">
    <link href="{{ asset('/lib/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">

    <!-- azia CSS -->
    <link rel="stylesheet" href="{{ asset('/lib/css/azia.css')}}">

    <link rel="stylesheet" href="{{ asset('/frontend_new/css/custom.css') }}">

    <link rel='stylesheet' href="https://unpkg.com/nprogress@0.2.0/nprogress.css"/>

  </head>
  <body>

    <div class="az-header">
      <div class="container">
        <div class="az-header-left">
          <a href="/" class="az-logo"><span></span> Ncommerce</a>
          <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
        </div><!-- az-header-left -->
        <div class="az-header-menu">
          <div class="az-header-menu-header">
            <a href="/" class="az-logo"><span></span>Ncommerce</a>
            <a href="" class="close">&times;</a>
          </div><!-- az-header-menu-header -->
          <ul class="nav">
            <li class="nav-item"><a href="/" class="nav-link "><i class="typcn typcn-home-outline"></i>Home</a></li>
            <li class="nav-item active show">
              <a href="/dashboard" class="nav-link"><i class="typcn typcn-chart-area-outline"></i> Dashboard</a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link with-sub"><i class="typcn typcn-book"></i> Feature Request <span class="arrow"><i class="typcn typcn-arrow-sorted-down"></i></span></a>
              <div class="az-menu-sub">
                <div class="container">
                  <div>
                    <nav class="nav">
                      <a href="{{route('feature.create')}}" class="nav-link">Add Request</a>
                      <a href="{{ route('feature.index')}}" class="nav-link">View Request</a>
                    </nav>
                  </div>
                </div><!-- container -->
              </div>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link with-sub"><i class="typcn typcn-book"></i> Setting <span class="arrow"><i class="typcn typcn-arrow-sorted-down"></i></span></a>
              <div class="az-menu-sub">
                <div class="container">
                  <div>
                    <nav class="nav">
                      <a href="{{ route('password.change') }}" class="nav-link">Change Password</a>
                      <a href="{{route('user.profile.show')}}" class="nav-link">Edit Profile</a>
                      <a href="{{route('user.logout')}}" class="nav-link">Logout</a>
                    </nav>
                  </div>
                </div><!-- container -->
              </div>
            </li>
          </ul>
        </div><!-- az-header-menu -->
        
      </div><!-- container -->
    </div><!-- az-header -->

    <div class="az-content az-content-dashboard">
      <div class="container">
        <div class="az-content-body">
          
      </div>
    </div><!-- az-content -->
    @yield('content')


    <!-- <div class="az-footer ht-40">
      <div class="container ht-100p pd-t-0-f">
        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © Novanest <script>document.write(new Date().getFullYear());</script></span>
      </div>
    </div> -->

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script src="{{ asset('/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/lib/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('/lib/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('/lib/peity/jquery.peity.min.js') }}"></script>

    <script src="{{ asset('/lib/js/azia.js')}}"></script>
    <script src="{{ asset('/lib/js/chart.flot.sampledata.js') }}"></script>
    <script src="{{ asset('/lib/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ asset('/lib/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/custom.js')}}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="{{ asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js')}}"></script>

   <script src="{{ asset('https://unpkg.com/nprogress@0.2.0/nprogress.js')}}"></script>

    <script>
        @if(Session::has('messege'))
          var type="{{Session::get('alert-type','info')}}"
          switch(type){
              case 'info':
                   toastr.info("{{ Session::get('messege') }}");
                   break;
              case 'success':
                  toastr.success("{{ Session::get('messege') }}");
                  break;
              case 'warning':
                 toastr.warning("{{ Session::get('messege') }}");
                  break;
              case 'error':
                  toastr.error("{{ Session::get('messege') }}");
                  break;
          }
        @endif
     </script>  

  </body>
</html>
