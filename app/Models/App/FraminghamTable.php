<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FraminghamTable extends Model
{
    use HasFactory;

    protected $table = 'app.framingham_tables';

    public function calculateRisk($sex, $age, $score)
    {
        if ($sex === 'MALE') {
            switch ($score) {
                case 0:
                {
                    if ($age >= 30 && $age <= 34) {

                        break;
                    }
                }
            }
        }
    }
}
