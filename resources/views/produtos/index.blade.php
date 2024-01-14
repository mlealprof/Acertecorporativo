@extends('adminlte::page')

@section('content_header')
    <h1>Produtos</h1>
    <div class="col-lg-12" style="text-align: right;">
       <a href="/produtos/novo"><button type="button" class="btn btn-primary">Adicionar Produto</button></a>
    </div>
    <hr>
@stop

@section('content')
   
    <table class="display table table-striped" id="myTable">
        <thead>
        <tr>
        <th scope="col">ID</th>
        <th scope="col">Código</th>
        <th scope="col">Imagem</th>
        <th scope="col">Produto</th>
        <th scope="col">Quantidade</th>
        <th scope="col">Categoria</th>
        <th scope="col">Valor</th>
        <th scope="col">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produtos as $produto)
           <tr>
                <td>{{$produto->id}}</td>
                <td>{{$produto->codigo}}</td>
                <td><img src="{{ asset('storage/images/'.$produto->imagem)}}" width="80px"></td>
                <td>{{$produto->nome}}</td>
                <td>{{$produto->quantidade}}</td>
                <td>{{$produto->nome_categoria}}</td>
                <td>R$<?php echo number_format($produto->valor,2); ?></td>
                <td>
                        <a href="{{ url('produtos\/') .$produto->id .'/atacado'}}" class="btn btn-outline-secondary btn-sm">Atacado<i class="fa fa-pencil" aria-hidden="true"></i></a>                        
                        <a href="{{ url('produtos\/') .$produto->id .'/variacao'}}" class="btn btn-outline-secondary btn-sm">Variações<i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="{{ url('produtos\/') .$produto->id .'/editar'}}" class="btn btn-outline-secondary btn-sm">Editar<i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="{{ url('produtos\/') .$produto->id .'/delete'}}" class="btn btn-outline-danger btn-sm btn-excluir">
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