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
        'adhiere',
        'cubre',
        'estado'
    ];

    public function seguros()
    {
        return $this->hasMany('App\Seguro', 'seguro');
    }
}
