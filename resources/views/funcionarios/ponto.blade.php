@extends('adminlte::page')

@section('content_header')
    <h1>Lançamento de Ponto</h1>

    <hr>
@stop

@section('content')

   
   
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
            <th>Atraso Entrada</th>
            <th>Atraso Almoço</th>
            <th>Antecipação Almoço</th>
            <th>Antecipação Saída</th>
            <th>Hora Extra</th>
            <th>Atestado</th>
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
                    @if($rel->atrazo_entrada<>null)
                       <td style="border: 1px solid black; border-radius: 1px;" bgcolor="red">{{$rel->atrazo_entrada}} </td>
                      
                    @else
                       <td style="border: 1px solid black; border-radius: 1px;"></td>
                    @endif
                    @if($rel->atrazo_almoco<>null)
                       <td style="border: 1px solid black; border-radius: 1px;" bgcolor="red">{{$rel->atrazo_almoco}} </td>
                    @else
                       <td style="border: 1px solid black; border-radius: 1px;"> </td>
                    @endif
                    @if($rel->hora_extra_almoco<>null)
                       <td style="border: 1px solid black; border-radius: 1px;" bgcolor="green">{{$rel->hora_extra_almoco}} </td>
                    @else
                       <td style="border: 1px solid black; border-radius: 1px;"> </td>
                    @endif
                    @if($rel->antes_saida<>null)
                       <td style="border: 1px solid black; border-radius: 1px;" bgcolor="red">{{$rel->antes_saida}} </td>
                    @else
                       <td style="border: 1px solid black; border-radius: 1px;"> </td>
                    @endif
                    @if($rel->hora_extra_saida<>null)
                       <td style="border: 1px solid black; border-radius: 1px;" bgcolor="green">{{$rel->hora_extra_saida}} </td>
                    @else
                       <td style="border: 1px solid black; border-radius: 1px;"> </td>
                    @endif
                    <td style="border: 1px solid black; border-radius: 1px;">{{$rel->Atestado}} </td>
                    <td>
                        <a href="{{ url('funcionarios\/') .$rel->id .'/editar'}}" class="btn btn-outline-secondary btn-sm">Editar<i class="fa fa-pencil" aria-hidden="true"></i></a>                        
                        <a href="{{ url('funcionarios\/') .$rel->id .'/delete'}}" class="btn btn-outline-danger btn-sm btn-excluir">
                            <i class="fa fa-trash" aria-hidden="true"></i>
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