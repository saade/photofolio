<?php

namespace SaadeMotion\Photofolio\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'title',
        'slug'
    ];

    public function portifolios()
    {
        return $this->hasMany('\SaadeMotion\Photofolio\Database\Models\Portifolio', 'category_id', 'id');
    }
}
