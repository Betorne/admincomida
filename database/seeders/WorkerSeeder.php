<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Worker;
use Faker\Factory as Faker;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
	 $faker = Faker::create('es_CL');
        $companyIds = Company::pluck('id')->all();

        for ($i = 0; $i < 50; $i++) {
            Worker::create([
                'name'       => $faker->name,
                'rut'        => $faker->unique()->numerify('########-#'),
                'email'      => $faker->optional(0.8)->safeEmail,
                'address'    => $faker->optional(0.7)->address,
                'phone'      => $faker->optional(0.9)->phoneNumber,
                'company_id' => $faker->randomElement($companyIds),
            ]);
        }
    }
}
