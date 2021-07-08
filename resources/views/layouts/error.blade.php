@php
$seo = DB::table('seos')->where('deleted_at', NULL)->first();

@endphp

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title>{{ $seo->meta_title }}</title>
 <link rel="stylesheet" href="{{ asset('frontend_new/css/custom.css') }}">
</head>
<body>
 <section class="section-error">

  @yield('content')
  
 </section>
 
</body>
</html>