<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Staff;
use App\Models\Transportation;
use App\Models\Accommodation;

/**
 * Class StaffSeeder
 *
 * Seeds Staff records linked to Transportation or Accommodation entities
 * for a limited set of users based on their user ID parity.
 *
 * Even user IDs get Transportation staff records.
 * Odd user IDs get Accommodation staff records.
 */
class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Retrieves up to 10 users (or creates a default user if none exist)
     * and seeds Staff data accordingly.
     */
    public function run(): void
    {
        $users = User::factory()->count(10)->create();

        foreach ($users as $user) {
            if ($user->id % 2 === 0) {
                // Even user ID: seed Transportation staff
                $this->seedModel(Transportation::class, 'phone', $user);
            } else {
                // Odd user ID: seed Accommodation staff
                $this->seedModel(Accommodation::class, 'contact', $user);
            }
        }
    }

    /**
     * Seeds Staff records for the given model class and user.
     *
     * @param  string  $modelClass   Fully qualified model class (Transportation or Accommodation)
     * @param  string  $contactField Field name to use as phone/contact in Staff record
     * @param  User    $user         The user to associate the staff record with
     * @return void
     */
    private function seedModel(string $modelClass, string $contactField, User $user): void
    {
        $model = (new $modelClass)::first();

        $email = $this->generateEmail($model, $user->name);

        Staff::create([
            'user_id' => $user->id,
            'staffable_id' => $model->id,
            'staffable_type' => $modelClass,
            'email' => $email,
            'name' => "{$model->name} Staff",
            'phone' => $model->{$contactField},
        ]);
    }

    /**
     * Generates a unique staff email based on the model type, entity ID, and user ID.
     *
     * @param Model $model
     * @param string $name name property of user
     * @return string Generated unique email
     */
    private function generateEmail(Model $model, string $name): string
    {
        $name = str_replace(' ', '', strtolower($name));
        return "{$name}@example.test"; // TO DO: this must be replaced with the org's domain
    }
}
