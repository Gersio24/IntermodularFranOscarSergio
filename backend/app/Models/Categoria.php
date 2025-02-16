<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';

    public function empresas()
    {
        return $this->belongsToMany(Empresa::class, 'categoriaEmpresa', 'id_categoria', 'id_empresa');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'categoriaServicio', 'id_categoria', 'id_servicio');
    }
}
