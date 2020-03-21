<?php

namespace Dcat\Admin\Console;

use Dcat\Admin\Admin;
use Illuminate\Console\Command;

class AssetsLinkCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'admin:assets-link';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $basePath = Admin::assets()->getRealPath('@admin');
        $publicPath = public_path($basePath);

        if (! is_dir($publicPath.'/..')) {
            app('files')->makeDirectory($publicPath.'/..', 0755, true, true);
        }

        if (file_exists(public_path($publicPath))) {
            return $this->error("The \"{$basePath}\" directory already exists.");
        }

        $distPath = realpath(__DIR__.'/../../resources/dist');

        $this->laravel->make('files')->link(
            $distPath, $publicPath
        );

        $this->info("The [$basePath] directory has been linked.");
    }
}
