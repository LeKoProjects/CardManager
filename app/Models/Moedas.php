<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moedas extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='moedas';
    protected $fillable=['moeda', 'abreviacao'];
    protected $dates=['deleted_at'];

    public function lancamento()
    {
        return $this->belongsTo(Lancamentos::class, 'moeda_id');
    }
}
