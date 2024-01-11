@extends('adminlte::page')

@section('content_header')
    <h1>Cadastro Variações</h1>
    
    <table class="table">
        <tr>
          <td><b>Produto:</b> {{$produto->nome}}</td>
          <td> <b>Mínimo:</b>{{$produto->minimo}}</td>
          <td> <b>Valor:</b> R$<?php echo number_format($produto->valor,2); ?>
       </tr>
    </table>
    <hr>

@stop

@section('content')
<table class="display table table-striped">
    <thead>
        <tr>    
            <th scope="col">Descrição</th>
            <th scope="col">Imagem</th>
            <th scope="col">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($variacoes as $variacao)
           <tr>
                <td>{{$variacao->descricao}}</td>                
                <td><img src="{{ asset('storage/images/'.$variacao->imagem)}}" width="80px"></td>             
                <td>
                        
                        <a href="{{ url('produtos\/') .$variacao->id .'/delete_variacao'}}" class="btn btn-outline-danger btn-sm btn-excluir">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                </td>
           </tr>
        @endforeach
    </table>
<form method="post" action="/produtos/variacao_add" enctype="multipart/form-data" >
    @csrf
        <div class="row">
                <div class="form-group mb-3 col-lg-3">
                <input type="hidden" name="id_produto" value="{{$produto->id}}" />
                    <label for="exampleFormControlInput1">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" >
                
                </div>
                <div class="mb-3 col-lg-9">
                    <label for="formFile" class="form-label">Imagem do Produto</label>
                    <input class="form-control" type="file" id="imagemFile" name="imagemFile">
                </div>        
            </div>
            
            <div class="col-lg-12" style="text-align: right;">
                <button type="submit" class="btn btn-primary">Adicionar</button>
            </div>
        
        </div>

</form>



@stop

