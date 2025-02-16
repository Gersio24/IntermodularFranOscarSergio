<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'cif', 'descripcion',  'imagen', 'notas', 'email', 'direccion_calle', 'direccion_provincia', 'direccion_localidad', 'direccion_lat', 'direccion_lng', 'categorias', 'servicios', 'vacantes', 'horario_inicio', 'horario_fin'];


    public function usuarios() {
        return $this->hasMany(User::class);
    }
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoriaEmpresa', 'id_empresa', 'id_categoria');
    }
    public function centros() {
        return $this->belongsToMany(Centro::class, 'centros_empresas');
    }
}
