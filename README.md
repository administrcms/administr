# Basic usage

* Install using composer:
```
composer require administrcms/administr
```

* Register the Service Provider (in config/app.php or in app/Providers/AppServiceProvider.php):
```php
// in app.php
'providers' => [
    // ...
    Administr\Providers\AdministrServiceProvider::class,
    // ...
],

// in AppServiceProvider
public function register()
{
    $this->app->register(\Administr\Providers\AdministrServiceProvider::class);
}

```

* Publish assets, configs, migrations and etc.
```
php artisan vendor:publish --provider="Administr\Providers\AdministrServiceProvider"
```

* Migrate the base tables
```
php artisan migrate
```