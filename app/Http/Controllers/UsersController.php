<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
 
  //文件上传方法
  public function photo(){
    return view('photo');
}

//处理文件上传方法
public function upload(Request $request){
    //获取上传文件
    //var_dump($request->hasFile('excel'));
    if($request->hasFile('excel')){
       //$path = $request->file('excel')->store('excel');
   //文件路径，需要开启php的php_fileinfo扩展，store 方法会自动生成唯一的 ID 作为文件名。文件的扩展名将通过检查文件的 MIME 类型来确定。该文件的路径和文件名会被 store 方法返回，以便后续数据库的存储使用。
      //echo $path;
        $originalName = $request->file('excel')->getClientOriginalName(); // 文件原名
        $ext = $request->file('excel')->getClientOriginalExtension(); //获取后缀名
     if ($ext == 'xls' or $ext == 'xlsx')
     {
        $request->file('excel')->move('./Uploads',$originalName); //上传文件移动至指定目录
        $path = './Uploads/'.$originalName;
        echo $path;
        echo '<br>开始读取excel<br>';
          $array = Excel::toArray(new UsersImport, $path);
         //dd($array);//简单的打印一下
       foreach ($array[0] as $key => $row) //$array[0]为第一张表
       {
       if ($key == 0){//获取表格第一行字段名
          echo '<pre>';
         print_r($row);
       }else{  //字段内容
        echo '<pre>';
        print_r($row);
       }  
       }
       
       
        //Excel::import(new UsersImport,$path);//调用模型写入数据库
     }else{
     echo '文件格式不正确，请上传后缀为xls或xlsx的excel文件！';
     back();
     }
    }else{
      echo '上传失败！';
      back();
    }
}
}
