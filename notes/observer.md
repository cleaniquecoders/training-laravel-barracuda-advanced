## Observer

Observer, is the inverse of event and listener. Eloquent models fired several events - `retrieved`, `creating`, `created`, `updating`, `updated`, `saving`, `saved`, `deleting`, `deleted`, `restoring`, `restored`.

## Setup

Create observer service provider - `php artisan make:provider ObserverServiceProvider` - and register the provider in `config/app.php` in `providers` key: `App\Providers\ObserverServiceProvider::class,`.

Create `app/Observers/HashslugObserver.php`:

```php
<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class HashslugObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function creating(Model $model)
    {
        if (Schema::hasColumn($model->getTable(), 'hashslug') && is_null($model->hashslug)) {
            $model->hashslug = str_random(64);
        }
    }

    public function saved(Model $model)
    {
        logger()->info($model->toArray());
    }
}
```

Update migration to add `hashslug` field.

```php
$table->string('hashslug', 64);
```

Register observer in `app/Observer/HashslugObserver.php`:

```php
public function boot()
{
    \App\User::observe(\App\Observers\HashslugObserver::class);
}
```

## References

1. [Laravel - Eloquent Observer](https://laravel.com/docs/5.5/eloquent#observers)
2. [Laravel - Eloquent Events](https://laravel.com/docs/5.5/eloquent#events)