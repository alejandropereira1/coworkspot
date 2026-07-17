<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TipoEspacio extends Model
{
    protected $table = 'tipos_espacio';
    protected $fillable = ['nombre', 'descripcion'];

    public function espacios()
    {
        return $this->hasMany(Espacio::class, 'tipo_espacio_id');
    }
}