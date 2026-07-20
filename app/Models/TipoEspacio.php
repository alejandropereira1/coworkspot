<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEspacio extends Model
{
    use HasFactory;

    protected $table = 'tipos_espacio';

    protected $fillable = ['nombre', 'descripcion'];

    public function espacios()
    {
        // Especificar la clave foránea explícitamente
        return $this->hasMany(Espacio::class, 'tipo_espacio_id');
    }
}