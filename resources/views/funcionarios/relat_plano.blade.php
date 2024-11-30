@extends('adminlte::page')

@section('content_header')
    <h1>Relatórios Plano de Sáude</h1>

@stop

@section('content')


<br>
<hr>
<h3>Plano de Saúde</h3>
<table class="display table table-striped" id="myTable">
        <thead>
        <tr>

            <th>Funcionário</th>
            <th>Descontar</th>
                   
        </tr>
    </thead>
    <tbody>
    @foreach ($funcionarios as $funcionario)
                  <tr>    
                    <td style="border: 1px solid black; border-radius: 1px;">{{$funcionario->nome}}</td>                
                    <td style="border: 1px solid black; border-radius: 1px;"> <?php echo $funcionario->valor_descontar+$funcionario->saldo_plano; ?> </td>
                   
                    
                    
                    
                 </tr>
               @endforeach  
          

       
    
    </table>
   
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

</script>

@stop