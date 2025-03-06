<hr>

INSTALAÇÃO ARQUIVO PDF  
REF. https://github.com/barryvdh/laravel-dompdf




<hr>
INSTALAÇÃO CARRINHO DE COMPRAS 
REF. https://github.com/darryldecode/laravelshoppingcart?tab=readme-ov-file#usage

composer require "darryldecode/cart"


CONFIGURAÇÃO

Abrir config/app.php e adicionar a linha abaixo em Service Providers Array.
Darryldecode\Cart\CartServiceProvider::class


Abrir config/app.php  e adicionar a linha abaixo em Aliases
  'Cart' => Darryldecode\Cart\Facades\CartFacade::class


Para liberar configurações total
php artisan vendor:publish --provider="Darryldecode\Cart\CartServiceProvider" --tag="config"

<hr>


INSTALAR GERADOR CÓDIGO DE BARRAS
REFERENCIA: https://github.com/milon/barcode

composer require milon/barcode

insira essas linhas no arquivo config/app.php

'aliases' => [
     ....
     ....
     ....            
     'DNS1D' => Milon\Barcode\Facades\DNS1DFacade::class,
     'DNS2D' => Milon\Barcode\Facades\DNS2DFacade::class,
           ]

