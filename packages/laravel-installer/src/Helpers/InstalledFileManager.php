<?php

namespace Froiden\LaravelInstaller\Helpers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class InstalledFileManager
{
    /**
     * Create installed file.
     *
     * @return int
     */
    public function create()
    {
        file_put_contents(storage_path('installed'), '');
        Artisan::call('storage:link');
        Artisan::call('optimize:clear');
        Storage::disk('local')->delete('seeder_logs.json');
    }

    /**
     * Update installed file.
     *
     * @return int
     */
    public function update()
    {
        return $this->create();
    }
}