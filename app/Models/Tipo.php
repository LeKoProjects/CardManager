<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='tipos';
    protected $fillable=['nome', 'porcentagem', 'imagem'];
    protected $dates=['deleted_at'];

    public function lancamento()
    {
        return $this->belongsTo(Lancamentos::class, 'tipo_id');
    }
}