<?php

namespace SaadeMotion\Photofolio\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Portifolio extends Model
{
    protected $table = 'portifolios';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'visibility_password',
        'status',
        'visibility'
    ];

    public function category()
    {
        return $this->belongsTo('\SaadeMotion\Photofolio\Database\Models\Category');
    }

    public static function boot()
    {
        parent::boot();
        
        /* Delete this portifolio contents */
        static::deleting(function ($portifolio) {
            $dir = storage_path('app/public/'.$portifolio->slug);
            if (is_dir($dir)) {
                rrmdir($dir);
            }
        });
    }
}
