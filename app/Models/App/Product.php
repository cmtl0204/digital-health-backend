<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'app.products';

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function scopeTypeId($query, $typeId)
    {
        if ($typeId) {
            return $query->where('type_id', $typeId);
        }
    }
}
