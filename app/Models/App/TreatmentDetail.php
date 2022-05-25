<?php

namespace App\Models\App;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = 'app.treatment_details';

    protected $cascadeDeletes = ['treatmentOptions'];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function treatmentOptions()
    {
        return $this->hasMany(TreatmentOption::class);
    }
}
