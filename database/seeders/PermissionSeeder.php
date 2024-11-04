<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $tables = array('readers','librarians','sections','shelves','books');
      $actions = array('create','edit','show','delete');
      $Permissions = [];

      foreach ($tables as  $table) {
        foreach ($actions as $action) {
          $name = $action .'-'.$table;
          $display_name = $action ." ".$table;
          $Permissions [] = ['name'=> $name,'display_name' => $display_name ];
        }
      }
      $requests = [
        ['name'=>'make-requests','display_name'=>"make Book Request"],
        ['name'=>'accept-requests','display_name'=>"accept Book Request"],
        ['name'=>'reject-requests','display_name'=>"reject Book Request"],
        ['name'=>'return-books','display_name'=>"return Book "]
    ];
      DB::table('permissions')->insert($Permissions);
      DB::table('permissions')->insert($requests);
    }
}
