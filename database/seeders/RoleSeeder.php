<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('roles')->insert([
        ['id'=>1,'name'=>"admin",'display_name'=>'Admin','description'=>'Admin Role'],
        ['id'=>2,'name'=>"librarian",'display_name'=>'Librarian','description'=>'Librarian Role'],
        ['id'=>3,'name'=>"reader",'display_name'=>'Reader','description'=>'Reader Role']
      ]);

    }
}
