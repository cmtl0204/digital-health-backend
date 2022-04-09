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
            'glucose' => $this->glucose,
            'hdlCholesterol' => $this->hdl_cholesterol,
            'heartRate' => $this->heart_rate,
            'height' => $this->height,
            'imc' => $this->imc,
            'ldlCholesterol' => $this->ldl_cholesterol,
            'metabolicAge' => $this->metabolic_age,
            'neckCircumference' => $this->neck_circumference,
            'percentageBodyFat' => $this->percentage_body_fat,
            'percentageBodyMass' => $this->percentage_body_mass,
            'percentageBodyWater' => $this->percentage_body_water,
            'percentageBoneMass' => $this->percentage_bone_mass,
            'percentageVisceralFat' => $this->percentage_visceral_fat,
            'registeredAt' => $this->registered_at,
            'totalCholesterol' => $this->total_cholesterol,
            'waistCircumference' => $this->waist_circumference,
            'weight' => $this->weight,
        ];
    }
}
