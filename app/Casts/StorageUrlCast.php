<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Storage;

class StorageUrlCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string                              $key
     * @param  mixed                               $value
     * @param  array                               $attributes
     * @return mixed
     */
    public function get($model, $key, $value, $attributes)
    {
        $disk = 'local';
        if (in_array(env('APP_ENV'), ['staging', 'production'])) {
            $disk = 's3';
        }

        if ($value) {
            $value = substr($value, 0, 1) === '/' ? substr($value, 1) : $value;
        }
        // TEST: deploy

        return $value ? asset(Storage::disk($disk)->url($value)) : $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string                              $key
     * @param  mixed                               $value
     * @param  array                               $attributes
     * @return mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}
