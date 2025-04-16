@extends('adminlte::page')

@section('content_header')
    <h1>Funcionários</h1>
    <div class="col-lg-12" style="text-align: right;">
       <a href="/funcionarios/novo"><button type="button" class="btn btn-primary">Adicionar Funcionário</button></a>
    </div>
    <hr>
@stop

@section('content')
<a href="/funcionarios/nao"><button type="button" class="btn btn-primary">Inativos</button></a>
    <table class="display table table-striped" id="myTable">
        <thead>
        <tr>
        <th scope="col">ID</th>        
        <th scope="col">Nome</th>
        <th scope="col">Periodo</th>
        <th scope="col">Pix</th>
        <th scope="col">Ação</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($funcionarios as $funcionario)
           <tr>
                <td>{{$funcionario->id}}</td>
                <td>{{$funcionario->nome}}</td>
                <td>{{$funcionario->periodo}}</td>
                <td>{{$funcionario->pix}}</td>
                <td>
                        <a href="{{ url('funcionarios\/') .$funcionario->id .'/editar'}}" class="btn btn-outline-secondary btn-sm">Editar<i class="fa fa-pencil" aria-hidden="true"></i></a>                        
                        <a href="{{ url('funcionarios\/') .$funcionario->id .'/delete'}}" class="btn btn-outline-danger btn-sm btn-excluir">
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