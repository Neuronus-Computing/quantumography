<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Casts\StorageUrlCast;

class EncryptedFile extends Model
{
    protected $fillable = ['user_id', 'path','size','is_paid','amount'];
    /*
     * Manually implement custom casting for the avatar attribute.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return mixed
     */
    public function getAttribute($key)
    {
        if($key == 'size'){
            $size = $this->attributes[$key];
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        $bytes = max($size, 0);
        $pow = floor(log($bytes, 1024));
        $pow = min($pow, count($units) - 1);

        return round($bytes / pow(1024, $pow), 2) . ' ' . $units[$pow];

        }
        return parent::getAttribute($key);
    }
    protected $casts = [
        'path'=>StorageUrlCast::class
    ];
}
