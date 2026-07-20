<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comodidad extends Model
{
    use HasFactory;

    protected $table = 'comodidades';
    protected $fillable = ['espacio_id', 'nombre'];

    public function espacio()
    {
        return $this->belongsTo(Espacio::class, 'espacio_id');
    }
}