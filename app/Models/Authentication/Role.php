<?php

namespace App\Models\Authentication;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role
{
    const ADMIN = 'admin';
    const MEDIC = 'medic';
    const PATIENT = 'patient';
}
