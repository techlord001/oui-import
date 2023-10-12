<?php

namespace App\Console\Commands;

use App\Models\Oui;
use App\Services\UpdateOuiData;
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

    protected $updateOuiData;

    public function __construct(UpdateOuiData $updateOuiData) {
        $this->updateOuiData = $updateOuiData;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->updateOuiData->update();

        $this->info('IEEE OUI data imported successfully.');
    }
}
