<?php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create(
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'role' => 'admin',
                'password' => bcrypt('123123123'),
            ],
        );

         Category::factory(10)->create();
        $users = User::factory(10)->create();
        $artworks = Artwork::factory(10)->create();

        Transaction::factory(10)->state(
            new Sequence(
                fn(Sequence $sequence) => [
                    'user_id' => $users->random(),
                    'artwork_id' => $artworks->random(),
                ],
            )
        )->create();
    }
}
