<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Coach;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        //
        $coach = User::role('coach')->get();
        foreach($coach AS $key => $val){
            Coach::create([
                'user_id' => $val->id,
                'name' => $val->name,
                'notel' => $faker->e164PhoneNumber(),

            ]);
        }
    }
}
