<?php

namespace App\Http\Resources\V1\App\ClinicalHistories;

use Illuminate\Http\Resources\Json\JsonResource;

class ClinicalHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'basalMetabolicRate' => $this->basal_metabolic_rate,
            'bloodPressure' => $this->blood_pressure,
            'breathingFrequency' => $this->breathing_frequency,
//            'diastolic' => $this->diastolic,
            'glucose' => $this->glucose,
            'hdlCholesterol' => $this->hdl_cholesterol,
            'heartRate' => $this->heart_rate,
            'height' => $this->height,
            'ice' => $this->ice,
            'imc' => $this->imc,
            'isDiabetes' => $this->is_diabetes,
            'isSmoke' => $this->is_smoke,
            'ldlCholesterol' => $this->ldl_cholesterol,
            'metabolicAge' => $this->metabolic_age,
            'neckCircumference' => $this->neck_circumference,
            'percentageBodyFat' => $this->percentage_body_fat,
            'muscleMass' => $this->muscle_mass,
            'percentageBodyWater' => $this->percentage_body_water,
            'boneMass' => $this->bone_mass,
            'percentageVisceralFat' => $this->percentage_visceral_fat,
            'registeredAt' => $this->registered_at,
//            'systolic' => $this->systolic,
            'totalCholesterol' => $this->total_cholesterol,
            'waistCircumference' => $this->waist_circumference,
            'weight' => $this->weight,
        ];
    }
}
