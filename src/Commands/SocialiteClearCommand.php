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
        $this->file = $file;
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
        if ($this->file->exists($this->getExtendSocialitePath())) {
            $this->file->delete($this->getExtendSocialitePath());
        }

        if ($this->file->exists($this->getProviderPath())) {
            $this->file->delete($this->getProviderPath());
        }

        $this->info('clear successfully');
    }

    private function getExtendSocialitePath()
    {
        return dirname(__DIR__) . '/ExtendSocialite/' . $this->providerName . '.php';
    }

    private function getProviderPath()
    {
        return dirname(__DIR__) . '/SocialiteProvider/' . $this->providerName .'ExtendSocialite.php';
    }
}
