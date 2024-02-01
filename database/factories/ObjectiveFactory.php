<?php

namespace Database\Factories;

use App\Models\Objective;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObjectiveFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Objective::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::all()->random();
        $team_id = $user->currentTeam->id;
        return [
            'user_id'=>$user->id, //User::factory(),
            'team_id'=>$team_id, // Category::factory(),
            'name'=> $this->faker->sentence(),
            'description'=>$this->faker->paragraph(),
            'due_date'=> $this->faker->dateTimeThisMonth(),
            'key_results'=>$this->faker->paragraph()
        ];
}

}
