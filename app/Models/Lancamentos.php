<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lancamentos extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='lancamentos';
    protected $fillable=['moeda_id', 'tipo_id', 'status_id', 'user_id', 'codigo', 'valor', 'valido', 'solicitacao_id'];
    protected $dates=['deleted_at'];

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    public function moeda()
    {
        return $this->belongsTo(Moedas::class, 'moeda_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function solicitacao()
    {
        return $this->belongsTo(User::class, 'solicitacao_id');
    }
}
