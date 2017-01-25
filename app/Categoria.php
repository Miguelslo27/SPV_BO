<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';

    protected $fillable = [
        'nombre',
        'caracteristicas',
        'icono',
        'estado'
    ];

    public function seguros()
    {
    	return $this->hasMany('App\Seguro', 'categoria');
    }
}
