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
        $this->createRisksTable();
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
        ClinicalHistory::factory(5)->sequence(
            [
                'patient_id' => 1,
                'registered_at' => '2022-01-01'
            ],
            [
                'patient_id' => 1,
                'registered_at' => '2022-02-01'
            ],
            [
                'patient_id' => 1,
                'registered_at' => '2022-03-01'
            ],
            [
                'patient_id' => 1,
                'registered_at' => '2022-04-01'
            ],
            [
                'patient_id' => 1,
                'registered_at' => '2022-05-01'
            ],
        )->create();
    }

    private function createReferenceValues()
    {
        DB::select("insert into app.reference_values(
                                 code,gender,age_min,age_max,weight_min,weight_max,value_min,value_max,interpretation,level)
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
('PBW','MALE',null,null,null,null,66,1000000,'Alto',4),
('PBW','FEMALE',null,null,null,null,0,44,'Bajo',1),
('PBW','FEMALE',null,null,null,null,45,60,'Normal',2),
('PBW','FEMALE',null,null,null,null,61,1000000,'Alto',4),
('PVF','MALE',null,null,null,null,1,12,'Saludable',2),
('PVF','MALE',null,null,null,null,13,90,'Exceso',4),
('PVF','FEMALE',null,null,null,null,1,12,'Saludable',2),
('PVF','FEMALE',null,null,null,null,13,90,'Exceso',4),
('MM','MALE',18,30,null,null,0,44,'Bajo',1),
('MM','MALE',18,30,null,null,45,56,'Normal',2),
('MM','MALE',18,30,null,null,57,1000000,'Alto',4),
('MM','MALE',31,60,null,null,0,39,'Bajo',1),
('MM','MALE',31,60,null,null,40,50,'Normal',2),
('MM','MALE',31,60,null,null,51,1000000,'Alto',4),
('MM','MALE',61,100,null,null,0,37,'Bajo',1),
('MM','MALE',61,100,null,null,38,57,'Normal',2),
('MM','MALE',61,100,null,null,58,1000000,'Alto',4),
('MM','FEMALE',18,30,null,null,0,34,'Bajo',1),
('MM','FEMALE',18,30,null,null,35,41,'Normal',2),
('MM','FEMALE',18,30,null,null,42,1000000,'Alto',3),
('MM','FEMALE',31,60,null,null,0,32,'Bajo',1),
('MM','FEMALE',31,60,null,null,33,38,'Normal',2),
('MM','FEMALE',31,60,null,null,39,1000000,'Alto',4),
('MM','FEMALE',61,100,null,null,0,27,'Bajo',1),
('MM','FEMALE',61,100,null,null,28,33,'Normal',2),
('MM','FEMALE',61,100,null,null,34,1000000,'Alto',4),
('BM','MALE',null,null,0,64,0,2.65,'Bajo',1),
('BM','MALE',null,null,0,64,2.66,2.66,'Normal',2),
('BM','MALE',null,null,0,64,2.67,10000000,'Alto',4),
('BM','MALE',null,null,65,95,0,3.28,'Bajo',1),
('BM','MALE',null,null,65,95,3.29,3.29,'Normal',2),
('BM','MALE',null,null,65,95,3.3,10000000,'Alto',4),
('BM','MALE',null,null,96,500,0,3.68,'Bajo',1),
('BM','MALE',null,null,96,500,3.69,3.69,'Normal',2),
('BM','MALE',null,null,96,500,3.7,10000000,'Alto',4),
('BM','FEMALE',null,null,0,49,0,1.94,'Bajo',1),
('BM','FEMALE',null,null,0,49,1.95,1.95,'Normal',2),
('BM','FEMALE',null,null,0,49,1.96,10000000,'Alto',4),
('BM','FEMALE',null,null,50,75,0,2.39,'Bajo',1),
('BM','FEMALE',null,null,50,75,2.4,2.4,'Normal',2),
('BM','FEMALE',null,null,50,75,2.41,10000000,'Alto',4),
('BM','FEMALE',null,null,76,500,0,2.94,'Bajo',1),
('BM','FEMALE',null,null,76,500,2.95,2.95,'Normal',2),
('BM','FEMALE',null,null,76,500,2.96,10000000,'Alto',4)");
    }

    private function createFraminghamTable()
    {
        DB::select("insert into app.framingham_tables(
                                 code,gender,value_min,value_max,score)
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
('SYSTOLIC','MALE',0,119,0),
('SYSTOLIC','MALE',120,129,0),
('SYSTOLIC','MALE',130,139,1),
('SYSTOLIC','MALE',140,159,2),
('SYSTOLIC','MALE',160,1000000,3),
('SYSTOLIC','FEMALE',0,119,-3),
('SYSTOLIC','FEMALE',120,129,0),
('SYSTOLIC','FEMALE',130,139,1),
('SYSTOLIC','FEMALE',140,159,2),
('SYSTOLIC','FEMALE',160,1000000,3),
('DIABETES','MALE',0,0,0),
('DIABETES','MALE',1,1,2),
('DIABETES','FEMALE',0,0,0),
('DIABETES','FEMALE',1,1,4),
('SMOKE','MALE',0,0,0),
('SMOKE','MALE',1,1,2),
('SMOKE','FEMALE',0,0,0),
('SMOKE','FEMALE',1,1,2)");
    }

    private function createRisksTable()
    {
        DB::select("insert into app.risks(
                                 percentage,gender,age_min,age_max,value_min,value_max,interpretation,score,level)
                                 values
(2,'MALE',30,34,0,0,'Riesgo menor al promedio',1,1),
(2,'MALE',30,34,1,1,'Riesgo promedio',1.5,2),
(2,'MALE',30,34,2,2,'Riesgo moderado',2,3),
(2,'MALE',30,34,3,3,'Riesgo moderado',2.5,3),
(2,'MALE',30,34,4,4,'Riesgo moderado',3.5,3),
(2,'MALE',30,34,5,5,'Riesgo elevado',4,4),
(2,'MALE',30,34,6,6,'Riesgo elevado',5,4),
(2,'MALE',30,34,7,7,'Riesgo elevado',6.5,4),
(2,'MALE',30,34,8,8,'Riesgo elevado',8,4),
(2,'MALE',30,34,9,9,'Riesgo elevado',10,4),
(2,'MALE',30,34,10,10,'Riesgo elevado',12.5,4),
(2,'MALE',30,34,11,11,'Riesgo elevado',15.5,4),
(2,'MALE',30,34,12,12,'Riesgo elevado',18.5,4),
(2,'MALE',30,34,13,13,'Riesgo elevado',22.5,4),
(2,'MALE',30,34,14,100000,'Riesgo elevado',26.5,4),
(3,'MALE',35,39,1,1,'Riesgo menor al promedio',1,1),
(3,'MALE',35,39,2,2,'Riesgo menor al promedio',1.3,1),
(3,'MALE',35,39,3,3,'Riesgo promedio',1.7,2),
(3,'MALE',35,39,4,4,'Riesgo moderado',2.3,3),
(3,'MALE',35,39,5,5,'Riesgo moderado',2.6,3),
(3,'MALE',35,39,6,6,'Riesgo moderado',3.3,3),
(3,'MALE',35,39,7,7,'Riesgo elevado',4.3,4),
(3,'MALE',35,39,8,8,'Riesgo elevado',5.3,4),
(3,'MALE',35,39,9,9,'Riesgo elevado',6.7,4),
(3,'MALE',35,39,10,10,'Riesgo elevado',8.3,4),
(3,'MALE',35,39,11,11,'Riesgo elevado',10.3,4),
(3,'MALE',35,39,12,12,'Riesgo elevado',12.3,4),
(3,'MALE',35,39,13,13,'Riesgo elevado',15,4),
(3,'MALE',35,39,14,100000,'Riesgo elevado',17.7,4),
(3,'MALE',40,44,1,1,'Riesgo menor al promedio',1,1),
(3,'MALE',40,44,2,2,'Riesgo menor al promedio',1.3,1),
(3,'MALE',40,44,3,3,'Riesgo menor al promedio',1.7,1),
(3,'MALE',40,44,4,4,'Riesgo promedio',2.3,2),
(3,'MALE',40,44,5,5,'Riesgo moderado',2.6,3),
(3,'MALE',40,44,6,6,'Riesgo moderado',3.3,3),
(3,'MALE',40,44,7,7,'Riesgo elevado',4.3,4),
(3,'MALE',40,44,8,8,'Riesgo elevado',5.3,4),
(3,'MALE',40,44,9,9,'Riesgo elevado',6.7,4),
(3,'MALE',40,44,10,10,'Riesgo elevado',8.3,4),
(3,'MALE',40,44,11,11,'Riesgo elevado',10.3,4),
(3,'MALE',40,44,12,12,'Riesgo elevado',12.3,4),
(3,'MALE',40,44,13,13,'Riesgo elevado',15,4),
(3,'MALE',40,44,14,100000,'Riesgo elevado',17.7,4),
(4,'MALE',45,49,2,2,'Riesgo menor al promedio',1,1),
(4,'MALE',45,49,3,3,'Riesgo menor al promedio',1.3,1),
(4,'MALE',45,49,4,4,'Riesgo menor al promedio',1.8,1),
(4,'MALE',45,49,5,5,'Riesgo menor al promedio',2,1),
(4,'MALE',45,49,6,6,'Riesgo promedio',2.5,2),
(4,'MALE',45,49,7,7,'Riesgo moderado',3.3,3),
(4,'MALE',45,49,8,8,'Riesgo elevado',4,4),
(4,'MALE',45,49,9,9,'Riesgo elevado',5,4),
(4,'MALE',45,49,10,10,'Riesgo elevado',6.3,4),
(4,'MALE',45,49,11,11,'Riesgo elevado',7.8,4),
(4,'MALE',45,49,12,12,'Riesgo elevado',9.3,4),
(4,'MALE',45,49,13,13,'Riesgo elevado',11.3,4),
(4,'MALE',45,49,14,100000,'Riesgo elevado',13.3,4),
(5,'MALE',50,54,3,3,'Riesgo menor al promedio',1,1),
(5,'MALE',50,54,4,4,'Riesgo menor al promedio',1.4,1),
(5,'MALE',50,54,5,5,'Riesgo menor al promedio',1.6,1),
(5,'MALE',50,54,6,6,'Riesgo menor al promedio',2,1),
(5,'MALE',50,54,7,7,'Riesgo promedio',2.6,2),
(5,'MALE',50,54,8,8,'Riesgo moderado',3.2,3),
(5,'MALE',50,54,9,9,'Riesgo elevado',4,4),
(5,'MALE',50,54,10,10,'Riesgo elevado',5,4),
(5,'MALE',50,54,11,11,'Riesgo elevado',6.1,4),
(5,'MALE',50,54,12,12,'Riesgo elevado',7.4,4),
(5,'MALE',50,54,13,13,'Riesgo elevado',9,4),
(5,'MALE',50,54,14,100000,'Riesgo elevado',10.6,4),
(7,'MALE',55,59,4,4,'Riesgo menor al promedio',1,1),
(7,'MALE',55,59,5,5,'Riesgo menor al promedio',1.1,1),
(7,'MALE',55,59,6,6,'Riesgo menor al promedio',1.4,1),
(7,'MALE',55,59,7,7,'Riesgo menor al promedio',1.9,1),
(7,'MALE',55,59,8,8,'Riesgo promedio',2.3,2),
(7,'MALE',55,59,9,9,'Riesgo moderado',2.9,3),
(7,'MALE',55,59,10,10,'Riesgo elevado',3.6,4),
(7,'MALE',55,59,11,11,'Riesgo elevado',4.4,4),
(7,'MALE',55,59,12,12,'Riesgo elevado',5.2,4),
(7,'MALE',55,59,13,13,'Riesgo elevado',6.4,4),
(7,'MALE',55,59,14,100000,'Riesgo elevado',7.6,4),
(8,'MALE',60,64,5,5,'Riesgo menor al promedio',1,1),
(8,'MALE',60,64,6,6,'Riesgo menor al promedio',1.3,1),
(8,'MALE',60,64,7,7,'Riesgo menor al promedio',1.6,1),
(8,'MALE',60,64,8,8,'Riesgo menor al promedio',2,1),
(8,'MALE',60,64,9,9,'Riesgo promedio',2.5,2),
(8,'MALE',60,64,10,10,'Riesgo moderado',3.1,3),
(8,'MALE',60,64,11,11,'Riesgo elevado',3.9,4),
(8,'MALE',60,64,12,12,'Riesgo elevado',4.6,4),
(8,'MALE',60,64,13,13,'Riesgo elevado',5.6,4),
(8,'MALE',60,64,14,100000,'Riesgo elevado',6.6,4),
(10,'MALE',65,69,6,6,'Riesgo menor al promedio',1,1),
(10,'MALE',65,69,7,7,'Riesgo menor al promedio',1.3,1),
(10,'MALE',65,69,8,8,'Riesgo menor al promedio',1.6,1),
(10,'MALE',65,69,9,9,'Riesgo menor al promedio',2,1),
(10,'MALE',65,69,10,10,'Riesgo promedio',2.5,2),
(10,'MALE',65,69,11,11,'Riesgo moderado',3.1,3),
(10,'MALE',65,69,12,12,'Riesgo elevado',3.7,4),
(10,'MALE',65,69,13,13,'Riesgo elevado',4.5,4),
(10,'MALE',65,69,14,100000,'Riesgo elevado',5.3,4),
(13,'MALE',70,74,7,7,'Riesgo menor al promedio',1,1),
(13,'MALE',70,74,8,8,'Riesgo menor al promedio',1.2,1),
(13,'MALE',70,74,9,9,'Riesgo menor al promedio',1.5,1),
(13,'MALE',70,74,10,10,'Riesgo menor al promedio',1.9,1),
(13,'MALE',70,74,11,11,'Riesgo promedio',2.3,2),
(13,'MALE',70,74,12,12,'Riesgo moderado',2.8,3),
(13,'MALE',70,74,13,13,'Riesgo elevado',3.5,4),
(13,'MALE',70,74,14,100000,'Riesgo elevado',4.1,4),
(2,'FEMALE',40,44,0,0,'Riesgo menor al promedio',1,1),
(2,'FEMALE',40,44,1,1,'Riesgo menor al promedio',1,1),
(2,'FEMALE',40,44,2,2,'Riesgo menor al promedio',1.5,1),
(2,'FEMALE',40,44,3,3,'Riesgo menor al promedio',1.5,1),
(2,'FEMALE',40,44,4,4,'Riesgo menor al promedio',2,1),
(2,'FEMALE',40,44,5,5,'Riesgo menor al promedio',2,1),
(2,'FEMALE',40,44,6,6,'Riesgo promedio',2.5,2),
(2,'FEMALE',40,44,7,7,'Riesgo moderado',3,3),
(2,'FEMALE',40,44,8,8,'Riesgo moderado',3.5,3),
(2,'FEMALE',40,44,9,9,'Riesgo elevado',4,4),
(2,'FEMALE',40,44,10,10,'Riesgo elevado',5,4),
(2,'FEMALE',40,44,11,11,'Riesgo elevado',5.5,4),
(2,'FEMALE',40,44,12,12,'Riesgo elevado',6.5,4),
(2,'FEMALE',40,44,13,13,'Riesgo elevado',7.5,4),
(2,'FEMALE',40,44,14,14,'Riesgo elevado',9,4),
(2,'FEMALE',40,44,15,15,'Riesgo elevado',10,4),
(2,'FEMALE',40,44,16,16,'Riesgo elevado',12,4),
(2,'FEMALE',40,44,17,100000,'Riesgo elevado',13.5,4),
(3,'FEMALE',45,49,2,2,'Riesgo menor al promedio',1,1),
(3,'FEMALE',45,49,3,3,'Riesgo menor al promedio',1,1),
(3,'FEMALE',45,49,4,4,'Riesgo menor al promedio',1.3,1),
(3,'FEMALE',45,49,5,5,'Riesgo menor al promedio',1.3,1),
(3,'FEMALE',45,49,6,6,'Riesgo menor al promedio',1.7,1),
(3,'FEMALE',45,49,7,7,'Riesgo promedio',2,2),
(3,'FEMALE',45,49,8,8,'Riesgo moderado',2.3,3),
(3,'FEMALE',45,49,9,9,'Riesgo moderado',2.7,3),
(3,'FEMALE',45,49,10,10,'Riesgo moderado',3.3,3),
(3,'FEMALE',45,49,11,11,'Riesgo moderado',3.7,3),
(3,'FEMALE',45,49,12,12,'Riesgo elevado',4.3,4),
(3,'FEMALE',45,49,13,13,'Riesgo elevado',5,4),
(3,'FEMALE',45,49,14,14,'Riesgo elevado',6,4),
(3,'FEMALE',45,49,15,15,'Riesgo elevado',6.7,4),
(3,'FEMALE',45,49,16,16,'Riesgo elevado',8,4),
(3,'FEMALE',45,49,17,100000,'Riesgo elevado',9,4),
(5,'FEMALE',50,54,6,6,'Riesgo menor al promedio',1,1),
(5,'FEMALE',50,54,7,7,'Riesgo menor al promedio',1.2,1),
(5,'FEMALE',50,54,8,8,'Riesgo menor al promedio',1.4,1),
(5,'FEMALE',50,54,9,9,'Riesgo promedio',1.6,2),
(5,'FEMALE',50,54,10,10,'Riesgo moderado',2,3),
(5,'FEMALE',50,54,11,11,'Riesgo moderado',2.2,3),
(5,'FEMALE',50,54,12,12,'Riesgo moderado',2.6,3),
(5,'FEMALE',50,54,13,13,'Riesgo elevado',3,4),
(5,'FEMALE',50,54,14,14,'Riesgo elevado',3.6,4),
(5,'FEMALE',50,54,15,15,'Riesgo elevado',4,4),
(5,'FEMALE',50,54,16,16,'Riesgo elevado',4.8,4),
(5,'FEMALE',50,54,17,100000,'Riesgo elevado',5.4,4),
(7,'FEMALE',55,59,8,8,'Riesgo menor al promedio',1,1),
(7,'FEMALE',55,59,9,9,'Riesgo menor al promedio',1.1,1),
(7,'FEMALE',55,59,10,10,'Riesgo promedio',1.4,2),
(7,'FEMALE',55,59,11,11,'Riesgo moderado',1.6,3),
(7,'FEMALE',55,59,12,12,'Riesgo moderado',1.9,3),
(7,'FEMALE',55,59,13,13,'Riesgo moderado',2.1,3),
(7,'FEMALE',55,59,14,14,'Riesgo moderado',2.6,3),
(7,'FEMALE',55,59,15,15,'Riesgo moderado',2.9,3),
(7,'FEMALE',55,59,16,16,'Riesgo elevado',3.4,4),
(7,'FEMALE',55,59,17,100000,'Riesgo elevado',3.9,4),
(8,'FEMALE',60,64,9,9,'Riesgo menor al promedio',1,1),
(8,'FEMALE',60,64,10,10,'Riesgo menor al promedio',1.3,1),
(8,'FEMALE',60,64,11,11,'Riesgo promedio',1.4,2),
(8,'FEMALE',60,64,12,12,'Riesgo moderado',1.6,3),
(8,'FEMALE',60,64,13,13,'Riesgo moderado',1.9,3),
(8,'FEMALE',60,64,14,14,'Riesgo moderado',2.3,3),
(8,'FEMALE',60,64,15,15,'Riesgo moderado',2.5,3),
(8,'FEMALE',60,64,16,16,'Riesgo moderado',3,3),
(8,'FEMALE',60,64,17,100000,'Riesgo elevado',5.4,4),
(8,'FEMALE',65,69,9,9,'Riesgo menor al promedio',1,1),
(8,'FEMALE',65,69,10,10,'Riesgo menor al promedio',1.3,1),
(8,'FEMALE',65,69,11,11,'Riesgo menor al promedio',1.4,1),
(8,'FEMALE',65,69,12,12,'Riesgo promedio',1.6,2),
(8,'FEMALE',65,69,13,13,'Riesgo moderado',1.9,3),
(8,'FEMALE',65,69,14,14,'Riesgo moderado',2.3,3),
(8,'FEMALE',65,69,15,15,'Riesgo moderado',2.5,3),
(8,'FEMALE',65,69,16,16,'Riesgo moderado',3,3),
(8,'FEMALE',65,69,17,100000,'Riesgo elevado',5.4,4),
(8,'FEMALE',70,74,9,9,'Riesgo menor al promedio',1,1),
(8,'FEMALE',70,74,10,10,'Riesgo menor al promedio',1.3,1),
(8,'FEMALE',70,74,11,11,'Riesgo menor al promedio',1.4,1),
(8,'FEMALE',70,74,12,12,'Riesgo menor al promedio',1.6,1),
(8,'FEMALE',70,74,13,13,'Riesgo promedio',1.9,2),
(8,'FEMALE',70,74,14,14,'Riesgo moderado',2.3,3),
(8,'FEMALE',70,74,15,15,'Riesgo moderado',2.5,3),
(8,'FEMALE',70,74,16,16,'Riesgo moderado',3,3),
(8,'FEMALE',70,74,17,100000,'Riesgo elevado',5.4,4)
");
    }
}
