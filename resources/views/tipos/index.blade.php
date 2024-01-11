@extends('adminlte::page')

@section('content_header')
    <h1>Cadastro Tipos de Personalização</h1>
    <hr>

@stop

@section('content')

<form method="post" action="/tipos/add"  enctype="multipart/form-data" >
    @csrf
        <div class="row">
               <div class="form-group mb-3 col-lg-4">                
                    <label for="exampleFormControlInput1">Descrição</label>
                    <input type="text" class="form-control" id="nome" name="descricao" >
                
                </div>
                <div class="mb-3 col-lg-8">
                    <label for="formFile" class="form-label">Imagem da Categoria</label>
                    <input class="form-control" type="file" id="imagemFile" name="imagemFile">
                </div>  

        
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
            <th scope="col">Descrição</th>                     
            <th scope="col">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tipos as $tipo)
           <tr>
                <td><img src="{{ asset('storage/images/tipos/'.$tipo->imagem)}}" width="80px"></td>             
                <td>{{$tipo->descricao}}</td>                
                <td>
                        
                        <a href="{{ url('tipos\/') .$tipo->id .'/delete'}}" class="btn btn-outline-danger btn-sm btn-excluir">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                </td>
           </tr>
        @endforeach
    </table>



@stop

