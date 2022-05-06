<?php

namespace App\Http\Requests\V1\App\ClinicalHistories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClinicalHistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'basalMetabolicRate' => ['min:200', 'max:10000'],
            'boneMass' => ['min:0', 'max:4'],
            'breathingFrequency' => ['min:10', 'max:900'],
            'diastolic' => ['min:10', 'max:300'],
            'glucose' => ['min:10', 'max:1000'],
            'hdlCholesterol' => ['min:10', 'max:100'],
            'heartRate' => ['min:10', 'max:900'],
            'height' => ['min:1.3', 'max:2.5'],
            'isSmoke' => ['boolean'],
            'isDiabetes' => ['boolean'],
            'ldlCholesterol' => ['min:10', 'max:500'],
            'metabolicAge' => ['min:10', 'max:100'],
            'neckCircumference' => ['min:20', 'max:90'],
            'percentageBodyFat' => ['min:10', 'max:90'],
            'muscleMass' => ['min:0', 'max:90'],
            'percentageBodyWater' => ['min:20', 'max:90'],
            'percentageVisceralFat' => ['min:1', 'max:90'],
            'systolic' => ['min:10', 'max:300'],
            'totalCholesterol' => ['min:20', 'max:2000'],
            'waistCircumference' => ['min:30', 'max:150'],
            'weight' => ['min:20', 'max:500'],
        ];
    }

    public function attributes()
    {
        return [
            'basalMetabolicRate' => 'tasa metabólica basal',
            'boneMass' => 'masa ósea',
            'breathingFrequency' => 'frecuencia respiratoria',
            'diastolic' => 'diastólica',
            'glucose' => 'glucosa',
            'hdlCholesterol' => 'colesterol HDL',
            'heartRate' => 'frecuencia cardíaca',
            'height' => 'estatura',
            'isSmoke' => 'diabetes',
            'isDiabetes' => 'fumador',
            'ldlCholesterol' => 'colesterol LDL',
            'metabolicAge' => 'edad metabólica',
            'neckCircumference' => 'masa muscular',
            'percentageBodyFat' => 'circunferencia cuello',
            'muscleMass' => 'porcentaje de grasa corporal',
            'percentageBodyWater' => 'porcentaje de agua corporal',
            'percentageVisceralFat' => 'porcentaje de grasa visceral',
            'systolic' => 'sistólica',
            'totalCholesterol' => 'colesterol total',
            'waistCircumference' => 'circunferencia cintura',
            'weight' => 'peso',
        ];
    }
}
