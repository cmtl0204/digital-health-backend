<?php

namespace Database\Seeders\Develop;

use App\Models\App\Catalogue;
use App\Models\App\ClinicalHistory;
use App\Models\App\Patient;
use App\Models\App\Product;
use App\Models\Authentication\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSeeder extends Seeder
{
    public function run()
    {
        $this->createProductTypesCatalogues();
        $this->createSectorTypeCatalogues();
        $this->createPhysicalActivityCatalogues();
        $this->createTypeFootCatalogues();
        $this->createUnitCatalogues();
        $this->createProducts();
        $this->createPatients();
        $this->createClinicalHistories();
        $this->createReferenceValues();
        $this->createFraminghamTable();
        $this->createRisksTable();
    }

    private function createPatients()
    {
        foreach (User::where('id', '>', 2)->get() as $user) {
            Patient::factory()->create(['user_id' => $user->id]);
        }
    }

    private function createSectorTypeCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        Catalogue::factory(4)->sequence(
            [
                'name' => 'NORTE',
                'type' => $catalogues['sector_location']['type'],
            ],
            [
                'name' => 'CENTRO',
                'type' => $catalogues['sector_location']['type'],
            ],
            [
                'name' => 'SUR',
                'type' => $catalogues['sector_location']['type'],
            ],
            [
                'name' => 'VALLES',
                'type' => $catalogues['sector_location']['type'],
            ],
        )->create();
    }

    private function createPhysicalActivityCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        Catalogue::factory(3)->sequence(
            [
                'code' => '1',
                'name' => 'SEDENTARIA',
                'type' => $catalogues['physical_activity']['type'],
            ],
            [
                'code' => '2',
                'name' => 'MODERADA',
                'type' => $catalogues['physical_activity']['type'],
            ],
            [
                'code' => '3',
                'name' => 'INTENSA',
                'type' => $catalogues['physical_activity']['type'],
            ]
        )->create();
    }

    private function createTypeFootCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        Catalogue::factory(6)->sequence(
            [
                'code' => '1',
                'name' => 'AYUNO',
                'type' => $catalogues['food_type']['type'],
            ],
            [
                'code' => '2',
                'name' => 'DESAYUNO',
                'type' => $catalogues['food_type']['type'],
            ],
            [
                'code' => '3',
                'name' => 'MEDIA MAÑANA',
                'type' => $catalogues['food_type']['type'],
            ],
            [
                'code' => '4',
                'name' => 'ALMUERZO',
                'type' => $catalogues['food_type']['type'],
            ],
            [
                'code' => '5',
                'name' => 'MEDIA TARDE',
                'type' => $catalogues['food_type']['type'],
            ],
            [
                'code' => '6',
                'name' => 'CENA ',
                'type' => $catalogues['food_type']['type'],
            ]
        )->create();
    }

    private function createUnitCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        Catalogue::factory(2)->sequence(
            [
                'code' => '1',
                'name' => 'kg',
                'description' => 'kilogramos',
                'type' => $catalogues['unit_type']['type'],
            ],
            [
                'code' => '2',
                'name' => 'g',
                'description' => 'gramos',
                'type' => $catalogues['unit_type']['type'],
            ],
        )->create();
    }

    private function createProductTypesCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogue.json"), true);
        Catalogue::factory(18)->sequence(
            [
                'name' => 'VERDURAS',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'FRUTAS',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'CEREALES SIN GRASA',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'CEREALES CON GRASA',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'LEGUMINOSAS',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'A.O.A MUY BAJOS EN GRASA',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'A.O.A.BAJO EN GRASA',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'A.O.A.MODERADOS EN GRASA',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'A.O.A.ALTO EN GRASA',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'LECHE DESCREMADA',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'LECHE ENTERA',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'LECHE CON AZUCAR',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'ACEITES Y GRASAS',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'AZUCARES SIN GRASA',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'AZUCARES CON GRASA',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'ALIMENTOS LIBRES EN ENERGIA',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'BEBIDAS ALCOHOLICAS',
                'type' => $catalogues['product_type']['type'],
            ],
            [
                'name' => 'PRODUCTOS YAKULT',
                'type' => $catalogues['product_type']['type'],
            ],
        )->create();
    }

    private function createProducts()
    {
//        Product::factory(100)->create();
        DB::select("insert into app.products(type_id,name,quantity,unit,gross_weight,net_weight,energy,protein,
                         lipids,carbohydrates,fiber,vitamin_a,ascorbic_acid,folic_acid,iron,potassium,glycemic_index,
                         glycemic_load)
values
   (1,	'Acelga cruda',	'2',	'taza',	120,	98,	22,	2.2,	0.1,	4.3,	3.6,	310.9,	29.5,	14.8,	2.5,	749.8,	64,	2.7),
(1,	'Acelga picada cocida',	'0.5',	'taza',	72,	72,	19,	1.9,	0.1,	3.9,	2.1,	275.8,	17.9,	10.1,	1.4,	654.5,	64,	2.5),
(1,	'Alcachofa mediana cocida',	'1',	'pieza',	120,	48,	25,	1.4,	0.2,	5.7,	4.1,	0.5,	3.6,	42.7,	0.3,	137.3,	null,	null),
(1,	'Apio cocido',	'0.75',	'taza',	113,	113,	20,	0.9,	0.2,	4.5,	1.8,	29.3,	6.9,	24.8,	0.5,	319.5,	null,	null),
(1,	'Apio crudo',	'1.5',	'taza',	152,	135,	22,	0.9,	0.2,	4,	2.5,	29.7,	4.2,	48.5,	0.3,	350.6,	null,	null),
(1,	'Arúgula, cruda',	'4',	'taza',	80,	80,	20,	2.1,	0.5,	2.9,	3.5,	95.2,	12,	77.6,	1.2,	295.2,	null,	null),
(1,	'Berenjena picada cocida',	'1',	'taza',	99,	99,	35,	0.8,	0.2,	8.6,	2.5,	2,	1.3,	13.9,	0.4,	245.4,	null,	null),
(1,	'Berro crudo',	'2',	'taza',	68,	56,	34,	1.3,	0.1,	0.7,	0.3,	46.3,	6.7,	35.7,	1.2,	100.4,	null,	null),
(1,	'Remolacha cruda',	'0.25',	'pieza',	43,	39,	19,	0.8,	0.1,	4.3,	0.3,	0.8,	7.8,	36.4,	0.6,	131,	null,	null),
(1,	'Remolacha cruda rallada',	'0.25',	'taza',	38,	38,	18,	0.8,	0.1,	4.1,	0.3,	0.8,	7.5,	34.9,	0.6,	125.6,	null,	null),
(1,	'Brócoli cocido',	'0.5',	'taza',	92,	92,	26,	2.7,	0.4,	4.6,	2.7,	127.4,	68.4,	46,	0.8,	268.9,	null,	null),
(1,	'Brócoli crudo',	'1',	'taza',	88,	71,	19,	2.1,	0.3,	3.7,	2.1,	110.2,	66.4,	50.2,	0.6,	231.7,	null,	null),
(1,	'Calabacita alargada cruda',	'1',	'pieza',	111,	91,	21,	1.6,	0.1,	3.4,	1.4,	12.3,	11.8,	23.7,	0.5,	183.9,	null,	null),
(1,	'Calabacita redonulla cruda',	'1',	'pieza',	100,	79,	18,	1.4,	0.1,	2.9,	1.2,	10.7,	10.3,	20.5,	0.4,	159.6,	null,	null),
(1,	'Calabacita de Castilla cocida',	'0.5',	'taza',	110,	110,	22,	0.8,	0.1,	5.4,	1.2,	275,	5.2,	9.9,	0.6,	253,	null,	null),
(1,	'Cebolla blanca rebanada',	'0.5',	'taza',	58,	58,	23,	0.6,	0.1,	5.4,	1,	0,	4.3,	10.9,	0.1,	84,	null,	null),
(1,	'Cebolla cocida',	'0.25',	'taza',	53,	53,	23,	0.7,	0.1,	5.3,	0.7,	0,	2.7,	7.9,	0.1,	87,	null,	null),
(1,	'Cebolla morada rebanada',	'0.5',	'taza',	58,	58,	20,	0.5,	0.1,	4.4,	0.7,	0,	6.3,	null,	0.8,	90.3,	null,	null),
(1,	'Cebollita en salmuera',	'0.5',	'taza',	95,	95,	24,	0.9,	0.2,	6.7,	1.6,	0,	0,	0,	0,	0,	null,	null),
(1,	'Champiñon cocido entero',	'0.5',	'taza',	78,	78,	20,	2.8,	0.3,	3.2,	1.4,	0,	0,	15.6,	0.2,	308.9,	null,	null),
(1,	'Champiñon cocido rebanado',	'0.5',	'taza',	70,	70,	18,	2.5,	0.2,	2.8,	1.3,	0,	0,	14,	0.2,	277.2,	null,	null),
(1,	'Champiñon crudo entero',	'1',	'taza',	96,	93,	20,	2.9,	0.3,	3.1,	0.9,	0,	2,	14.9,	0.5,	296.1,	null,	null),
(1,	'Champíñon crudo rebanado',	'1.5',	'taza',	105,	105,	23,	3.2,	0.4,	3.4,	1.1,	0,	2.2,	16.8,	0.5,	333.9,	null,	null),
(1,	'Arveja cocida sin vaina',	'0.25',	'taza',	40,	40,	34,	2.1,	0.1,	6.1,	2.2,	16,	5.7,	25.2,	0.6,	108.4,	48,	2.9),
(1,	'Arveja cocida con vaina',	'0.5',	'taza',	73,	28,	22,	1.5,	0.1,	4,	1.4,	10.5,	11,	17.9,	0.4,	67.2,	48,	1.9),
(1,	'Cilantro picado crudo',	'2',	'taza',	120,	120,	28,	2.6,	0.6,	4.4,	3.4,	404.4,	32.4,	74.4,	2.1,	625.2,	null,	null),
(1,	'Col cocida picada',	'0.5',	'taza',	75,	75,	17,	1,	0,	4.1,	1.4,	3,	28.1,	22.5,	0.1,	147,	null,	null),
(1,	'Col cruda picada',	'2',	'taza',	140,	112,	27,	1.4,	0.2,	6,	2.6,	6.7,	47,	63.8,	0.6,	275.2,	null,	null),
(1,	'Col morada cruda picada',	'1',	'taza',	70,	56,	17,	0.8,	0.1,	4.1,	1.2,	31.4,	31.9,	10.1,	0.4,	136.1,	null,	null),
(1,	'Col de Bruselas cocida',	'3',	'pieza',	63,	63,	23,	1.6,	0.3,	4.5,	1.6,	24.6,	39.1,	37.8,	0.8,	199.5,	null,	null),
(1,	'Coliflor cocida',	'1',	'taza',	125,	125,	28,	2.3,	0.6,	5.1,	2.9,	1.3,	55.4,	55,	0.4,	177.4,	null,	null),
(1,	'Coliflor cruda',	'2',	'taza',	200,	80,	20,	1.6,	0.1,	4.2,	2,	0.8,	37.1,	45.6,	0.4,	242.4,	null,	null),
(1,	'Coliflor verde cocida',	'0.5',	'taza',	68,	68,	22,	2.1,	2.1,	4.2,	2.2,	4.7,	49,	27.7,	0.5,	187.7,	null,	null),
(1,	'Coliflor verde cruda',	'2',	'taza',	128,	78,	24,	2.3,	2.3,	4.8,	2.5,	6.2,	68.8,	44.5,	0.6,	234.2,	null,	null),
(1,	'Colinabo crudo',	'90',	'g',	90,	66,	22,	1.1,	1.1,	4.1,	1.4,	0.3,	40.7,	null,	0.3,	230,	null,	null),
(1,	'Cozarón de alcachofa crudo',	'1',	'pieza',	25,	25,	16,	0.6,	0.6,	4.1,	0.3,	3,	1.5,	18.5,	0.2,	84.8,	null,	null),
(1,	'Corazón de lechuga crudo',	'1',	'pieza',	130,	124,	12,	1.2,	1.2,	4.4,	1.9,	43.2,	6.2,	67.9,	0.6,	197.6,	null,	null),
(1,	'Corazón de palmito crudo',	'3',	'pieza',	99,	99,	27,	2.4,	2.4,	4.5,	2.4,	0,	9,	39,	3.1,	174,	null,	null),
(1,	'Vainita cruda',	'3',	'taza',	150,	129,	22,	1.6,	1.6,	4.3,	4,	139.3,	8.4,	183.2,	1.1,	405.1,	null,	null),
(1,	'Espárragos crudos',	'6',	'pieza',	90,	90,	22,	2.3,	2.3,	3.8,	2.8,	49,	10,	131,	0.7,	144,	null,	null),
(1,	'Espinaca cocida',	'0.5',	'taza',	90,	90,	21,	2.7,	2.7,	3.4,	3.2,	471.6,	8.8,	131.1,	3.2,	419,	null,	null),
(1,	'Espinaca cruda picada',	'2',	'taza',	120,	120,	28,	3.4,	3.4,	4.4,	2.6,	562.8,	33.7,	232.8,	3.3,	669.6,	null,	null),
(1,	'Germen de lenteja crudo',	'0.25',	'taza',	19,	19,	20,	1.7,	1.7,	4.3,	null,	0.4,	3.2,	19.3,	0.6,	62,	null,	null),
(1,	'Germen de soya cocido',	'0.333333333333333',	'taza',	31,	31,	25,	2.7,	1.4,	2.1,	0.3,	0.6,	2.6,	25.1,	0.4,	111.3,	null,	null),
(1,	'Granos de choclo crudo',	'2',	'cuchara',	21,	21,	18,	0.7,	0.2,	4,	0.6,	1.9,	0.4,	9.7,	0.1,	56.7,	54,	2.2),
(1,	'Haba verde',	'4',	'pieza',	32,	32,	23,	1.8,	0.2,	3.7,	1.3,	5.8,	10.6,	30.7,	0.6,	80,	55,	2.1),
(1,	'Hojas de amaranto cocidas',	'100',	'g',	100,	100,	21,	2.1,	0.2,	4.1,	null,	139,	41.1,	57,	2.3,	641,	null,	null),
(1,	'Hojas de amaranto crudas',	'6',	'hojas',	84,	84,	19,	2.1,	0.3,	3.4,	null,	122.6,	36.4,	71.4,	1.9,	513.2,	null,	null),
(1,	'Hojas de dientes de león',	'50',	'g',	50,	45,	24,	1.2,	0.3,	4.1,	0.8,	49.1,	15.8,	null,	1.4,	178.7,	null,	null),
(1,	'Hojas de remolacha,  crudas',	'2',	'hojas',	64,	64,	14,	1.4,	0.1,	2.8,	2.4,	202.2,	19.2,	9.6,	1.6,	487.7,	null,	null),
(1,	'Hojas de remolacha, hervida',	'0.5',	'taza',	72,	72,	19,	1.9,	0.1,	3.9,	2.1,	603.4,	17.9,	10.1,	1.4,	654.5,	null,	null),
(1,	'Hongos porrtobello crudo',	'1',	'pieza',	84,	81,	21,	2,	0.2,	4.1,	1.2,	0,	0,	17.9,	0.5,	394.4,	null,	null),
(1,	'Hongos shiitake deshidratados',	'1',	'pieza',	4,	4,	11,	0.3,	0,	2.7,	0.4,	0,	0.1,	5.9,	0.1,	55.2,	null,	null),
(1,	'Hongos crudos',	'1',	'taza',	70,	63,	17,	2,	0.3,	2.8,	1.6,	0,	1.9,	13.2,	2.7,	233.1,	null,	null),
(1,	'Tomate',	'120',	'g',	120,	113,	20,	1,	0.2,	4.4,	1.4,	47.4,	14.3,	16.9,	0.3,	267.3,	null,	null),
(1,	'Tomate bola',	'1',	'pieza',	123,	108,	19,	1,	0.2,	4.2,	1.3,	45.5,	13.7,	16.2,	0.3,	256.5,	null,	null),
(1,	'Tomate cereza',	'4',	'pieza',	100,	95,	17,	0.8,	0.2,	3.7,	1.1,	39.9,	12.1,	14.3,	0.3,	225.2,	null,	null),
(1,	'Tomate deshidratado',	'5',	'pieza',	10,	10,	23,	1.5,	0.5,	4.3,	2,	5,	5,	0,	0.5,	0,	null,	null),
(1,	'Jugo de tomate',	'0.5',	'taza',	122,	122,	21,	0.9,	0.1,	5.1,	0.5,	27.9,	22.2,	24.3,	0.5,	278.2,	null,	null),
(1,	'Jugo de verduras',	'0.5',	'taza',	121,	121,	23,	0.8,	0.1,	5.5,	1,	94.4,	33.5,	25.4,	0.5,	233.5,	null,	null),
(1,	'Jugo de zanahoria',	'0.25',	'taza',	59,	59,	24,	0.6,	0.1,	5.5,	0.5,	564,	5,	2.4,	0.3,	172.2,	null,	null),
(1,	'Lechuga',	'3',	'taza',	141,	135,	23,	1.7,	0.4,	4.5,	2.8,	392.5,	32.5,	184.1,	1.3,	334.3,	null,	null),
(1,	'Lengua de vaca',	'110',	'g',	110,	99,	27,	2,	0.7,	3.2,	0.8,	198,	47.5,	null,	2.4,	386.1,	null,	null),
(1,	'Lenteja germinada cocida',	'0.25',	'taza',	19,	19,	19,	1.7,	0.1,	4.1,	null,	0.4,	2.4,	12.9,	0.6,	54.7,	null,	null),
(1,	'Malva',	'100',	'g',	100,	85,	34,	4.1,	0.5,	3.3,	0.8,	255,	29.8,	null,	1.7,	null,	null,	null),
(1,	'Mezcla de verduras congeladas, cocidas sin sal',	'0.5',	'taza',	46,	46,	30,	1.3,	0.1,	4.6,	2,	97.4,	1.5,	8.6,	0.4,	76.9,	null,	null),
(1,	'Nabo cocido',	'150',	'g',	150,	99,	22,	0.7,	0.1,	5,	2,	0,	11.5,	8.9,	0.2,	175.2,	null,	null),
(1,	'Nopal cocido',	'1',	'taza',	149,	149,	22,	2,	0.1,	4.9,	3,	32.8,	7.9,	4.5,	0.7,	291,	null,	null),
(1,	'Nopal crudo',	'2',	'pieza',	140,	134,	22,	1.8,	0.1,	4.5,	3.2,	30.9,	12.5,	4,	0.8,	345.4,	null,	null),
(1,	'Nopal crudo de cambray',	'4',	'pieza',	100,	100,	27,	1.7,	0.3,	2.9,	3.5,	0,	0,	0,	0,	0,	null,	null),
(1,	'Palmito, enlatado',	'1',	'pieza',	33,	33,	30,	0.8,	0.2,	1.5,	0.8,	0,	2.6,	12.9,	1,	58.4,	null,	null),
(1,	'Pepinillos crudos',	'0.333333333333333',	'taza',	80,	80,	23,	1.1,	1,	3.3,	0,	0,	0,	0,	2.1,	0,	null,	null),
(1,	'Pepinillos dulces',	'1',	'cuchara',	15,	15,	20,	0.1,	0.1,	5.3,	0.2,	2,	0,	0,	0.1,	4,	null,	null),
(1,	'Pepino con cáscara rebanado',	'1',	'taza',	104,	104,	16,	0.7,	0.1,	3.8,	0.5,	5.2,	2.9,	7.3,	0.3,	152.9,	null,	null),
(1,	'Perejil crudo picado',	'1',	'taza',	60,	60,	22,	1.8,	0.5,	3.8,	2,	252.6,	80,	91.2,	3.7,	332.4,	null,	null),
(1,	'Pimiento amarillo crudo chico',	'1',	'pieza',	75,	64,	17,	0.7,	0.1,	4,	0.6,	6.4,	116.9,	16.6,	0.3,	135,	null,	null),
(1,	'Pimiento cocido',	'0.5',	'taza',	68,	68,	19,	0.6,	0.1,	4.6,	0.8,	40,	51,	11,	0.3,	113,	null,	null),
(1,	'Pimiento fresco',	'1',	'taza',	60,	60,	17,	0.5,	0.1,	3.8,	1.1,	38.4,	54,	13.2,	0.3,	106.8,	null,	null),
(1,	'Pimiento rojo crudo chico',	'1',	'pieza',	75,	64,	17,	0.7,	0.1,	4,	0.6,	100.1,	81.4,	29.3,	0.3,	134.5,	null,	null),
(1,	'Pimiento verde crudo chico',	'1',	'pieza',	75,	64,	17,	0.7,	0.1,	4,	0.6,	11.5,	51.3,	6.4,	0.2,	111.6,	null,	null),
(1,	'Puerro crudo',	'0.25',	'pieza',	22,	22,	14,	0.3,	0.1,	3.2,	0.9,	18.5,	2.7,	14.2,	0.5,	40.1,	null,	null),
(1,	'Puerro hervido sin sal',	'0.5',	'pieza',	62,	62,	19,	0.5,	0.1,	4.7,	0.6,	25.4,	2.6,	14.9,	0.7,	53.9,	null,	null),
(1,	'Puré de tomate enlatado',	'0.25',	'taza',	63,	63,	24,	1,	0.1,	5.6,	1.5,	16.3,	6.6,	6.9,	1.1,	274.4,	null,	null),
(1,	'Rábano crudo rebanado',	'1',	'taza',	116,	104,	17,	0.7,	0.1,	3.5,	1.7,	0,	15.5,	26.1,	0.4,	243.3,	null,	null),
(1,	'Romerito crudo',	'120',	'g',	120,	72,	26,	2.6,	0.1,	3.5,	0.7,	112,	2.9,	null,	1.8,	null,	null,	null),
(1,	'Salsa de chile',	'0.5',	'taza',	115,	115,	28,	1.2,	0.2,	5.2,	2.8,	4.6,	2.3,	0,	0.6,	234.6,	null,	null),
(1,	'Setas cocidas',	'0.5',	'taza',	78,	78,	21,	2.5,	0.3,	3.4,	2,	0,	null,	null,	null,	null,	null,	null),
(1,	'Setas crudas',	'100',	'g',	100,	85,	23,	2.7,	0.3,	3.7,	2.1,	0,	2.6,	17.9,	3.7,	314.5,	null,	null),
(1,	'Tomate verde',	'5',	'pieza',	100,	86,	21,	0.9,	0.2,	3.9,	2.1,	1.7,	1.7,	null,	0.4,	175.4,	null,	null),
(1,	'Tomatitos (tomatiles)',	'75',	'g',	75,	65,	26,	2.3,	0.1,	4.1,	0.8,	112.6,	29.7,	null,	4.5,	131.6,	null,	null),
(1,	'Verdura (mexcla) congelada, cocida sin sal',	'0.5',	'taza',	46,	46,	30,	1.3,	0.1,	4.6,	2,	97.4,	1.5,	8.6,	0.4,	76.9,	null,	null),
(1,	'Xoconostle',	'3',	'pieza',	102,	71,	18,	0.1,	0.3,	3.7,	1.6,	1.4,	15.7,	null,	0.2,	null,	null,	null),
(1,	'Yemitas (hongos) crudas',	'2',	'taza',	160,	160,	27,	4.8,	1.7,	6.4,	3.6,	0,	6.1,	null,	6,	null,	null,	null),
(1,	'Yerbamora cruda',	'50',	'g',	50,	41,	21,	2,	0.3,	3.6,	0.6,	13.9,	49.2,	null,	3.7,	null,	null,	null),
(1,	'Zanahoria miniatura cruda',	'4',	'pieza',	60,	60,	21,	0.4,	0.1,	4.9,	1.7,	414,	1.6,	16.2,	0.5,	142.2,	47,	2.3),
(1,	'Zanahoria picada cruda',	'0.5',	'taza',	64,	64,	26,	0.6,	0.2,	4.3,	1.8,	534.4,	3.8,	12.2,	0.2,	204.8,	47,	2),
(1,	'Zanahoria rallada cruda',	'0.5',	'taza',	55,	55,	23,	0.5,	0.1,	4.1,	1.5,	459.3,	3.2,	10.5,	0.2,	176,	47,	1.9)");
    }

    private function createClinicalHistories()
    {
        foreach (Patient::get() as $patient) {
            ClinicalHistory::factory(5)->sequence(
                [
                    'patient_id' => $patient->id,
                    'registered_at' => '2022-01-01'
                ],
                [
                    'patient_id' => $patient->id,
                    'registered_at' => '2022-02-01'
                ],
                [
                    'patient_id' => $patient->id,
                    'registered_at' => '2022-03-01'
                ],
                [
                    'patient_id' => $patient->id,
                    'registered_at' => '2022-04-01'
                ],
                [
                    'patient_id' => $patient->id,
                    'registered_at' => '2022-05-01'
                ],
            )->create();
        }
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
