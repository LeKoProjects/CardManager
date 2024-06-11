<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='statuses';
    protected $fillable=['nome'];
    protected $dates=['deleted_at'];

    public function lancamento()
    {
        return $this->belongsTo(Lancamentos::class, 'status_id');
    }

}
