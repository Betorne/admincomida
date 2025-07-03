<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoActivateServices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-activate-services';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() {
        $now = now()->format('H:i:s');
        ServiceType::where('auto_activate', true)->each(function ($service) use ($now) {
            $service->active = ($now >= $service->start_time && $now <= $service->end_time);
            $service->save();
        });
    }

}
