<?php

namespace Database\Seeders;

use App\Models\Objective;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $user = User::all()->random();
        // $team_id = $user->currentTeam->id;
        // dd($user->teams);
        // \App\Models\User::factory(10)->create();

        Objective::factory(3)->create();
        // User::factory(19)->create();

        // Objective::factory(10)->create('user_id'=> User::all()->random()->id);
        // Category::factory()->create(['user_id' => 'Category 2']);
        // Category::factory()->create(['name' => 'Category 3']);
        // Category::factory()->create(['name' => 'Category 4']);

        // Status::factory()->create(['name' => 'Open']);
        // Status::factory()->create(['name' => 'Considering']);
        // Status::factory()->create(['name' => 'In Progress']);
        // Status::factory()->create(['name' => 'Implemented']);
        // Status::factory()->create(['name' => 'Closed']);

        // Idea::factory(100)->existing()->create();

        // // Generate unique votes. Ensure idea_id and user_id are unique for each row
        // foreach (range(1, 20) as $user_id) {
        //     foreach (range(1, 100) as $idea_id) {
        //         if ($idea_id % 2 === 0) {
        //             Vote::factory()->create([
        //                 'user_id' => $user_id,
        //                 'idea_id' => $idea_id,
        //             ]);
        //         }
        //     }
        // }

        // // Generate comments for ideas
        // foreach (Idea::all() as $idea) {
        //     Comment::factory(5)->existing()->create(['idea_id' => $idea->id]);
        // }
    // }
    }
}
