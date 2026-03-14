<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@domain.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Admin');

        $editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@domain.com',
            'password' => Hash::make('password'),
        ]);
        $editor->assignRole('Editor');

        $author = User::create([
            'name' => 'Author User',
            'email' => 'author@domain.com',
            'password' => Hash::make('password'),
        ]);
        $author->assignRole('Author');
    }
}
