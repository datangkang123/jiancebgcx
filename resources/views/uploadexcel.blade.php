@extends('layouts.default')

@section('content')
  <div class="jumbotron">
    <h2>系统简介</h2>
    <p class="lead">
      详细内容请查看 <a href="https://bk.dzbfsj.com/">具体操作方法</a> PHP通用查询系统。
    </p>
    <p>使用须知：</p>
    <p>1. 请勿将本系统用于政策法规不允许的用途；</p>
    <p>2. 使用本系统请注意隐私保护；</p>
    <p>3. 请用于本单位的查询，切勿冒充其他单位发布查询。 </p>
<br>
<form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <p>
            <input type="file" name="excel" accept=".xls,.xlsx"  id="excel" required="required">
        </p>
        <p>
            <input type="submit" class="btn  btn-success" value="上 传">
        </p>
</form>
    
  </div>
@stop
