<?php

namespace App\Models\App;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Treatment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = 'app.treatments';

    protected $cascadeDeletes = ['treatmentDetails'];

    public function treatmentDetails()
    {
        return $this->hasMany(TreatmentDetail::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

}
