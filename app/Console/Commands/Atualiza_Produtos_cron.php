<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Produto;
use App\Models\Variacao;
use Carbon\Carbon;

class Atualiza_Produtos_cron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Atualiza_produtos:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualizando estoque de Produtos';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle():void
    {
        $produtos_fornecedor = Http::get("https://api.minhaxbz.com.br:5001/api/clientes/GetListaDeProdutos?cnpj=15603172000127&token=1519778332")->json();
       

        
    }
}
