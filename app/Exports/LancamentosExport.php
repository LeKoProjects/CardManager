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
    $lancamentos = Lancamentos::join('moedas as mo', 'lancamentos.moeda_id', '=', 'mo.id')
    ->join('statuses as st', 'lancamentos.status_id', '=', 'st.id')
    ->join('tipos as ti', 'lancamentos.tipo_id', '=', 'ti.id')
    ->whereIn('lancamentos.id', $lancamentosIds)
    ->select('lancamentos.codigo', 'mo.abreviacao', 'lancamentos.valor', 'st.nome as status_nome', 'ti.nome as tipo_nome', 'lancamentos.status_id')
    ->get()
    ->map(function ($lancamento) {
        if ($lancamento->status_id != 2) {
            $lancamento->codigo = substr($lancamento->codigo, 0, 5) . str_repeat('*', strlen($lancamento->codigo) - 5);
        }
        return $lancamento;
    })
    ->makeHidden('status_id'); // Opcional: para ocultar o campo status_id nos resultados finais


    // Retorna uma coleção de dados dos lançamentos
    return $lancamentos;
}
}
