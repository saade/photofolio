<?php

namespace SaadeMotion\Photofolio\Database\Models;

use Illuminate\Database\Eloquent\Model;

class PortifolioItem extends Model
{
    protected $table = 'portifolio_items';

    protected $fillable = [
        'portifolio_id',
        'thumb_url',
        'full_url',
        'original_name',
        'grid_layout',
        'is_hidden',
        'is_cover'
    ];

    public function portifolio()
    {
        return $this->belongsTo(\Photofolio::model('Portifolio'), 'id', 'portifolio_id');
    }
}
