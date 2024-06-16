<?php

namespace Database\Seeders;

use App\Models\Time;
use App\Models\Ktime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('Times')->truncate();
        Schema::enableForeignKeyConstraints();

        $time = Time::insert(
                [
                    [
                    'name' => '7:30AM - 8:15AM'
                    ],
                    [
                    'name' => '8:15AM - 9:00AM'
                    ],
                    [
                    'name' => '9:00AM - 9:45AM'
                    ],
                    [
                    'name' => '9:45AM - 10:30AM'
                    ],
                    [
                    'name' => '3:30PM - 4:15PM'
                    ],
                    [
                    'name' => '4:15PM - 5:00PM'
                    ],
                    [
                    'name' => '5:00PM - 5:45PM'
                    ],
                    [
                    'name' => '5:45PM - 10:30PM'
                    ],
    

                ]

        );
      
    }
}
