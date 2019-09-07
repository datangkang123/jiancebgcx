@extends('layouts.default')
@section('title', '查询结果')

@section('content')
<div class="offset-md-0 col-md-12">
  <div class="card ">
    <div class="card-header"><center><h5><b class="text-danger">查询到{{count($cxjgs)}}条，编号：{{$cxjgs[0]->bianhao}}</b> &nbsp&nbsp&nbsp&nbsp （备注：{{$cxjgs[0]->beizhu}}）</h5></center></div>
    <div >
      @include('shared._errors')

@if (count($cxjgs) === 0)
      <br><h6>没有查询到数据，请检查输入是否正确</h6>
@else
 
  <img id='images' width='100%' alt="" src="" class="img-responsive">
    @php
        $img = $cxjgs[0]->pictures;
        $data = json_decode($img, true);
    @endphp
@endif
     <center>
     <p id='picnum'class="text-center"></p>  
     <button type="button" id="last" class="btn btn-primary">上一页</button>&nbsp&nbsp&nbsp&nbsp
     <button type="button" id="next" class="btn btn-primary">下一页</button>
      </center>
      <br>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
	var pictures = '<?php echo $img; ?>';
	var img = JSON.parse(pictures);
     console.log(img);
	var i = 0;
	var num = img.length;
	var pic = "uploads/" + img[i];
	$("#images").attr("src",pic);
    $("#picnum").text('第1张，共' + num + '张');
    $("#last").attr({"disabled":"disabled"});

	$("#next").click(function(){
	i = i + 1;
    console.log(i);
	if(i < (num-1)){//没到最后一张
    $("#next").removeAttr("disabled");//将按钮可用
    $("#last").removeAttr("disabled");//将按钮可用
	$("#images").attr("src","uploads/" + img[i]);
    $("#images").attr("alt","第" + i + "张，共" + num + "张");
    $("#picnum").text('第' + (i+1) + '张，共' + num + '张');
	}else if(i == (num-1)){//最后一张，隐藏下一张，显示上一张按钮
	$("#images").attr("src","uploads/" + img[i]);
    $("#images").attr("alt","第" + i + "张，共" + num + "张");
    $("#picnum").text('第' + (i+1) + '张，共' + num + '张');
    $("#next").attr({"disabled":"disabled"});
    $("#last").removeAttr("disabled");//将按钮可用
    }else{
	$("#images").attr("src","uploads/" + img[i]);
    $("#picnum").text('第' + (i+1) + '张，共' + num + '张');
    $("#next").attr({"disabled":"disabled"});
    $("#last").removeAttr("disabled");//将按钮可用
    }
	});
    
	$("#last").click(function(){
	i = i - 1;
    console.log(i);
	if(i == 0){
    $("#last").attr({"disabled":"disabled"});//第1张隐藏上一个
    $("#next").removeAttr("disabled");//将按钮可用
	$("#images").attr("src","uploads/" + img[i]);
    $("#picnum").text('第' + (i+1) + '张，共' + num + '张');
    }else if(i == (num-1)){//最后一张，隐藏下一个
    $("#next").attr({"disabled":"disabled"});
	$("#images").attr("src","uploads/" + img[i]);
    $("#picnum").text('第' + (i+1) + '张，共' + num + '张');
    }else{//中间的，显示上一个和下一个
	$("#images").attr("src","uploads/" + img[i]);
    $("#picnum").text('第' + (i+1) + '张，共' + num + '张');
    $("#next").removeAttr("disabled");//将按钮可用
    $("#last").removeAttr("disabled");//将按钮可用
    }
	});
    
 });
</script>
@stop