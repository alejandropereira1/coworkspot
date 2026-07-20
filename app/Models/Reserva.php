<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'espacio_id',
        'usuario_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'precio_total',
        'estado',
    ];

    public function espacio()
    {
        return $this->belongsTo(Espacio::class, 'espacio_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}