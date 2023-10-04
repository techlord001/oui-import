<?php

namespace App\Console\Commands;

use App\Models\Oui;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportOuiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:oui-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import IEEE OUI JSON data into the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'http://standards-oui.ieee.org/oui/oui.csv';
        $response = Http::get($url);

        collect(str_getcsv($response->body(), "\n")) // Split by lines
            ->skip(1) // Skip the header row if it exists
            ->map(function ($row) {
                $row = str_getcsv($row);

                Oui::create([
                    'registry' => $row[0] ?? null,
                    'assignment' => $row[1] ?? null,
                    'organization_name' => $row[2] ?? null,
                    'organization_address' => $row[3] ?? null,
                ]);
            });

        $this->info('IEEE OUI data imported successfully.');
    }
}
