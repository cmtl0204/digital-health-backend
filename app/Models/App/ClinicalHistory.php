<?php

namespace App\Models\App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicalHistory extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $table = 'app.clinical_histories';

    protected $fillable = [
        'height',
        'weight',
    ];

    protected $appends = ['imc', 'ice'];

    // Relationsships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Mutators

    // Scopes
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

    // Getters
    public function getImcAttribute()
    {
        if ($this->attributes['height']) {
            return $this->attributes['weight'] / $this->attributes['height'] * $this->attributes['height'];
        }
        return null;
    }

    public function getIceAttribute()
    {
        if ($this->attributes['height']) {
            return $this->attributes['waist_circumference'] / ($this->attributes['height'] * 100);
        }
        return null;
    }
}
