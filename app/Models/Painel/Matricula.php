<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $fillable = ['id_aluno', 'numero'];
}