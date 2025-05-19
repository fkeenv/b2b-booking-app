<?php

namespace Database\Factories;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for generating Staff model instances.
 *
 * Note: The polymorphic fields 'staffable_id' and 'staffable_type' 
 * should be explicitly set when using this factory, typically in seeders,
 * because they depend on the related model (Transportation or Accommodation).
 */
class StaffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Staff::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Creates or associates a User for 'user_id'
            'user_id' => User::factory(),

            // Polymorphic relation - to be set explicitly in seeder
            'staffable_id' => null,
            'staffable_type' => null,

            // Staff member's name
            'name' => $this->faker->name,

            // Unique email for staff
            'email' => $this->faker->unique()->safeEmail,

            // Optional phone number
            'phone' => $this->faker->optional()->phoneNumber,
        ];
    }
}
