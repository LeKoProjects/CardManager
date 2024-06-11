<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moedas extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='moedas';
    protected $fillable=['moeda', 'abreviacao', 'porcentagem'];
    protected $dates=['deleted_at'];

}
