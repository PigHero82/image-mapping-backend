<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailMapping extends Model
{
    use HasFactory;

    protected $fillable = ['mapping_id', 'name', 'image', 'width', 'height', 'is_default'];

    public function images()
    {
        return $this->hasMany(ImageMapping::class)->with('product', 'detail_mapping');
    }
}
