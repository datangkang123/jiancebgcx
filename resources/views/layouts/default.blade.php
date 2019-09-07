<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'PHPExcel') - 信息查询系统</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ mix('js/app.js') }}"></script>
  </head>

  <body>
    @include('layouts._header')

    <div class="container">
      <div class="offset-md-1 col-md-10">
        @include('shared._messages')
        @yield('content')
      </div>
    </div>
  </body>
</html>