<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalogue extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $table = 'app.catalogues';

    protected $fillable = [
        'code',
        'description',
        'name',
        'type',
    ];

    // Relationsships
    public function parent()
    {
        return $this->belongsTo(Catalogue::class, 'parent_id', 'core.catalogues');
    }

    public function children()
    {
        return $this->hasMany(Catalogue::class, 'parent_id', 'core.catalogues');
    }

    public function treatmentDetails()
    {
        return $this->hasMany(TreatmentDetail::class,'type_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'type_id');
    }

    // Mutators
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function scopeDescription($query, $description)
    {
        if ($description) {
            return $query->where('description', 'ilike', "%$description%");
        }
    }

    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'ilike', "%$name%");
        }
    }

    public function scopeType($query, $type)
    {
        if ($type) {
            return $query->where('type', $type);
        }
    }

    public function scopeCustomOrderBy($query, $sorts)
    {
        if (!empty($sorts[0])) {
            foreach ($sorts as $sort) {
                $field = explode('-', $sort);
                if (empty($field[0]) && in_array($field[1], $this->fillable)) {
                    $query = $query->orderByDesc($field[1]);
                } else if (in_array($field[0], $this->fillable)) {
                    $query = $query->orderBy($field[0]);
                }
            }
            return $query;
        }
    }
}
