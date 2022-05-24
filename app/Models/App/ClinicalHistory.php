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
        'basalMetabolicRate',
        'bloodPressure',
        'boneMass',
        'breathingFrequency',
        'diastolic',
        'glucose',
        'hdlCholesterol',
        'heartRate',
        'height',
        'ice',
        'imc',
        'isDiabetes',
        'isSmoke',
        'ldlCholesterol',
        'metabolicAge',
        'neckCircumference',
        'percentageBodyFat',
        'muscleMass',
        'percentageBodyWater',
        'percentageVisceralFat',
        'registeredAt',
        'systolic',
        'totalCholesterol',
        'waistCircumference',
        'weight',
    ];

    protected $casts = [
        'basal_metabolic_rate' => 'double',
        'blood_pressure' => 'double',
        'breathing_frequency' => 'double',
        'diastolic' => 'double',
        'glucose' => 'double',
        'hdl_cholesterol' => 'double',
        'heart_rate' => 'double',
        'height' => 'double',
        'ice' => 'double',
        'imc' => 'double',
        'is_diabetes' => 'boolean',
        'is_smoke' => 'boolean',
        'ldl_cholesterol' => 'double',
        'metabolic_age' => 'double',
        'neck_circumference' => 'double',
        'percentage_body_fat' => 'double',
        'muscle_mass' => 'double',
        'percentage_body_water' => 'double',
        'bone_mass' => 'double',
        'percentage_visceral_fat' => 'double',
//        'registered_at'=>'double',
        'systolic' => 'double',
        'total_cholesterol' => 'double',
        'waist_circumference' => 'double',
        'weight' => 'double',
    ];

    protected $appends = ['imc', 'ice', 'blood_pressure'];

    // Relationsships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function physicalActivity()
    {
        return $this->belongsTo(Catalogue::class);
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

    public function getBloodPressureAttribute()
    {
//        if ($this->attributes['diastolic'] && $this->attributes['systolic']) {
//            return `$this->attributes['systolic']/$this->attributes['diastolic']`;
//        }
        return null;
    }
}
