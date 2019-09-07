@extends('layouts.default')
@section('title', '检测报告查询')

@section('content')
<div class="offset-md-1 col-md-10">
  <div class="card ">
    <div class="card-header">
      <center><h5>检测报告查询</h5></center>
    </div>
    <div class="card-body">
      @include('shared._errors')

      <form method="POST" action="{{ route('cxjg') }}" id="form1" name="form1">
        {{ csrf_field() }}

        <div class="form-group">
          <label for="name">手机号或合同编号：</label>
          <input type="text" name="shuru1" required="required" class="form-control" value="{{ old('shuru1') }}"> </div>
        <div class="form-group">  
	<label  for="code">验证码（区分大小写）：</label>
    <input  type="text" name="code" id="textfield" class="form-control"/>
    <img  id="imgcode" src="{{ route('yzm') }}" alt="验证码" />
          <a  href="javascript:refresh_code()">看不清？换一个</a>
        </div>
        
        <center><button type="submit" class="btn btn-primary">查 询</button></center>
      </form>
    </div>
  </div>
</div>

<script  language="javascript">
 function refresh_code()
 {
  form1.imgcode.src="yzm?a="+Math.random();
 }
</script>
@stop