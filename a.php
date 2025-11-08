<?php
use App\Models\Specialization;
$especialidad_csv="PRODUCCION AGROPECUARIA";


$buscar = function($register) use ($especialidad_csv){
    $especialidad_db = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $register->name));
    return $especialidad_csv==$especialidad_db;
};


Specialization::all()->first($buscar($especialidad_csv));

