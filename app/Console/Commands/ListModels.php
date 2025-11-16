<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ListModels extends Command
{
    protected $signature = 'report:models';
    protected $description = 'List all models and their columns';

    public function handle()
    {
        $modelPath = app_path('Models');
        $modelFiles = File::allFiles($modelPath);

        foreach ($modelFiles as $file) {
            $modelClass = 'App\\Models\\' . $file->getFilenameWithoutExtension();

            if (class_exists($modelClass)) {
                $model = new $modelClass;

                if (method_exists($model, 'getFillable') && count($model->getFillable()) > 0) {
                    $columns = $model->getFillable();
                } else {
                    // fallback to all table columns
                    $columns = \Schema::getColumnListing($model->getTable());
                }

                $this->info($file->getFilenameWithoutExtension() . ': ' . implode(', ', $columns));
            }
        }
    }
}
