<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UploadExcel extends Controller
{
  //文件上传方法
  public function uploadexcel(){
    return view('uploadexcel');
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
        $sjkm = str_replace('.'.$ext,"",$originalName);//用于存储数据表名
	$sjkm = preg_replace('/\r|\n/', '', $sjkm);//去除换行
	$sjkm = str_replace(" ",'',$sjkm);//去除空格
	$sjkm = str_replace(".",'',$sjkm);//去除.
	$sjkm = str_replace("'",'',$sjkm);//去除单引号
      
     if ($ext == 'xls' or $ext == 'xlsx')
     {
        $request->file('excel')->move('./Uploads',$originalName); //上传文件移动至指定目录
        $path = './Uploads/'.$originalName;
        echo '<center>文件保存在：'.$path.'</center>';
        echo '<br><center>开始读取excel</center><br>';  
          $data = Excel::toArray(new UsersImport, $path);
          $data = $data[0];
         //dd($data);//简单的打印一下
       $bghs = count($data);//表格行数
       $bgls = count($data[0]);//表格列数
        echo '<center>该表共有'.$bghs.'行，共有'.$bgls.'列</center><br>';
		$result = $this->create_table($sjkm,$data);
		if ($result == 1 ){
        echo '<center>导入数据成功！</center>';
        }else{echo '<center>导入数据库失败！</center><br>';}

        //Excel::import(new UsersImport,$path);//调用模型写入数据库
     }else{
     echo '<center>文件格式不正确，请上传后缀为xls或xlsx的excel文件！<center><br>';
     back();
     }
    }else{
      echo '<center>上传失败，请检查文件或网络是否正常！</center>';
      back();
    }
  echo '<br><center><b>系统将在3秒后返回上一页！<b></center>';
  session()->flash('success', '数据导入成功！');
  header("refresh:3; url=uploadexcel");
    }
  
	public function create_table($sjkm,$data)//创建数据表并写入数据
	{
		$tmp = $sjkm;
		$va = $data;
        Schema::dropIfExists($tmp);//测试环境，先删除同名数据表
      if (Schema::hasTable($tmp))
{
  echo '数据表已存在，请先删除再上传！<br>';
}else{
		Schema::create($tmp, function(Blueprint $table) use ($tmp,$va)
  //create 方法会接收两个参数：一个是数据表的名称，另一个则是接收 $table（Blueprint 实例）的闭包。    
		{
			$fields = $va[0];  //列字段
			$table->increments('id');//主键
			foreach($fields as $key => $value){
				if($key == 0){
					$table->string($fields[$key])->nullable();//->unique(); 唯一，根据字段酌情使用
				}else{
					$table->string($fields[$key])->nullable();
				}
				//$fileds_count = $fileds_count + 1;
			}
		});
 
		$value_str= array();
		$id = 1;
		foreach($va as $key => $value){
			if($key != 0){
            foreach($value as $zdnr){//批量替换里面的值
                   $zdnr = preg_replace('/\r|\n/', '', $zdnr);//去除换行
		  		   $zdnr = str_replace(" ",'',$zdnr);//去除空格
				   $zdnr = str_replace("'",'',$zdnr);//去除单引号
				   $zdnr = str_replace(",",'',$zdnr);//去除,号
				   $zdnr = str_replace("，",'',$zdnr);//去除，号
                   $value_str[] = "'$zdnr'";
            }  
               //dd($value_str);
				$news = implode(",",$value_str);
				$news = "$id,".$news;
				DB::insert("insert into $tmp values ($news)");
				//$value_str = '';
				$value_str= array();
				$id = $id + 1;
			}
		}
		return 1;
	} 
}
}
