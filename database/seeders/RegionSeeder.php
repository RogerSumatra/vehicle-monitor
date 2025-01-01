<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $regions = [
            [
                'name' => 'Head Office',
                'type' => 'head_office',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Branch Office',
                'type' => 'branch',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mine Site A',
                'type' => 'mine',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mine Site B',
                'type' => 'mine',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mine Site C',
                'type' => 'mine',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mine Site D',
                'type' => 'mine',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mine Site E',
                'type' => 'mine',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mine Site F',
                'type' => 'mine',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            
            
        ];

        Region::insert($regions);
    }
}
