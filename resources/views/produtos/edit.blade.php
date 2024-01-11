@extends('adminlte::page')

@section('content_header')
    <h1>Editanto Produtos</h1>
    <hr>
@stop

@section('content')
    <form method="post" action="/produtos/editar" enctype="multipart/form-data">
    @csrf
        <div class="row">
           <div class="form-group mb-2 col-lg-3">
                <input type="hidden" name="id_produto" value="{{$produtos->id}}" />
                <div class="form-group">
                    <label for="exampleFormControlInput1">Código</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" value="{{$produtos->codigo}}">
                </div>
            </div>
            <div class="form-group mb-2 col-lg-9">               
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{$produtos->nome}}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3"value="{{$produtos->descricao}}"></textarea>
        </div>
        <div class="row">
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Altura (cm)</label>
              <input type="text" class="form-control" id="altura" name="altura" value="{{$produtos->altura}}" >           
           </div>
           
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Largura (cm)</label>
              <input type="text" class="form-control" id="largura" name="largura" value="{{$produtos->largura}}">           
           </div>
           
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Comprimento (cm)</label>
              <input type="text" class="form-control" id="comprimento" name="comprimento" value="{{$produtos->comprimento}}" >           
           </div>
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Peso (gramas)</label>
              <input type="text" class="form-control" id="peso" name="peso" value="{{$produtos->peso}}">           
           </div>
        </div>
        <div class="row">
        <div class="form-group col-lg-3">
                <label for="exampleFormControlSelect1">Selecione a Categoria</label>
                <select class="form-control" id="id_categoria" name="id_categoria">
                   <option value="{{$produtos->id_categoria}}">...</option> 
                    @foreach ($categorias as $categoria)
                        <option value="{{$categoria->id}}">{{$categoria->nome}}</option>         
                    @endforeach
                </select>
           </div>
           <div class="form-group col-lg-3">
                <label for="exampleFormControlSelect1">Tipo Personalização</label>
                <select class="form-control" id="id_tipo" name="id_tipo">
                   <option value="{{$produtos->id_tipo}}">...</option> 
                    @foreach ($tipos as $tipo)
                        <option value="{{$tipo->id}}">{{$tipo->descricao}}</option>         
                    @endforeach
                </select>
           </div>
            
        
            
            <div class="form-group mb-3 col-lg-2">
                <label for="exampleFormControlInput1">Quantidade Estoque</label>
                <input type="text" class="form-control" id="quantidade" name="quantidade" value="{{$produtos->quantidade}}" >
            
            </div>
            <div class="form-group mb-3 col-lg-2">
                <label for="exampleFormControlInput1">Mínimo</label>
                <input type="text" class="form-control" id="minimo" name="minimo"value="{{$produtos->minimo}} ">
            
            </div>
            
           <div class="form-group mb-3 col-lg-2">
                <label for="exampleFormControlInput1">Valor</label>
                <input type="text" class="form-control" id="valor" name="valor" value="{{$produtos->valor}}">
            
            </div>
      
        </div>
        
        <div class="row">
            <div class="form-group mb-2 col-lg-2">
                <label for="exampleFormControlInput1">Prazo de Produção</label>
                <input type="text" class="form-control" id="prazo_producao" name="prazo_producao"  value="{{$produtos->prazo_producao}}">
            </div>

           <div class="mb-3 col-lg-10">
                <label for="formFile" class="form-label">Imagem do Produto</label>
                <input class="form-control" type="file" id="imagemFile" name="imagemFile" value="{{$produtos->imagem}}">
           </div>
       
        </div>
        
        
       
       
        <div class="col-lg-12" style="text-align: right;">
           <button type="submit" class="btn btn-primary">Salvar</button>
           <a href="/produtos"><button type="button" class="btn btn-primary">Cancelar</button></a>
        </div>
   
       


    </form>


    
@stop

