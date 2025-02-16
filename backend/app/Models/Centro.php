<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Centro extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'email', 'password', 'direccion', 'telefono', 'poblacion', 'provincia'];

    public function usuarios() {
        return $this->hasMany(User::class);
    }

    public function empresas() {
        return $this->belongsToMany(Categoria::class, 'centros_empresas');
    }
}
