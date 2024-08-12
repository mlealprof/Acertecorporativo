@extends('adminlte::page')

@section('content_header')
    <h1>Editanto Produtos</h1>
    <hr>
@stop

@section('content')
<form method="post" action="/produtos/salvando_atacado" >
    @csrf
        <div class="row">
                <div class="form-group mb-3 col-lg-6">
                <input type="hidden" name="id_produto" value="{{$atacado->id}}" />
                    <label for="exampleFormControlInput1">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" value="{{$atacado->descricao}}" >
                
                </div>
                <div class="form-group mb-3 col-lg-2">
                    <label for="exampleFormControlInput1">Quantidade</label>
                    <input type="text" class="form-control" id="quantidade" name="quantidade" value="{{$atacado->quantidade}}">
                
                </div>
                <div class="form-group mb-3 col-lg-2">
                    <label for="exampleFormControlInput1">Valor</label>
                    <input type="text" class="form-control" id="valor" name="valor" value="{{$atacado->valor}}" >
                
                </div>
                
            <div class="form-group mb-3 col-lg-2">
                    <label for="exampleFormControlInput1">Valor Extra</label>
                    <input type="text" class="form-control" id="valor_extra" name="valor_extra" value="{{$atacado->valor_extra}}" >
                
                </div>
        
            </div>
            
            <div class="col-lg-12" style="text-align: right;">
            <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
            <div class="col-lg-12" style="text-align: right;">
            <button type="botton" class="btn btn-primary">Cancelar</button>
            </div>
        
        </div>

</form>
    
@stop

