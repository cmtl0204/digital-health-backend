<?php

namespace App\Models\App;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentOption extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = 'app.treatment_options';

    public function treatmentDetail(){
        return $this->belongsTo(TreatmentDetail::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
