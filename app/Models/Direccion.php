<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion  extends Model
{
    use HasFactory;

    protected $table='direccion';

    protected $guarded =[];

    protected $fillable = [
        'direccion',	
        'barrio',	
        'id_usuario' ,
        'id_municipio'
    ];

    public $timestamps = false;

    protected $primaryKey = 'id_direccion';
}
