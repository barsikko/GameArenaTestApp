<?php

namespace App\Console\Commands;

use App\Services\ImportService\CategoriesimportService;
use App\Services\ImportService\ImportService;
use App\Services\ImportService\ProductImportService;
use App\Services\ProductService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateDataFromFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from categories.json and products.json to database';

    private $importService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $files = Storage::disk('imports')->allfiles();

        foreach ($files as $file){
            $fileContent = Storage::disk('imports')->get($file);

            if ($file == 'products.json')
                $this->setImportService(new ProductImportService($fileContent));

            if ($file == 'categories.json') 
                $this->setImportService(new CategoriesimportService($fileContent));
        
            $this->importService->handle();
        }
    }

    private function setImportService(ImportService $importService)
    {
        $this->importService = $importService;
    }
}
