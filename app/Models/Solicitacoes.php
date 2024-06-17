<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitacoes extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'titulo', 'mensagem', 'tipo_id'];

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
