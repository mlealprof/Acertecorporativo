@extends('adminlte::page')

@section('content_header')
    <h1>Cadastro de Produtos</h1>
    <hr>
@stop

@section('content')
    <form method="post" action="/produtos/salvar" enctype="multipart/form-data">
    @csrf
        <div class="row">
           <div class="form-group mb-2 col-lg-3">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <div class="form-group">
                    <label for="exampleFormControlInput1">Código</label>
                    <input type="text" class="form-control" id="codigo" name="codigo">
                </div>
            </div>
            <div class="form-group mb-2 col-lg-9">               
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
        </div>
        <div class="row">
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Altura (cm)</label>
              <input type="text" class="form-control" id="altura" name="altura" >           
           </div>
           
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Largura (cm)</label>
              <input type="text" class="form-control" id="largura" name="largura" >           
           </div>
           
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Comprimento (cm)</label>
              <input type="text" class="form-control" id="comprimento" name="comprimento" >           
           </div>
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Peso (gramas)</label>
              <input type="text" class="form-control" id="peso" name="peso" >           
           </div>
        </div>
        <div class="row">
        <div class="form-group col-lg-3">
                <label for="exampleFormControlSelect1">Selecione a Categoria</label>
                <select class="form-control" id="id_categoria" name="id_categoria">
                   <option value="0">...</option> 
                    @foreach ($categorias as $categoria)
                        <option value="{{$categoria->id}}">{{$categoria->nome}}</option>         
                    @endforeach
                </select>
           </div>
           <div class="form-group col-lg-3">
                <label for="exampleFormControlSelect1">Tipo Personalização</label>
                <select class="form-control" id="id_tipo" name="id_tipo">
                   <option value="0">...</option> 
                    @foreach ($tipos as $tipo)
                        <option value="{{$tipo->id}}">{{$tipo->descricao}}</option>         
                    @endforeach
                </select>
           </div>
            
        
            
            <div class="form-group mb-3 col-lg-2">
                <label for="exampleFormControlInput1">Quantidade Estoque</label>
                <input type="text" class="form-control" id="quantidade" name="quantidade" >
            
            </div>
            <div class="form-group mb-3 col-lg-2">
                <label for="exampleFormControlInput1">Mínimo</label>
                <input type="text" class="form-control" id="minimo" name="minimo" >
            
            </div>
            
           <div class="form-group mb-3 col-lg-2">
                <label for="exampleFormControlInput1">Valor</label>
                <input type="text" class="form-control" id="valor" name="valor" >
            
            </div>
      
        </div>
        
        <div class="row">
            <div class="form-group mb-2 col-lg-2">
                <label for="exampleFormControlInput1">Prazo de Produção</label>
                <input type="text" class="form-control" id="prazo_producao" name="prazo_producao" value="7">
            </div>

           <div class="mb-3 col-lg-10">
                <label for="formFile" class="form-label">Imagem do Produto</label>
                <input class="form-control" type="file" id="imagemFile" name="imagemFile">
           </div>
       
        </div>
        
        
       
       
        <div class="col-lg-12" style="text-align: right;">
           <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
       


    </form>


    
@stop

