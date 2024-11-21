<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('uk_UA');

        $clinics = Clinic::all();
        $specializations = Specialization::all()->pluck('id');

        foreach (range(1, 50) as $i) {
            $user = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'date_of_birth' => $faker->dateTimeBetween('-70 years', '-25 years')->format('Y-m-d'),
                'gender' => $faker->randomElement(['чоловічий', 'жіночий']),
                'address' => $faker->address,
                'phone_number' => $faker->numerify('##########'),
                'role_id' => 2,
            ]);

            $doctor = Doctor::create([
                'user_id' => $user->id,
                'clinic_id' => $clinics->random()->id,
                'position' => $faker->jobTitle,
                'bio' => $faker->realText(200),
                'appointment_duration' => $faker->randomElement([5, 10, 15, 20, 30, 45, 60]),
            ]);

            $doctor->specializations()->sync($specializations->random(rand(1, 3))->toArray());
        }
    }
}
