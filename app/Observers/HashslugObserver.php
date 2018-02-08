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
