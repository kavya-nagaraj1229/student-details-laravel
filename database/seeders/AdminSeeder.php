<?php

namespace Database\Seeders;
  use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
{
    User::create([
        'username' => 'admin',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
        'student_id' => 'null',
    ]);
}
}
