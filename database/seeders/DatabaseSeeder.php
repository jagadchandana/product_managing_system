<?php


namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        DB::table('hotels')->insert([
                ['name' => 'Hotel Blue', 'location' => 'Colombo'],
                ['name' => 'Hotel Green', 'location' => 'Kandy'],
            ]);
        DB::table('halls')->insert([
                [
                    'hotel_id' => 1,
                    'name_en' => 'Grand Ballroom',
                    'name_fr' => 'Grande Salle',
                    'location_en' => 'Colombo',
                    'location_fr' => 'Colombo',
                    'max_guests' => 300,
                    'reservation_date' => '2025-10-01',
                    'menu_price_1' => 100.00,
                    'menu_price_2' => 150.00,
                    'menu_price_3' => 200.00
                ],
                [
                    'hotel_id' => 2,
                    'name_en' => 'Emerald Hall',
                    'name_fr' => 'Salle Émeraude',
                    'location_en' => 'Kandy',
                    'location_fr' => 'Kandy',
                    'max_guests' => 200,
                    'reservation_date' => '2025-10-02',
                    'menu_price_1' => 120.00,
                    'menu_price_2' => 170.00,
                    'menu_price_3' => 220.00
                ]
            ]);
        DB::table('customers')->insert([
                ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '0771234567'],
                ['name' => 'Marie Curie', 'email' => 'marie@example.com', 'phone' => '0777654321'],
            ]);
        DB::table('reservations')->insert([
                [
                    'customer_id' => 1,
                    'hall_id' => 1,
                    'reservation_date' => '2025-10-01',
                    'status' => 'waiting'
                ],
                [
                    'customer_id' => 2,
                    'hall_id' => 2,
                    'reservation_date' => '2025-10-02',
                    'status' => 'waiting'
                ]
            ]);
        }
}
