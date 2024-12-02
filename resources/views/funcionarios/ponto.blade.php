@extends('adminlte::page')

@section('content_header')
    <h1>Lançamento de Ponto</h1>

    <hr>
@stop

@section('content')
<form method="post" action="/lancamentos_ponto_filtro">
  @csrf
  <div class="row "> 
    <div class="col">
        Funcionário
      <select  class="form-select" id="id_funcionario" name="id_funcionario" >
        <option value="0">Todos</option>
        @foreach ($funcionarios as $funcionario)    
            <option value="{{$funcionario->id}}">{{$funcionario->nome}}</option>
        @endforeach
      </select>
    </div>  

      <div class="col">
            Mês <br>
            <select class="form-select" id="mes" name="mes">
                    <option value="0">Atual</option>
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>

                </select> 
    </div>  

    <div class="col">
                Ano:<br>
                <select class="form-select" id="ano" name="ano">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>          

                </select>              
     </div>
     <div class="col">
                Status:<br>
                <select class="form-select" id="status" name="status">
                    <option value="Todos">Todos</option>
                    <option value="Normal">Normal</option>
                    <option value="Falta">Falta</option>  
                    <option value="Normal">Férias</option>  
                    <option value="Normal">Folga</option>   
                    <option value="Normal">Feriado</option>   
                    <option value="Normal">Acerto de Horas</option>  

                </select>              
     </div> 
     <div class="col">
       <button class="btn btn-outline-primary" type="submit" id="btnNovo">Gerar</button>
     </div>
</div>
  
</form>
<br>
<hr>

   
   
    <table class="display table table-striped" id="myTable">
        <thead>
        <tr>
            <th scope="col">ID</th>  
            <th scope="col">Data</th>      
            <th scope="col">Nome</th>
 
            <th>Entrada</th>
            <th>Saída Almoço</th>
            <th>Chegada Almoço</th>                    
            <th>Saída</th>            
            <th>Status</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($relatorio as $rel)
                  <tr>    
                    <td style="border: 1px solid black; border-radius: 1px;">{{$rel->id_funcionario}} </td>                
                    <td style="border: 1px solid black; border-radius: 1px;"> <?php echo date('d/m/Y', strtotime($rel->data)); ?> </td>
                    <td style="border: 1px solid black; border-radius: 1px;">{{$rel->nome}} </td> 
                    <td style="border: 1px solid black; border-radius: 1px;">{{$rel->entrada}} </td>
                    <td style="border: 1px solid black; border-radius: 1px;">{{$rel->saida_almoco}} </td>
                    <td style="border: 1px solid black; border-radius: 1px;">{{$rel->entrada_almoco }}</td>
                    <td style="border: 1px solid black; border-radius: 1px;">{{$rel->saida}} </td>
                    <td style="border: 1px solid black; border-radius: 1px;">{{$rel->status}} </td>
                    <td>
                        <a href="{{ url('funcionarios\/') .$rel->id .'/editar_ponto'}}" class="btn btn-outline-secondary btn-sm">Editar<i class="fa fa-pencil" aria-hidden="true"></i></a>                        
                        </a>
                    </td>
            
                    
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
<script>
    $("h3.symple-toggle-trigger").click(function(){
        $(this).toggleClass("active").next().slideToggle("fast");
        return false;
    });

    new DataTable('#myTable', {
    language: {
        info: 'Mostrando _PAGE_ de _PAGES_',
        infoEmpty: 'Sem registros',
        infoFiltered: '(Filtrado de _MAX_ Total de Registros)',
        lengthMenu: 'Monstrar _MENU_ registros por pagina',
        search:         "Procurar:",
        paginate: {
            first:      "Primeiro",
            last:       "Último",
            next:       "Próximo",
            previous:   "Anterior"
        },
        zeroRecords: 'Não existe registro...'
    }
});
</script>

@stop