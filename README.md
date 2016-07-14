# Laravel package for the localise.biz api

This package delivers an easy to use interface for fetching and caching assets from the Localise.biz api.

## Table of Contents

- <a href="#installation">Installation</a>
    - <a href="#composer">Composer</a>
    - <a href="#manually">Manually</a>
    - <a href="#laravel">Laravel</a>
- <a href="#configuration">Configuration</a>
    - <a href="#configuration-file">Configuration file</a>
    - <a href="#configuration-values">Configuration values</a>
- <a href="#usage">Usage</a>
    - <a href="#fetch-translation">Fetch translation</a>
    - <a href="#flush-cache">Flush Cache</a>
- <a href="#changelog">Changelog</a>
- <a href="#license">License</a>

## Installation

### Composer

Add PixelPub/Loco to your `composer.json` file.

    "pixelpub/loco":"dev-master"

Run `composer install` to get the latest version of the package.

### Manually

It's recommended that you use Composer, however you can download and install from this repository.

### Laravel

Laravel-Loco comes with a service provider for Laravel.

To register the service provider in your Laravel application, open `config/app.php` and add the following line to the `providers` array:

```php
	...
	Pixelpub\Loco\LocoServiceProvider::class
	...
```

## Configuration

### Configuration file

In order to edit the default package configuration, you can run the following artisan command:

```
php artisan vendor:publish --provider="Pixelpub\Loco\LocoServiceProvider" --tag="config"
```

Once you have done that, you will find the config file at `config/loco.php`.

### Configuration values

- `api` (default: `https://localise.biz/api/export/locale/`)

Localise.biz api url.

- `languages` (default: `['en_US', 'de_DE']`)

An array of the locales available on the Localise.biz api.

- `projects`

An array of key-value pairs, defining the Localise.biz projects including their api key.

- `cache` (default: `database`)

Defining the laravel cache interface, which will contain the assets, fetched from Localise.biz.

## Usage

### Fetch translation

The `LocoServiceProvider.php` is injected via the Loco interface. 

```php
	...
	use Pixelpub\Loco\LocoContract;
	...
    public function translation(Loco $loco)
    {
        return $loco->fetch('my-translation-project', 'en_US');
    }
	...
```

Once you have done this, there is nothing more that you MUST do. Laravel application locale has been set and you can use other locale-dependant Laravel components (e.g. Translation) as you normally do.

### Flush cache

All assets will be fetched one time from the loco api and stored permanently in the cache. If you call the flush method, this package will try to load the assets from loco before actually flushing the cache. If loco api is not available, the current assets will be remain in the cache and an exception is thrown.

```php
    $loco->flush('my-translation-project');
```

### License

This package is licensed under the [MIT license](https://github.com/PixelPub/laravel-loco/blob/master/LICENSE).
