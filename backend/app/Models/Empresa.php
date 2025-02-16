<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre', 
        'cif',
        'telefono',
        'email', 
        'direccion_calle', 
        'direccion_provincia', 
        'direccion_lat', 
        'direccion_lng',
        'poblacion',
        'horario_inicio', 
        'horario_fin',
        'imagen',
        'categorias',
        'servicios',
        'vacantes_historico',
        'puntuacion_profesor',
        'puntuacion_alumno'
    ];

    protected $casts = [
        'categorias' => 'array',
        'servicios' => 'array',
        'vacantes_historico' => 'array',
        'direccion_lat' => 'float',
        'direccion_lng' => 'float',
        'puntuacion_profesor' => 'float',
        'puntuacion_alumno' => 'float'
    ];

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
