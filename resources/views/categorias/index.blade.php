@extends('adminlte::page')

@section('content_header')
    <h1>Cadastro Categorias</h1>
    <hr>

@stop

@section('content')

<form method="post" action="/categorias/add" enctype="multipart/form-data" >
    @csrf
        <div class="row">
               <div class="form-group mb-3 col-lg-4">                
                    <label for="exampleFormControlInput1">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" >
                
                </div>
                <div class="mb-3 col-lg-8">
                    <label for="formFile" class="form-label">Imagem da Categoria</label>
                    <input class="form-control" type="file" id="imagemFile" name="imagemFile">
                </div>  

        
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
           </div>
            
            <div class="col-lg-12" style="text-align: right;">
            <button type="submit" class="btn btn-primary">Adicionar</button>
            </div>
        
        </div>
        

</form>
<table class="display table table-striped">
    <thead>
        <tr>    
            <th scope="col">Imagem</th>
            <th scope="col">Nome</th>                     
            <th scope="col">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categorias as $categoria)
           <tr>
                <td><img src="{{ asset('storage/images/categorias/'.$categoria->imagem)}}" width="80px"></td>             
                <td>{{$categoria->nome}}</td>                
                <td>
                        
                        <a href="{{ url('categorias\/') .$categoria->id .'/delete'}}" class="btn btn-outline-danger btn-sm btn-excluir">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                </td>
           </tr>
        @endforeach
    </table>



@stop

