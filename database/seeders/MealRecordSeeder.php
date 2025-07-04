<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\MealRecord;
use App\Models\Worker;
use App\Models\ServiceType;
use Carbon\Carbon;
class MealRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run()
    {
        // Obtener todos los trabajadores y tipos de servicio
        $workers = Worker::all();
        $services = ServiceType::all();

        if ($workers->isEmpty() || $services->isEmpty()) {
            $this->command->info('Asegúrate de tener trabajadores y tipos de servicio en la BD antes de ejecutar MealRecordSeeder.');
            return;
        }

        // Generar 200 registros de ejemplo
        for ($i = 0; $i < 200; $i++) {
            $worker = $workers->random();
            $service = $services->random();

            // Fecha aleatoria entre hace 30 días y hoy
            $registeredAt = Carbon::now()->subDays(rand(0, 30))
                                      ->subHours(rand(0, 23))
                                      ->subMinutes(rand(0, 59));

            MealRecord::create([
                'worker_id'       => $worker->id,
                'service_type_id' => $service->id,
                'registered_at'   => $registeredAt,
            ]);
        }

        $this->command->info('Seeded 200 meal records.');
    }
}
