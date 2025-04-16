@extends('adminlte::page')

@section('content_header')
    <h1>Validação de Ordem de Produção</h1>

    <hr>
@stop

@section('content')

 
<div>
<table class="display table table-success table-striped" id='myTable'>
              <thead>
              <tr>
              <th scope="col">N.º Ordem</th>        
              <th scope="col">Descrição</th>
              <th scope="col">Situação</th>
              <th scope="col">Funcionário</th>
              <th scope="col">Dt Final</th>            
              <th scope="col">Dt Finalizada</th>
              <th scope="col">Qt Feita</th>
              <th scope="col">Valor</th>
              <th scope="col">Validado</th>
              <th scope="col">Selecionar</th>


              </tr>
          </thead>
          <tbody>
              @foreach ($ordens as $ordem)
                <tr>                     
                      <td>{{$ordem->id_ordem}}</td>
                      <td>{{$ordem->descricao}}</td>
                      <td>{{$ordem->situacao}}</td>
                      <td>{{$ordem->funcionario}}</td>
                      <td>{{$ordem->data_fim}}</td>
                      <td>{{$ordem->data}}</td>
                      <td><input type="text" name="valor" value="{{$ordem->qt_feita}}"size="3"></td>
                      <td><input type="text" name="valor" value="{{$ordem->valor}}" size="4"></td>    
                      @if($ordem->validado==False)    
                         <td>Não</td>
                      @else      
                         <td>Sim</td>
                      @endif   
                      <td><input type="checkbox" name="marcado[]"></td>          
                </tr>
         
              @endforeach     
          </table>
</div>

    <!-- Principal JavaScript do Bootstrap
    ================================================== -->
    <!-- Foi colocado no final para a página carregar mais rápido -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script>
    $("h3.symple-toggle-trigger").click(function(){
        $(this).toggleClass("active").next().slideToggle("fast");
        return false;
    });

    new DataTable('#myTable', {
    pageLength: 20,
    order: [[0, 'desc']],
    language: {        
         info: 'Mostrando _PAGE_ de _PAGES_',        
        infoEmpty: 'Sem registros',
        infoFiltered: '(Filtrado de _MAX_ Total de Registros)',
        lengthMenu: 'Monstrar _MENU_ registros por pagina',
        search:         "Procurar:",
        paginate: {
            first:      " Primeiro",
            last:       " Último ",
            next:       " Próximo ",
            previous:   "Anterior "
        },
        zeroRecords: 'Não existe registro...'
    }
});
</script>

  </body>
</html>

@stop