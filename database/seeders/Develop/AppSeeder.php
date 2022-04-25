<?php

namespace Database\Seeders\Develop;

use App\Models\App\Catalogue;
use App\Models\App\ClinicalHistory;
use App\Models\App\Patient;
use App\Models\Authentication\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSeeder extends Seeder
{
    public function run()
    {
        $this->createSectorTypeCatalogues();
        $this->createPatients();
        $this->createClinicalHistories();
        $this->createReferenceValues();
        $this->createFraminghamTable();
    }

    private function createPatients()
    {
        $user = User::find(3);
        $patient = new Patient();
        $patient->user()->associate($user);
        $patient->save();
    }

    private function createSectorTypeCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory(4)->sequence(
            [
                'name' => 'NORTE',
                'type' => $catalogues['catalogue']['sector_location']['type'],
            ],
            [
                'name' => 'CENTRO',
                'type' => $catalogues['catalogue']['sector_location']['type'],
            ],
            [
                'name' => 'SUR',
                'type' => $catalogues['catalogue']['sector_location']['type'],
            ],
            [
                'name' => 'VALLES',
                'type' => $catalogues['catalogue']['sector_location']['type'],
            ],
        )->create();
    }

    private function createClinicalHistories()
    {
        $patient = Patient::find(1);
        $clinicalHistory = new ClinicalHistory();
        $clinicalHistory->patient()->associate($patient);
        $clinicalHistory->basal_metabolic_rate = 1000;
        $clinicalHistory->blood_pressure = 120;
        $clinicalHistory->breathing_frequency = 200;
        $clinicalHistory->glucose = 50;
        $clinicalHistory->hdl_cholesterol = 45;
        $clinicalHistory->heart_rate = 150;
        $clinicalHistory->height = 1.65;
        $clinicalHistory->is_smoke = false;
        $clinicalHistory->is_diabetes = true;
        $clinicalHistory->ldl_cholesterol = 45;
        $clinicalHistory->metabolic_age = 24;
        $clinicalHistory->neck_circumference = 20;
        $clinicalHistory->percentage_body_fat = 22;
        $clinicalHistory->muscle_mass = 37;
        $clinicalHistory->percentage_body_water = 50;
        $clinicalHistory->bone_mass = 2.4;
        $clinicalHistory->percentage_visceral_fat = 6;
//        $clinicalHistory->registered_at = $request->input('registeredAt');
        $clinicalHistory->registered_at = now();
        $clinicalHistory->total_cholesterol = 200;
        $clinicalHistory->waist_circumference = 35;
        $clinicalHistory->weight = 60;
        $clinicalHistory->save();
    }

    private function createReferenceValues()
    {
        DB::select("insert into app.reference_values(
                                 code,sex,age_min,age_max,weight_min,weight_max,value_min,value_max,interpretation,level)
values
       ('PBF','MALE',18,39,null,null,0,8,'Bajo en grasa',1),
('PBF','MALE',18,39,null,null,9,20,'Normal',2),
('PBF','MALE',18,39,null,null,21,25,'Alto en grasa',3),
('PBF','MALE',18,39,null,null,26,1000000,'Obesidad',4),
('PBF','FEMALE',18,39,null,null,0,20,'Bajo en grasa',1),
('PBF','FEMALE',18,39,null,null,21,33,'Normal',2),
('PBF','FEMALE',18,39,null,null,34,39,'Alto en grasa',3),
('PBF','FEMALE',18,39,null,null,40,1000000,'Obesidad',4),
('PBF','MALE',40,59,null,null,0,11,'Bajo en grasa',1),
('PBF','MALE',40,59,null,null,12,22,'Normal',2),
('PBF','MALE',40,59,null,null,23,38,'Alto en grasa',3),
('PBF','MALE',40,59,null,null,39,1000000,'Obesidad',4),
('PBF','FEMALE',40,59,null,null,0,23,'Bajo en grasa',1),
('PBF','FEMALE',40,59,null,null,24,34,'Normal',2),
('PBF','FEMALE',40,59,null,null,35,40,'Alto en grasa',3),
('PBF','FEMALE',40,59,null,null,41,1000000,'Obesidad',4),
('PBF','MALE',60,99,null,null,0,13,'Bajo en grasa',1),
('PBF','MALE',60,99,null,null,14,25,'Normal',2),
('PBF','MALE',60,99,null,null,26,30,'Alto en grasa',3),
('PBF','MALE',60,99,null,null,31,1000000,'Obesidad',4),
('PBF','FEMALE',60,99,null,null,0,24,'Bajo en grasa',1),
('PBF','FEMALE',60,99,null,null,25,36,'Normal',2),
('PBF','FEMALE',60,99,null,null,37,42,'Alto en grasa',3),
('PBF','FEMALE',60,99,null,null,43,1000000,'Obesidad',4),
('PBW','MALE',null,null,null,null,0,49,'Bajo',1),
('PBW','MALE',null,null,null,null,50,65,'Normal',2),
('PBW','MALE',null,null,null,null,66,1000000,'Alto',3),
('PBW','FEMALE',null,null,null,null,0,44,'Bajo',1),
('PBW','FEMALE',null,null,null,null,45,60,'Normal',2),
('PBW','FEMALE',null,null,null,null,61,1000000,'Alto',3),
('PVF','MALE',null,null,null,null,1,12,'Saludable',1),
('PVF','MALE',null,null,null,null,13,59,'Exceso',2),
('PVF','FEMALE',null,null,null,null,1,12,'Saludable',1),
('PVF','FEMALE',null,null,null,null,13,59,'Exceso',2),
('MM','MALE',18,30,null,null,0,44,'Bajo',1),
('MM','MALE',18,30,null,null,45,56,'Normal',2),
('MM','MALE',18,30,null,null,57,1000000,'Alto',3),
('MM','MALE',31,60,null,null,0,39,'Bajo',1),
('MM','MALE',31,60,null,null,40,50,'Normal',2),
('MM','MALE',31,60,null,null,51,1000000,'Alto',3),
('MM','MALE',61,100,null,null,0,37,'Bajo',1),
('MM','MALE',61,100,null,null,38,57,'Normal',2),
('MM','MALE',61,100,null,null,58,1000000,'Alto',3),
('MM','FEMALE',18,30,null,null,0,34,'Bajo',1),
('MM','FEMALE',18,30,null,null,35,41,'Normal',2),
('MM','FEMALE',18,30,null,null,42,1000000,'Alto',3),
('MM','FEMALE',31,60,null,null,0,32,'Bajo',1),
('MM','FEMALE',31,60,null,null,33,38,'Normal',2),
('MM','FEMALE',31,60,null,null,39,1000000,'Alto',3),
('MM','FEMALE',61,100,null,null,0,27,'Bajo',1),
('MM','FEMALE',61,100,null,null,28,33,'Normal',2),
('MM','FEMALE',61,100,null,null,34,1000000,'Alto',3),
('BM','MALE',null,null,0,64,0,2.65,'Bajo',1),
('BM','MALE',null,null,0,64,2.66,2.66,'Normal',2),
('BM','MALE',null,null,0,64,2.67,10000000,'Alto',3),
('BM','MALE',null,null,65,95,0,3.28,'Bajo',1),
('BM','MALE',null,null,65,95,3.29,3.29,'Normal',2),
('BM','MALE',null,null,65,95,3.3,10000000,'Alto',3),
('BM','MALE',null,null,96,100,0,3.68,'Bajo',1),
('BM','MALE',null,null,96,100,3.69,3.69,'Normal',2),
('BM','MALE',null,null,96,100,3.7,10000000,'Alto',3),
('BM','FEMALE',null,null,0,49,0,1.94,'Bajo',1),
('BM','FEMALE',null,null,0,49,1.95,1.95,'Normal',2),
('BM','FEMALE',null,null,0,49,1.96,10000000,'Alto',3),
('BM','FEMALE',null,null,50,75,0,2.39,'Bajo',1),
('BM','FEMALE',null,null,50,75,2.4,2.4,'Normal',2),
('BM','FEMALE',null,null,50,75,2.41,10000000,'Alto',3),
('BM','FEMALE',null,null,76,100,0,2.94,'Bajo',1),
('BM','FEMALE',null,null,76,100,2.95,2.95,'Normal',2),
('BM','FEMALE',null,null,76,100,2.96,10000000,'Alto',3)");
    }

    private function createFraminghamTable()
    {
        DB::select("insert into app.framingham_tables(
                                 code,sex,value_min,value_max,score)
                                 values
('AGE','MALE',0,34,-1),
('AGE','MALE',35,39,0),
('AGE','MALE',40,44,1),
('AGE','MALE',45,49,2),
('AGE','MALE',50,54,3),
('AGE','MALE',55,59,4),
('AGE','MALE',60,64,5),
('AGE','MALE',65,69,6),
('AGE','MALE',70,74,7),
('AGE','FEMALE',0,34,-9),
('AGE','FEMALE',35,39,-4),
('AGE','FEMALE',40,44,0),
('AGE','FEMALE',45,49,3),
('AGE','FEMALE',50,54,6),
('AGE','FEMALE',55,59,7),
('AGE','FEMALE',60,64,8),
('AGE','FEMALE',65,69,8),
('AGE','FEMALE',70,74,8),
('CHOLESTEROL','MALE',0,159,-3),
('CHOLESTEROL','MALE',160,199,0),
('CHOLESTEROL','MALE',200,239,1),
('CHOLESTEROL','MALE',240,279,2),
('CHOLESTEROL','MALE',270,1000000,3),
('CHOLESTEROL','FEMALE',0,159,-2),
('CHOLESTEROL','FEMALE',160,199,0),
('CHOLESTEROL','FEMALE',200,239,1),
('CHOLESTEROL','FEMALE',240,279,2),
('CHOLESTEROL','FEMALE',270,1000000,3),
('HDL','MALE',0,34,2),
('HDL','MALE',35,44,1),
('HDL','MALE',45,49,0),
('HDL','MALE',50,59,0),
('HDL','MALE',60,1000000,-2),
('HDL','FEMALE',0,34,5),
('HDL','FEMALE',35,44,2),
('HDL','FEMALE',45,49,1),
('HDL','FEMALE',50,59,0),
('HDL','FEMALE',60,1000000,-3),
('BLOOD_PRESSURE','MALE',0,119,0),
('BLOOD_PRESSURE','MALE',120,129,0),
('BLOOD_PRESSURE','MALE',130,139,1),
('BLOOD_PRESSURE','MALE',140,159,2),
('BLOOD_PRESSURE','MALE',160,1000000,3),
('BLOOD_PRESSURE','FEMALE',0,119,-3),
('BLOOD_PRESSURE','FEMALE',120,129,0),
('BLOOD_PRESSURE','FEMALE',130,139,1),
('BLOOD_PRESSURE','FEMALE',140,159,2),
('BLOOD_PRESSURE','FEMALE',160,1000000,3),
('DIABETES','MALE',0,0,0),
('DIABETES','MALE',1,1,2),
('DIABETES','FEMALE',0,0,0),
('DIABETES','FEMALE',1,1,4),
('SMOKE','MALE',0,0,0),
('SMOKE','MALE',1,1,2),
('SMOKE','FEMALE',0,0,0),
('SMOKE','FEMALE',1,1,2)");
    }
}
