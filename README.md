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

