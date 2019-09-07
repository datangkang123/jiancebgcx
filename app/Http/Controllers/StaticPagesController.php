<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaticPagesController extends Controller
{
   public function home()
    {
        return view('static_pages/home');
    }
  
    public function help()
    {
        return view('static_pages/help');
    }

    public function about()
    {
        return view('static_pages/about');
    }
  
     public function cxjg(Request $request)
    {
      $data = $request->all();
      //验证码正确
       if (isset($data['code'])){
       $sryzm = $data['code'];
       $yyzm = session("VerifyCode");
      if (isset($data['shuru1']) && $sryzm == $yyzm){
      $cxjgs = DB::table('Jiance')->where('bianhao',$data['shuru1'])->get();
	  return view('static_pages/cxjg', compact('cxjgs'));//传递数组到视图
    }else{
	  return back()->withErrors(['验证码输入错误！']);
      }
  }else{
	  return back()->withErrors(['验证码没有输入！']);
   }
  }   
       
     public function yzm(Request $request)
    {
    $num=4;//验证码个数
    $width=80;//验证码宽度
    $height=20;//验证码高度
    $code=' ';
  for($i=0;$i<$num;$i++)//生成验证码
    {
     switch(rand(0,1))
     {
    case  0:$code[$i]=chr(rand(48,57));break;//数字
    case  1:$code[$i]=chr(rand(97,122));break;//小写字母
    //case  2:$code[$i]=chr(rand(65,90));break;//大写字母
     }
  }
  session(['VerifyCode' => $code]);//存储bm到session
  $image=imagecreate($width,$height);
  imagecolorallocate($image,255,255,255);
  for($i=0;$i<80;$i++)//生成干扰像素
  {
   $dis_color=imagecolorallocate($image,rand(0,2555),rand(0,255),rand(0,255));
   imagesetpixel($image,rand(1,$width),rand(1,$height),$dis_color);
  }
  for($i=0;$i<$num;$i++)//打印字符到图像
  {
   $char_color=imagecolorallocate($image,rand(0,2555),rand(0,255),rand(0,255));
   imagechar($image,60,($width/$num)*$i,rand(0,5),$code[$i],$char_color);
  }
  header("Content-type:image/png");
  imagepng($image);//输出图像到浏览器
  imagedestroy($image);//释放资源
     } 
}
