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
			'bulma' => '^0.8.0',
       ] + Arr::except($packages, ['bootstrap']);
	}
}
