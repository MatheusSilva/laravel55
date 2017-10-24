<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class MarcasCarro extends Model
{
    protected $table   = 'marcas_carro';

	protected $visible = ['marca'];
    protected $guarded = ['id'];

    static $rules = [
        'marca'              => 'required|min:3|max:60'
    ];

    public function getMarcaAttribute($marca)
    {
        return strtoupper($marca);
    }
}