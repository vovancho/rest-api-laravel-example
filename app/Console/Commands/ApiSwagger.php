<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ApiSwagger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:doc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Swagger Generate JSON File';

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
        $swagger = DIRECTORY_SEPARATOR === '/' ? base_path('vendor/bin/swagger') : base_path('vendor/bin/swagger.bat');
        $source = app_path('Http');
        $target = public_path('docs/swagger.json');

        if (!is_dir(public_path('docs/'))) {
            mkdir(public_path('docs/'));
        }

        passthru(" \"{$swagger}\" \"{$source}\" --output \"{$target}\"");
    }
}
