<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Facades\DB;

class UsersImport implements ToModel, WithBatchInserts
{
    public function model(array $rows)
    {
     echo '<pre>';
     foreach ($rows as $key => $row) 
   {
       echo $key;
    if ($key = 0){
     echo '<pre>';
       print_r($row) ;
    }else{}

    }
      }
 
  // WithBatchInserts决定一次将有多少模型插入数据库。
      public function batchSize(): int
    {
        return 1000;
    }
}