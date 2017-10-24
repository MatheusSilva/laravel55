<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Turma extends Model
{
    protected $fillable = ['nome'];


    static $rules = [
        'nome' => 'required|min:2|max:60',
    ];
}