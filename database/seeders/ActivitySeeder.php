<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Feature;
use Illuminate\Support\Carbon;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            [
                'name_en' => 'Desert Safari',
                'name_ar' => 'رحلة سفاري في الصحراء',
                'description_en' => 'Experience the thrill of the desert.',
                'description_ar' => 'استمتع بإثارة الصحراء.',
                'from' => Carbon::now()->addDays(1),
                'to' => Carbon::now()->addDays(2),
                'price' => 150.00,
            ],
            [
                'name_en' => 'Mountain Hiking',
                'name_ar' => 'تسلق الجبال',
                'description_en' => 'A guided hike in the mountains.',
                'description_ar' => 'رحلة مشي إرشادية في الجبال.',
                'from' => Carbon::now()->addDays(3),
                'to' => Carbon::now()->addDays(4),
                'price' => 200.00,
            ],
            [
                'name_en' => 'City Tour',
                'name_ar' => 'جولة في المدينة',
                'description_en' => 'Explore the landmarks of the city.',
                'description_ar' => 'استكشاف معالم المدينة.',
                'from' => Carbon::now()->addDays(5),
                'to' => Carbon::now()->addDays(5)->addHours(5),
                'price' => 75.00,
            ],
        ];

        foreach ($activities as $data) {
            $activity = Activity::create(array_merge($data, ['user_id' => 1]));
            $activity->address()->create([
                'address_line_en' => '123 Main St',
                'address_line_ar' => '١٢٣ شارع رئيسي',
                'city_id' => 1,
                'lat' => '25.276987',
                'long' => '55.296249',
                'zip_code' => '00000',
            ]);
            $features = Feature::inRandomOrder()->take(2)->pluck('id');
            $activity->features()->attach($features);
            $activity->media()->create([
                'name' => 'sample.jpg',
                'path' => 'uploads/activities/sample.jpg',
                'model_type' => Activity::class,
            ]);
        }
    }
}
