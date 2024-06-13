<?php

namespace App\Exports;

use App\Models\Lancamentos;
use Maatwebsite\Excel\Concerns\FromCollection;

class LancamentosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $lancamentosIds;

    public function __construct(array $lancamentosIds)
    {
        $this->lancamentosIds = $lancamentosIds;
    }

    public function collection()
{
    $lancamentosIds = $this->lancamentosIds;

    // Verifica se há IDs válidos antes de prosseguir
    if (empty($lancamentosIds)) {
        return collect(); // Retorna uma coleção vazia
    }

    // Consulta os lançamentos no banco de dados com base nos IDs
    $lancamentos = Lancamentos::whereIn('id', $lancamentosIds)->get();

    // Retorna uma coleção de dados dos lançamentos
    return $lancamentos;
}
}
