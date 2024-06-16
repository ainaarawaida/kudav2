<?php

namespace Database\Seeders;

use App\Models\Horse;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HorseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $horse = ['Sakorna','Mawardah','Luhaif','Ablaq','Tuah','Coffee','Sanja','Juwadah','Dakha','Dubai','Baha'];

        foreach($horse as $k => $v){
            Horse::create(
                ['name' => $v]
            );
        }
    }
}
