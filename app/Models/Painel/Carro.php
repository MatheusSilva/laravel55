<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carro extends Model {
    use SoftDeletes;
    
     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    protected $visible = ['nome', 'placa'];
    //protected $hidden = ['id', 'placa'];

    protected $guarded = ['id'];
    
    
    static $rules = [
        'nome' => 'required|min:3|max:150',
        'placa' => 'required|min:7|max:7|unique:carros',
    ];
    
    public function getNomeAttribute($nome){
        return strtoupper($nome);
    }
    
    public function getPlacaAttribute($placa){
        return strtolower($placa);
    }
    
    
    public function getChassi(){
        return $this->hasOne('App\Models\Painel\CarrosChassi', 'id_carro');
    }
    
    public function getMarca(){
        return $this->hasMany('App\Models\Painel\MarcasCarro', 'id', 'id_marca');
    }
    
    public function getCores(){
        return $this->belongsToMany('App\Models\Painel\CoresCarro', 'cores_carros', 'id_cor', 'id_carro');
    }
}