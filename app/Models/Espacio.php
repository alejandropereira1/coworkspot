<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Espacio extends Model
{
    use HasFactory;

    protected $table = 'espacios';

    protected $fillable = ['tipo_espacio_id', 'nombre', 'capacidad', 'precio_por_hora', 'piso', 'activo', 'image'];

    public function tipo()
    {
        // Especificar la clave foránea explícitamente
        return $this->belongsTo(TipoEspacio::class, 'tipo_espacio_id');
    }

    public function comodidades()
    {
        return $this->hasMany(Comodidad::class, 'espacio_id');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'espacio_id');
    }
}