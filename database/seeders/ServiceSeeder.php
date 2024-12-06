<?php

namespace Database\Seeders;


use App\Models\Service;
use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Консультація кардіолога',
                'description' => 'Діагностика та лікування серцево-судинних захворювань.',
                'price' => 500.00,
                'specialization' => 'Кардіологія',
            ],
            [
                'name' => 'Консультація терапевта',
                'description' => 'Первинна консультація лікаря терапевта.',
                'price' => 300.00,
                'specialization' => 'Терапія',
            ],
            [
                'name' => 'Консультація хірурга',
                'description' => 'Огляд і підготовка до хірургічного втручання.',
                'price' => 700.00,
                'specialization' => 'Хірургія',
            ],
            [
                'name' => 'Прийом стоматолога',
                'description' => 'Профілактика та лікування захворювань зубів.',
                'price' => 400.00,
                'specialization' => 'Стоматологія',
            ],
            [
                'name' => 'Консультація дерматолога',
                'description' => 'Лікування та профілактика шкірних захворювань.',
                'price' => 350.00,
                'specialization' => 'Дерматологія',
            ],
            [
                'name' => 'Консультація педіатра',
                'description' => 'Огляд та діагностика захворювань у дітей.',
                'price' => 400.00,
                'specialization' => 'Педіатрія',
            ],
            [
                'name' => 'Офтальмологічний огляд',
                'description' => 'Діагностика зору та лікування очних захворювань.',
                'price' => 450.00,
                'specialization' => 'Офтальмологія',
            ],
            [
                'name' => 'Неврологічний огляд',
                'description' => 'Лікування неврологічних захворювань.',
                'price' => 500.00,
                'specialization' => 'Неврологія',
            ],
            [
                'name' => 'Гінекологічний огляд',
                'description' => 'Профілактичний огляд і діагностика.',
                'price' => 600.00,
                'specialization' => 'Гінекологія',
            ],
            [
                'name' => 'Онкологічна консультація',
                'description' => 'Рання діагностика та лікування онкологічних захворювань.',
                'price' => 800.00,
                'specialization' => 'Онкологія',
            ],
            [
                'name' => 'Ендокринологічний огляд',
                'description' => 'Діагностика гормональних розладів.',
                'price' => 700.00,
                'specialization' => 'Ендокринологія',
            ],
            [
                'name' => 'Консультація психіатра',
                'description' => 'Лікування психічних розладів.',
                'price' => 600.00,
                'specialization' => 'Психіатрія',
            ],
            [
                'name' => 'Консультація алерголога',
                'description' => 'Виявлення алергічних реакцій.',
                'price' => 400.00,
                'specialization' => 'Алергологія',
            ],
            [
                'name' => 'Огляд ревматолога',
                'description' => 'Діагностика ревматологічних захворювань.',
                'price' => 450.00,
                'specialization' => 'Ревматологія',
            ],
            [
                'name' => 'Огляд отоларинголога',
                'description' => 'Діагностика захворювань вуха, горла, носа.',
                'price' => 500.00,
                'specialization' => 'Отоларингологія',
            ],
            [
                'name' => 'Масаж спини',
                'description' => 'Розслаблюючий та лікувальний масаж.',
                'price' => 350.00,
                'specialization' => 'Терапія',
            ],
            [
                'name' => 'Лазерна епіляція',
                'description' => 'Процедура видалення волосся за допомогою лазера.',
                'price' => 2000.00,
                'specialization' => 'Дерматологія',
            ],
            [
                'name' => 'УЗД органів черевної порожнини',
                'description' => 'Діагностика внутрішніх органів.',
                'price' => 800.00,
                'specialization' => 'Терапія',
            ],
            [
                'name' => 'Рентген легенів',
                'description' => 'Дослідження грудної клітки.',
                'price' => 500.00,
                'specialization' => 'Кардіологія',
            ],
            [
                'name' => 'МРТ голови',
                'description' => 'Детальне обстеження головного мозку.',
                'price' => 3000.00,
                'specialization' => 'Неврологія',
            ],
        ];

        foreach ($services as $service) {
            $specialization = Specialization::where('name', $service['specialization'])->first();

            if ($specialization) {
                Service::updateOrCreate(
                    ['name' => $service['name']],
                    [
                        'description' => $service['description'] ?? null,
                        'price' => $service['price'],
                        'specialization_id' => $specialization->id,
                    ]
                );
            }
        }
    }
}
