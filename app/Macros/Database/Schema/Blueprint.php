<?php

namespace App\Macros\Database\Schema;

use Illuminate\Database\Schema\Blueprint as DefaultBlueprint;

class Blueprint
{
    public static function registerMacros()
    {
        if (!DefaultBlueprint::hasMacro('addForeign')) {
            DefaultBlueprint::macro('addForeign', function ($key) {
                $this->unsignedInteger($key)->index();
                return $this;
            });
        }

        if (!DefaultBlueprint::hasMacro('referenceOn')) {
            DefaultBlueprint::macro('referenceOn', function ($key, $table, $references = 'id') {
                $this->foreign($key)
                    ->references($references)
                    ->on($table);
                return $this;
            });
        }

        if (!DefaultBlueprint::hasMacro('belongsTo')) {
            DefaultBlueprint::macro('belongsTo', function ($table, $key = null, $references = null) {
                $key        = is_null($key) ? str_singular($table) . '_id' : $key;
                $references = is_null($references) ? 'id' : $references;
                $this->addForeign($key)
                    ->referenceOn($key, $table, $references);
            });
        }
    }
}
