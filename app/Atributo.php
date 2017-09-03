<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atributo extends Model
{
    protected $table = 'variable';

    protected $fillable = [
        'atributo',
        'ayuda',
        'modelo',
        'aplicacion',
        'validacion',
        'orden',
        'tipo',
        'minimo',
        'maximo',
        'valores',
        'dependencia',
        'adhiere',
        'moneda',
        'porcentaje',
        'avanzado',
        'precios_avanzados',
        'cubre',
        'requerido',
        'estado'
    ];

    public function seguros()
    {
        return $this->hasMany('App\Seguro', 'seguro');
    }
}
