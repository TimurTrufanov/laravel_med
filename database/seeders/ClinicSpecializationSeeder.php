<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClinicSpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = Specialization::pluck('id')->toArray();

        $clinics = Clinic::all();

        foreach ($clinics as $clinic) {
            $randomSpecializations = array_rand(array_flip($specializations), rand(2, 5));
            $clinic->specializations()->sync($randomSpecializations);
        }
    }
}
