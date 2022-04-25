<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PigeonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pigeon')->insert([
            [
                'name' => 'Antonio',
                'speed' => '70',
                'max_range' => '600',
                'cost' => '2',
                'downtime' => '2'
            ],
            [
                'name' => 'Bonito',
                'speed' => '80',
                'max_range' => '500',
                'cost' => '2',
                'downtime' => '3'
            ],
            [
                'name' => 'Carillo',
                'speed' => '65',
                'max_range' => '1000',
                'cost' => '2',
                'downtime' => '3'
            ],
            [
                'name' => 'Alejandro',
                'speed' => '70',
                'max_range' => '800',
                'cost' => '2',
                'downtime' => '2'
            ],
        ]);
    }
}
