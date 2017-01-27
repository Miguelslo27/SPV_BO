<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atributo extends Model
{
    protected $table = 'variable';

    protected $fillable = [
        'atributo',
        'aplicacion',
        'validacion',
        'tipo',
        'valores',
        'dependencia',
        'adhiere',
        'moneda',
        'cubre',
        'estado'
    ];

    public function seguros()
    {
        return $this->hasMany('App\Seguro', 'seguro');
    }
}
