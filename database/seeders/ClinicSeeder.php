<?php

namespace Database\Seeders;

use App\Models\Clinic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinics = [
            [
                'name' => 'Медичний центр "Гармонія"',
                'region' => 'Київська область',
                'city' => 'Київ',
                'address' => 'вул. Хрещатик, 15',
                'phone_number' => '0441234567',
                'email' => 'info@harmony-clinic.ua',
            ],
            [
                'name' => 'Центр здоров\'я "Сім\'я"',
                'region' => 'Львівська область',
                'city' => 'Львів',
                'address' => 'вул. Шевченка, 22',
                'phone_number' => '0321234567',
                'email' => 'family@health-lviv.ua',
            ],
            [
                'name' => 'Клініка "Добробут"',
                'region' => 'Одеська область',
                'city' => 'Одеса',
                'address' => 'вул. Дерибасівська, 10',
                'phone_number' => '0481234567',
                'email' => 'contact@dobrobut.od.ua',
            ],
            [
                'name' => 'Медичний центр "Альфа"',
                'region' => 'Харківська область',
                'city' => 'Харків',
                'address' => 'вул. Сумська, 5',
                'phone_number' => '0571234567',
                'email' => 'info@alpha-health.kh.ua',
            ],
            [
                'name' => 'Клініка "Здоров\'я+"',
                'region' => 'Дніпропетровська область',
                'city' => 'Дніпро',
                'address' => 'пр. Гагаріна, 34',
                'phone_number' => '0561234567',
                'email' => 'healthplus@dnipro.ua',
            ],
        ];

        foreach ($clinics as $clinic) {
            Clinic::create($clinic);
        }
    }
}
