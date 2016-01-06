<?php

namespace LaravelSocialiteApi\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Composer;


class SocialiteClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-socialite-api:clear
                            {socialite_provider_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear registered socialite provider and handle';

    private $file;
    private $composer;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $file, Composer $composer)
    {
        parent::__construct();
        $this->files = $file;
        $this->composer = $composer;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->initSocialiteProvider();
        $this->clear();
        $this->composer->dumpAutoloads();
    }

    private function initSocialiteProvider()
    {
        $this->providerName = studly_case(strtolower($this->argument('socialite_provider_name')));
        $gitName = ucwords(snake_case($this->providerName, '-'), '-');

        if (!class_exists("SocialiteProviders\\{$this->providerName}\\{$this->providerName}ExtendSocialite")) {
            throw new \Exception("SocialiteProviders\\{$gitName} does not installed please check if socilite name correct or install 
                                it properly from http://socialiteproviders.github.io/#providers ");
        }
    }

    private function clear()
    {
        if ($this->files->exists($this->getExtendSocialitePath())) {
            $this->files->delete($this->getExtendSocialitePath());
        }

        if ($this->files->exists($this->getProviderPath())) {
            $this->files->delete($this->getProviderPath());
        }

        $this->info('clear successfully');
    }

    private function getExtendSocialitePath()
    {
        $path = app_path() . '/Services' . '/LaravelSocialiteApi/ExtendSocialite';
        if (!($this->files->isWritable($path))) {
            $this->files->makeDirectory($path, 0755, true ,true);
        }
        return  $path . '/' .$this->providerName . '.php';
    }

    private function getProviderPath()
    {
        $path = app_path() . '/Services' . '/LaravelSocialiteApi/SocialiteProvider';
        if (!($this->files->isWritable($path))) {
            $this->files->makeDirectory($path, 0755, true ,true);
        }
        return  $path . '/' . $this->providerName .'.php';
    }
}
