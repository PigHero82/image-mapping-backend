<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageMapping extends Model
{
    use HasFactory;

    protected $fillable = ['detail_mapping_id', 'type', 'name', 'action', 'action_id', 'latLng'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'action_id');
    }

    public function detail_mapping()
    {
        return $this->belongsTo(DetailMapping::class, 'action_id');
    }
}
