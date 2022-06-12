<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanUp();
        $roleAdmin = new Role([
            'name' => 'admin',
        ]);
        $roleAdmin->save();

        $admin = new User([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 1,
        ]);
        $admin->setRoleAttribute($roleAdmin);
        $admin->generateToken();
        $admin->save();
    }

    /**
     * @return void
     */
    protected function cleanUp()
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
