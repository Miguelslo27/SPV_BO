<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atributo extends Model
{
    protected $table = 'variable';

    protected $fillable = [
        'atributo',
        'modelo',
        'aplicacion',
        'validacion',
        'orden',
        'tipo',
        'valores',
        'dependencia',
        'adhiere',
        'moneda',
        'porcentaje',
        'cubre',
        'requerido',
        'estado'
    ];

    public function seguros()
    {
        return $this->hasMany('App\Seguro', 'seguro');
    }
}
