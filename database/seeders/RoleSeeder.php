<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        $roleAdmin = Role::create(['name' => 'admin','guard_name' => 'web']);
        $roleCoach = Role::create(['name' => 'coach','guard_name' => 'web']);
        $roleRider = Role::create(['name' => 'rider','guard_name' => 'web']);
       
        $user = User::find(1);
        $user->assignRole($roleAdmin);

        $opt = [$roleCoach, $roleRider] ;
        $user = User::where('id', '!=', 1)->get();
        foreach($user AS $key => $val){
            $val->assignRole($faker->randomElement($opt));
        }
    }
}
