
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Criando Link </title>

    <!-- Principal CSS do Bootstrap -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Estilos customizados para esse template -->
    <link href="form-validation.css" rel="stylesheet">
  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center" style="background: black;color: white;">
       <a href="/bling"> <img class="d-block mx-auto mb-4" src="https://acertenopresente.com/loja/image/catalog/logo%20nova%20branca.png" alt="" width="150" ></a>
      </div>
      <div class="row">
      <form method="post" action="/bling/pedidos/criar_link" class="needs-validation" novalidate> 
      @csrf 
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Descrição do Pedido</h4>          
              <div class="row">
              
                 <div class="col">                
                   <label for="descricao">Vendedor</label>
                   <input type="text" class="form-control" onChange='javascript:this.value=this.value.toUpperCase();' name="vendedor" id="vendedor" value="" required>
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
                <div class="col">                
                   <label for="descricao">Usuário/Celular</label>
                   <input type="text" class="form-control" name="plataforma" id="plataforma" onChange='javascript:this.value=this.value.toUpperCase();' value="" required>
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
                <div class="col">                
                   <label for="prevista">Data Prevista</label>
                   <input type="date" class="form-control" name="prevista" id="prevista">
                 </div>
          </div>
          <div class="row">

 <br>

                 <div class="col mb-3">
                   <label for="Qt.">Qt</label>
                   <input type="text" class="form-control" name="qt1" id="qt1"  size="3" value="" required>
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
                 <div class="col-6 mb-3">                
                   <label for="descricao">Descrição</label>
                   <input type="text" class="form-control" name="descricao1" id="descricao1" placeholder="Taça Personalizada" value="" required>
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
                 <div class="col-3 mb-3">
                   <label for="valor">Valor Un</label> 
                   <input type="text" class="form-control" name="valor1" id="valor1" placeholder="0,00" value="" required>
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
              </div>

              <div class="row">
                 <div class="col mb-3">
                   <label for="Qt.">Qt</label>
                   <input type="text" class="form-control" name="qt2" id="qt2"  size="3" value="">
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
                 <div class="col-6 mb-3">                
                   <label for="descricao">Descrição</label>
                   <input type="text" class="form-control" name="descricao2" id="descricao2" placeholder="Taça Personalizada" value="">
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
                 <div class="col-3 mb-3">
                   <label for="valor">Valor Un</label> 
                   <input type="text" class="form-control" name="valor2" id="valor2" placeholder="0,00" value="">
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
              </div>



              <div class="row">
                 <div class="col mb-3">
                   <label for="Qt.">Qt</label>
                   <input type="text" class="form-control" name="qt3" id="qt3"  size="3" value="">
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
                 <div class="col-6 mb-3">                
                   <label for="descricao">Descrição</label>
                   <input type="text" class="form-control" name="descricao3" id="descricao3" placeholder="Taça Personalizada" value="">
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
                 <div class="col-3 mb-3">
                   <label for="valor">Valor Un</label> 
                   <input type="text" class="form-control" name="valor3" id="valor3" placeholder="0,00" value="">
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
              </div>



              <div class="row">
                 <div class="col mb-3">
                   <label for="Qt.">Qt</label>
                   <input type="text" class="form-control" name="qt4" id="qt4"  size="3" value="">
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
                 <div class="col-6 mb-3">                
                   <label for="descricao">Descrição</label>
                   <input type="text" class="form-control" name="descricao4" id="descricao4" placeholder="Taça Personalizada" value="">
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
                 <div class="col-3 mb-3">
                   <label for="valor">Valor Un</label> 
                   <input type="text" class="form-control" name="valor4" id="valor4" placeholder="0,00" value="">
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
              </div>


              <div class="row">
                 <div class="col mb-3">
                   <label for="Qt.">Qt</label>
                   <input type="text" class="form-control" name="qt5" id="qt5"  size="3" value="">
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
                 <div class="col-6 mb-3">                
                   <label for="descricao">Descrição</label>
                   <input type="text" class="form-control" name="descricao5" id="descricao5" placeholder="Taça Personalizada" value="">
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
                 <div class="col-3 mb-3">
                   <label for="valor">Valor Un</label> 
                   <input type="text" class="form-control" name="valor5" id="valor5" placeholder="0,00" value="">
                   <div class="invalid-feedback">
                     É obrigatório inserir um nome válido.
                   </div>
                 </div>
              </div>




              <div class="row">         
               <div class="col-3 mb-3">
                 <label for="desconto">Desconto</label>
                 <input type="desconto" class="form-control" id="desconto" name="desconto" placeholder="0,00">
                 <div class="invalid-feedback">
                    Por favor, insira um número de whatsapp para contato.
                 </div>
               </div>

               <div class="col-3 mb-3">
                 <label for="peso">Peso</label>
                 <input type="text" class="form-control" id="peso" name="peso" value="1">
                 <div class="invalid-feedback">
                   Por favor, insira seu endereço de entrega.
                 </div>
               </div>
               <div class="col-6 mb-6">
                 <label for="vrfrete">Valor Frete</label>
                 <input type="text" class="form-control" id="vrfrete" name="vrfrete">

                 <div class="invalid-feedback">
                   Por favor, insira seu endereço de entrega.
                 </div>
               </div>

               <div class="col-3 mb-3">
                 <label for="pac">PAC</label>
                  <input type="radio" class="form-control" id="tipofrete" name="tipofrete" value='PAC'>
               </div>
               <div class="col-3 mb-3">
                 <label for="sedex">SEDEX</label>
                  <input type="radio" class="form-control" id="tipofrete" name="tipofrete" value='SEDEX'>
               </div>
               <div class="col-3 mb-3">
                 <label for="transportadora">TRANSPORTADORA</label>
                   <input type="radio" class="form-control" id="tipofrete" name="tipofrete" value='TRASPORTADORA'> 
               </div>

                              



               <div class="col-6 mb-3">
                 <label for="cep">Frete Grátis</label>
                 <input type="checkbox" class="form-control" id="gratis" name="gratis" >                 
               </div>
               <div class="col-6 mb-3">
                 <label for="cep">CEP</label>
                 <input type="text" class="form-control" id="cep" name="cep" >                 
               </div>
             </div>
        
            
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Criar Link</button>
        </div>
      </div>
    </form>

      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2021 Acerte no Presente</p>
        <ul class="list-inline">
         
           <li class="list-inline-item"><a href="crialink.php">Criar Link</a></li>
        </ul>
      </footer>
    </div>

    <!-- Principal JavaScript do Bootstrap
    ================================================== -->
    <!-- Foi colocado no final para a página carregar mais rápido -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>
      // Exemplo de JavaScript para desativar o envio do formulário, se tiver algum campo inválido.
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Selecione todos os campos que nós queremos aplicar estilos Bootstrap de validação customizados.
          var forms = document.getElementsByClassName('needs-validation');

          // Faz um loop neles e previne envio
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  </body>
</html>
