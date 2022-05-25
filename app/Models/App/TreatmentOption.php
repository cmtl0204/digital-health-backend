<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentOption extends Model
{
    use HasFactory;

    protected $table = 'app.treatment_options';

    public function treatmentDetail(){
        return $this->belongsTo(TreatmentDetail::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
