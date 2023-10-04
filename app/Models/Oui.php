<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oui extends Model
{
    use HasFactory;

    protected $fillable = [
        'registry',
        'assignment',
        'organization_name',
        'organization_address',
    ];
}
