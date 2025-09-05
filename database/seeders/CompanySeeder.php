<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



	 $faker = Faker::create('es_CL');

        for ($i = 0; $i < 10; $i++) {
            Company::create([
                'name'    => $faker->company,
                'rut'     => $faker->unique()->numerify('########-#'),
             ]);
        }
    }
}
