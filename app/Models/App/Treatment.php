<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $table = 'app.treatments';

    public function treatmentDetails()
    {
        return $this->hasMany(TreatmentDetail::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

}
