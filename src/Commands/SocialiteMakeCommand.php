<?php

namespace LaravelSocialiteApi\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Foundation\Composer;

class SocialiteMakeCommand extends Command
{
    use AppNamespaceDetectorTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-socialite-api:make
                            {socialite_provider_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a easy way to get oauth user info based on socialite provider';

    private $providerName;

    /**
     * Create a new command instance.
     *
     * @return void
     */
     public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();
        $this->files = $files;
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
        $this->makeSocialiteProvider();
        $this->makeSocialiteListener();
        $this->composer->dumpAutoloads();
    }

    private function initSocialiteProvider()
    {
        $this->providerName = studly_case(strtolower($this->argument('socialite_provider_name')));
        $gitName = ucwords(snake_case($this->providerName, '-'), '-');
        if (!class_exists("SocialiteProviders\\{$this->providerName}\\{$this->providerName}ExtendSocialite")) {
            throw new \Exception("SocialiteProviders\/{$gitName} does not installed please install it properly from http://socialiteproviders.github.io/#providers");
        }
    }

    private function makeSocialiteProvider()
    {
        $path = $this->getProviderPath();
        if ($this->files->exists($path)) {
            throw new \Exception("provider already exists");
        }
        $this->files->put($path, $this->compileStub('provider'));
        $this->info('socialite provider created successfully.');

    }

    private function makeSocialiteListener()
    {
        $path = $this->getExtendSocialitePath();
        if ($this->files->exists($path)) {
            throw new \Exception("listener alreay exists");
        }
        $this->files->put($path, $this->compileStub('socialite'));
        $this->info('socialite listener created successfully.');

    }

    protected function compileStub($type)
    {
        if ($type === 'provider') {
            $stub = $this->files->get(dirname(__DIR__) . '/stubs/provider.stub');
        } 

        if ($type === 'socialite') {
            $stub = $this->files->get(dirname(__DIR__) . '/stubs/extend_socialite.stub');
        }
        $stub = str_replace('{{ provider_name }}', $this->providerName, $stub);
        $stub = str_replace('{{ base_namespace }}', app()->getNamespace(), $stub);
        return $stub;
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
