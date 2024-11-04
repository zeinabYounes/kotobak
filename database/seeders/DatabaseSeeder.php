<?php

namespace Database\Seeders;

use App\Models\{User,Permission,Role};
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\{PermissionSeeder,RoleSeeder};
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        $this->call([
        PermissionSeeder::class,
        RoleSeeder::class,

    ]);
    $user = User::find(1);
    $admin = Role::find(1);

    $user->addRole($admin);
    User::factory()->create([
        'name' => 'Test Admin',
        'email' => 'admin@gmail.com',
        'password'=> Hash::make("admin&123456"),
        'role_id' => $admin->id,
        'id'=>1;
    ]);
    }
}
