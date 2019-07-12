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
use App\User;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index'] //新增 index 动作来允许游客访问
        ]);
//只让未登录用户访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
      public function index()
    {
        $users = User::paginate(10);//分页，获取10条
        return view('users.index', compact('users'));
    }
//用户注册
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }
  
    public function edit(User $user)
    {
        $this->authorize('update', $user);//进行授权验证
        return view('users.edit', compact('user'));
    }
    public function update(User $user, Request $request)
    {
       $this->authorize('update', $user);//进行授权验证
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user);
    }
  
  
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
        $sjkm = str_replace('.'.$ext,"",$originalName);//用于存储数据表名
	$sjkm = preg_replace('/\r|\n/', '', $sjkm);//去除换行
	$sjkm = str_replace(" ",'',$sjkm);//去除空格
	$sjkm = str_replace(".",'',$sjkm);//去除.
	$sjkm = str_replace("'",'',$sjkm);//去除单引号
      
     if ($ext == 'xls' or $ext == 'xlsx')
     {
        $request->file('excel')->move('./Uploads',$originalName); //上传文件移动至指定目录
        $path = './Uploads/'.$originalName;
        echo $path;
        echo '<br>开始读取excel<br>';
          $data = Excel::toArray(new UsersImport, $path);
          $data = $data[0];
         //dd($data);//简单的打印一下
		$result = $this->create_table($sjkm,$data);
		if ($result == 1 ){
        echo '导入数据成功！';
        }else{echo '导入数据库失败！<br>';}

        //Excel::import(new UsersImport,$path);//调用模型写入数据库
     }else{
     echo '文件格式不正确，请上传后缀为xls或xlsx的excel文件！<br>';
     back();
     }
    }else{
      echo '上传失败！';
      back();
    }
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
