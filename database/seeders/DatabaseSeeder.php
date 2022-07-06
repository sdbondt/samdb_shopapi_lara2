<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'email' => env('ADMIN_EMAIL'),
            'name' => 'SamDB',
            'password' => env('DEFAULT_PASSWORD')
        ]);

        User::create([
            'email' => env('USER_EMAIL'),
            'name' => 'Sam',
            'password' => env('DEFAULT_PASSWORD')
        ]);

        Product::create([
            'name' => 'table',
            'price' => 200,
            'description' => 'A nice table.',
            'user_id' => $admin->id,
            'slug' => Str::slug('table')
        ]);

        Product::create([
            'name' => 'chair',
            'price' => 100,
            'description' => 'To sit at.',
            'user_id' => $admin->id,
            'slug' => Str::slug('chair')
        ]);

        Product::create([
            'name' => 'closet',
            'price' => 150,
            'description' => 'A closet is an enclosed space, with a door, used for storage, particularly that of clothes.',
            'user_id' => $admin->id,
            'slug' => Str::slug('closet')
        ]);

        Product::create([
            'name' => 'sofa',
            'price' => 175,
            'description' => 'Sofa so good.',
            'user_id' => $admin->id,
            'slug' => Str::slug('sofa')
        ]);

    }
}
