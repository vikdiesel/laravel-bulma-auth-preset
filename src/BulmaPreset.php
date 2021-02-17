<?php


namespace LaravelBulmaAuthPreset\Package;

use Illuminate\Support\Arr;


class BulmaPreset extends Preset
{
	public static function install()
	{
		static::updatePackages();
		static::removeNodeModules();
	}

	/**
	 * Update the given package array.
	 *
	 * @param  array  $packages
	 * @return array
	 */
	protected static function updatePackageArray(array $packages)
	{
		return [
			'bulma' => '^0.9.0',
			'sass-loader' => '^11.0.1',
			'sass' => '^1.32.7',
       ] + Arr::except($packages, ['bootstrap']);
	}
}
