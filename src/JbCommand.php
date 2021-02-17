<?php

namespace LaravelBulmaAuthPreset\Package;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class JbCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jb:bulma-preset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Bulma auth preset';

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
	    BulmaPreset::install();

	    $this->copyFiles('views');
	    $this->copyFiles('views/auth');
	    $this->copyFiles('views/auth/passwords');
	    $this->copyFiles('views/components');
	    $this->copyFiles('views/layouts');
	    $this->copyFiles('sass', ['app.scss']);

	    $this->copyFile('webpack.mix.js');

	    $this->info('Bulma scaffolding installed successfully.');
	    $this->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
    }

    protected function copyFiles($subDirectory = '', $only = null) {
        $filesystem = new Filesystem;
        $filesystem->makeDirectory(resource_path($subDirectory), 0755, true, true);

        $resFiles = $filesystem->files(__DIR__.'/stubs/' . $subDirectory);

        foreach ( $resFiles as $res_file ) {
            if (!empty($only)) {
                if (array_search($res_file->getFilename(), $only) === false) {
                    continue;
                }
            }
            $targetFilename = $res_file->getFilename();
            $stubExtPos = strrpos($targetFilename, '.stub');

            if ($stubExtPos !== false) {
                $targetFilename = substr($targetFilename, 0, $stubExtPos) . '.php';
            }

            $targetFullPath = resource_path($subDirectory . '/' . $targetFilename);

            if ($filesystem->exists($targetFullPath)) {
                $this->info('File [' . $subDirectory . '/' . $targetFilename . '] already exists');
                $this->info('Feel free to overwrite on new installs');

                if ( $this->confirm( 'Overwrite?', true ) ) {
                    $filesystem->copy($res_file->getRealPath(), $targetFullPath);
                } else {
                    $this->line('Skipped');
                }
            } else {
                $filesystem->copy($res_file->getRealPath(), $targetFullPath);
            }
        }
    }

    protected function copyFile($file) {
        $filesystem = new Filesystem;
        $targetFullPath = base_path($file);

        if ($filesystem->exists($targetFullPath)) {
            $this->info('File [' . $file . '] already exists');
            $this->info('Feel free to overwrite on new installs');

            if ( $this->confirm( 'Overwrite?', true ) ) {
                $filesystem->copy(__DIR__ . '/stubs/' . $file, $targetFullPath);
            } else {
                $this->line('Skipped');
            }
        } else {
            $filesystem->copy(__DIR__ . '/stubs/' . $file, $targetFullPath);
        }
    }
}
