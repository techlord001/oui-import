<?php

namespace App\Services;

use App\Models\Oui;
use Illuminate\Support\Facades\Http;

class UpdateOuiData
{
    /**
     * Update the OUI data in the database.
     */
    public function update(): void
    {
        $url = 'http://standards-oui.ieee.org/oui/oui.csv';
        $response = Http::get($url);

        collect(str_getcsv($response->body(), "\n")) // Split by lines
            ->skip(1) // Skip the header row if it exists
            ->map(function ($row) {
                $row = str_getcsv($row);

                Oui::updateOrCreate([
                    'registry' => $row[0] ?? null,
                    'assignment' => $row[1] ?? null,
                    'organization_name' => $row[2] ?? null,
                    'organization_address' => $row[3] ?? null,
                ]);
            });
    }
}