@extends('adminlte::page')

@section('content_header')
    <h1>Cadastro Preços Atacado</h1>
    
    <table class="table">
       <tr>
          <td><b>Produto:</b> {{$produto->nome}}</td>
          <td> <b>Mínimo:</b>{{$produto->minimo}}</td>
          <td> <b>Valor:</b> R$<?php echo number_format($produto->valor,2); ?>
    </table>
    <hr>

@stop

@section('content')
<table class="display table table-striped">
    <thead>
        <tr>    
            <th scope="col">Descrição</th>
            <th scope="col">Quantidade</th>
            <th scope="col">Valor</th>
            <th scope="col">Valor Extra</th>
            <th scope="col">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($atacado as $preco)
           <tr>
                <td>{{$preco->descricao}}</td>             
                <td>{{$preco->quantidade}}</td>
                <td>R$<?php echo number_format($preco->valor,2); ?></td>
                <td>R$<?php echo number_format($preco->valor_extra,2); ?></td>
                <td>
                        
                        <a href="{{ url('produtos\/') .$preco->id .'/delete_atacado'}}" class="btn btn-outline-danger btn-sm btn-excluir">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                </td>
           </tr>
        @endforeach
    </table>
<form method="post" action="/produtos/atacado_add" >
    @csrf
        <div class="row">
                <div class="form-group mb-3 col-lg-6">
                <input type="hidden" name="id_produto" value="{{$produto->id}}" />
                    <label for="exampleFormControlInput1">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" >
                
                </div>
                <div class="form-group mb-3 col-lg-2">
                    <label for="exampleFormControlInput1">Quantidade</label>
                    <input type="text" class="form-control" id="quantidade" name="quantidade" >
                
                </div>
                <div class="form-group mb-3 col-lg-2">
                    <label for="exampleFormControlInput1">Valor</label>
                    <input type="text" class="form-control" id="valor" name="valor" >
                
                </div>
                
            <div class="form-group mb-3 col-lg-2">
                    <label for="exampleFormControlInput1">Valor Extra</label>
                    <input type="text" class="form-control" id="valor_extra" name="valor_extra" >
                
                </div>
        
            </div>
            
            <div class="col-lg-12" style="text-align: right;">
            <button type="submit" class="btn btn-primary">Adicionar</button>
            </div>
        
        </div>

</form>



@stop

