@extends('layouts.default')

@section('content')
  <div class="jumbotron">
    <h1>Hello Laravel</h1>
    <p class="lead">
      你现在所看到的是 <a href="https://learnku.com/courses/laravel-essential-training">Laravel 入门教程</a> 的示例项目主页。
    </p>
    <p>
      一切，将从这里开始。
    </p>
    <p>
<form action="/upload" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <p>
            <input type="file" name="excel" accept=".xls,.xlsx"  id="excel">
        </p>
        <p>
            <input type="submit" value="提交">
        </p>
</form>
    </p>
  </div>
@stop
