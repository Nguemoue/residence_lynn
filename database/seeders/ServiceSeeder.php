<?php
declare(strict_types=1);
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * Array of available services.
         *
         * This variable holds an associative array where each key is a service name
         * and the corresponding value is an array of service details. The service
         * details typically include information such as the service class, dependencies,
         * and any additional configuration required for the service.
         *
         *
         * @var array<array{name:string,description:string,cover_image:string}> $services
         */
        $services = config('project.services');

        foreach ($services as $service) {
            \App\Models\Service::query()->updateOrCreate([
                'slug'=>str($service['name'])->slug()->toString()
            ],[
                'name' => $service['name'],
                'description' => $service['description'],
                'cover_image' => $service['cover_image'],
            ]);
        }
    }
}
