<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $fillable = ['espacio_id', 'usuario_id', 'estado', 'fecha', 'hora_inicio', 'hora_fin', 'precio_total'];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function espacio()
    {
        return $this->belongsTo(Espacio::class, 'espacio_id');
    }
}