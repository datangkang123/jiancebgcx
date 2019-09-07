<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JianceModel extends Model
{
    protected $table = 'Jiance';
    protected $casts = [
        'pictures' => 'json', // 声明该字段为json类型
    ];
//定义多图上传,tupian是字据库字段名
/**
多图/文件上传的时候提交的数据为文件路径数组,可以直接用mysql的JSON类型字段存储,
如果用mongodb的话也能直接存储,但是如果用字符串类型text来存储的话,就需要指定数据的存储格式了, 
比如,如果要用json字符串来存储文件数据,就需要在模型中定义字段的mutator,比如字段名为pictures,定义mutator:

public function setPicturesAttribute($pictures)//存储图片路径，将数据组json
{
    if (is_array($pictures)) {
        $this->attributes['pictures'] = json_encode($pictures);
    }
}

public function getPicturesAttribute($pictures)//提取图片路径，将json转数组
{
    return json_decode($pictures, true);
}
  **/
}
