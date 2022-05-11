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
            'basalMetabolicRate' => ['nullable','numeric','min:200', 'max:10000'],
            'boneMass' => ['nullable','numeric','min:0', 'max:4'],
            'breathingFrequency' => ['nullable','numeric','min:10', 'max:900'],
            'diastolic' => ['nullable','numeric','min:10', 'max:300'],
            'glucose' => ['nullable','numeric','min:10', 'max:1000'],
            'hdlCholesterol' => ['nullable','numeric','min:10', 'max:100'],
            'heartRate' => ['nullable','numeric','min:10', 'max:900'],
            'height' => ['nullable','numeric','min:1.3', 'max:2.5'],
            'isSmoke' => ['nullable','boolean'],
            'isDiabetes' => ['nullable','boolean'],
            'ldlCholesterol' => ['nullable','numeric','min:10', 'max:500'],
            'metabolicAge' => ['nullable','numeric','min:10', 'max:100'],
            'neckCircumference' => ['nullable','numeric','min:20', 'max:90'],
            'percentageBodyFat' => ['nullable','numeric','min:10', 'max:90'],
            'muscleMass' => ['nullable','numeric','min:0', 'max:90'],
            'percentageBodyWater' => ['nullable','numeric','min:20', 'max:90'],
            'percentageVisceralFat' => ['nullable','numeric','min:1', 'max:90'],
            'systolic' => ['nullable','numeric','min:10', 'max:300'],
            'totalCholesterol' => ['nullable','numeric','min:20', 'max:2000'],
            'waistCircumference' => ['nullable','numeric','min:30', 'max:150'],
            'weight' => ['nullable','numeric','min:20', 'max:500'],
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
