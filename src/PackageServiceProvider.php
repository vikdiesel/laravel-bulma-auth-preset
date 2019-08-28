<?php


namespace LaravelBulmaAuthPreset\Package;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\PresetCommand;

class PackageServiceProvider extends ServiceProvider{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		PresetCommand::macro('bulma', function ($command) {
			BulmaPreset::install();

			$this->copyFiles($command, 'views');
			$this->copyFiles($command, 'views/auth');
			$this->copyFiles($command, 'views/auth/passwords');
			$this->copyFiles($command, 'views/components');
			$this->copyFiles($command, 'views/layouts');
			$this->copyFiles($command, 'sass', ['app.scss']);

			$filesystem = new Filesystem;
			$bootstrapJsPath = resource_path('js/bootstrap.js');

			if ($filesystem->exists($bootstrapJsPath)) {
				$bootstrapJsContents = $filesystem->get($bootstrapJsPath);
				if (strpos($bootstrapJsContents, '@lbap-bs-ignore') === false) {
					$bootstrapJsContents = str_replace("require('bootstrap');", "/* Disabled by laravel-bulma-auth-preset @lbap-bs-ignore */\n/* require('bootstrap'); */", $bootstrapJsContents);
					$filesystem->put($bootstrapJsPath, $bootstrapJsContents);
				}
			}

			$command->info('Bulma scaffolding installed successfully.');
			$command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
		});
	}

	protected function copyFiles($command, $subDirectory = '', $only = null) {
		$filesystem = new Filesystem;

		$resFiles = $filesystem->files(__DIR__.'/../resources/' . $subDirectory);

		foreach ( $resFiles as $res_file ) {
			if (!empty($only)) {
				if (array_search($res_file->getFilename(), $only) === false) {
					continue;
				}
			}

			$filename = $subDirectory . '/' . $res_file->getFilename();
			if ($filesystem->exists(resource_path($filename))) {
				if ($command->confirm('File [' . $filename . '] already exists. Overwrite?')) {
					$filesystem->copy($res_file->getRealPath(), resource_path($filename));
				}
			} else {
				$filesystem->copy($res_file->getRealPath(), resource_path($filename));
			}
		}
	}
}
