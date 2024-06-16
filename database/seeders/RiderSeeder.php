<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rider;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RiderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        //
        $rider = User::role('rider')->get();
    
        foreach($rider AS $key => $val){
            Rider::create([
                'user_id' => $val->id,
                'name' => $val->name,
                'notel' => $faker->e164PhoneNumber(),

            ]);
        }
    }
}
