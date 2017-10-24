<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Pai extends Model
{
	protected $visible = ['nome', 'email'];
    protected $guarded = ['id'];

    static $rules = [
        'nome'              => 'required|min:3|max:60',
        'email'              => 'required|min:6|max:60',
    ];

    public function getNomeAttribute($nome){
        return strtoupper($nome);
    }
    
    public function getEmailAttribute($email){
        return strtolower($email);
    }

    public function getPais($pesquisa, $totalItensPorPagina)
    {
        //return $this->where('nome', 'like', '%' . $pesquisa . '%')->get();
        //return Pai::where('nome', 'like', '%' . $pesquisa . '%')->get(); //jeito alternativo
        return $this->where('nome', 'like', '%' . $pesquisa . '%')->paginate($totalItensPorPagina); // com paginação
    }
}
