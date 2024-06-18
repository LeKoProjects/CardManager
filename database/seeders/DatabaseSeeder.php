<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'tipo' => '1',
                'celular' => '71999999999',
                'email' => 'admin@anb.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Admin2',
                'tipo' => '2',
                'celular' => '71999999988',
                'email' => 'admin2@anb.com',
                'password' => bcrypt('12345678')
            ],
        ]);

        DB::table('tipos')->insert([
            [
                'nome' => 'XBOX',
                'porcentagem' => '2',
            ],
            [
                'nome' => 'UBER',
                'porcentagem' => '3',
            ],
            [
                'nome' => 'DIVIDA',
                'porcentagem' => '0',
            ],
        ]);

        DB::table('statuses')->insert([
            [
                'nome' => 'Novo',
            ],
            [
                'nome' => 'Adquirir',
            ],
            [
                'nome' => 'Paguei',
            ],
            [
                'nome' => 'Finalizado',
            ],
            [
                'nome' => 'Reservado',
            ]
        ]);

        DB::table('moedas')->insert([
            [
                'moeda' => 'Real',
                'abreviacao' => 'BRL',
            ],
            [
                'moeda' => 'Dolar',
                'abreviacao' => 'USD',
            ],
        ]);


    }
}
