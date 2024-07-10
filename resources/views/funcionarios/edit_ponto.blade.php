@extends('adminlte::page')

@section('content_header')
    <h1>Editando Ponto</h1>
    <hr>
@stop

@section('content')
    <form method="post" action="/funcionarios/salvar_ponto" enctype="multipart/form-data">
    @csrf
        <div class="row">
            <div class="form-group mb-2 col-lg-4">               
                <div class="form-group">
                    <label for="exampleFormControlInput1">Data</label>
                    <input type="date" class="form-control" id="data" name="data" value="{{$registro[0]->data}}">
                    <input type="hidden" name="id" value="{{$registro[0]->id}}">
                </div>
            </div>
            <div class="form-group mb-2 col-lg-6">
                <label for="exampleFormControlInput1">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{$registro[0]->nome}}" >           
             </div>
             <div class="form-group mb-2 col-lg-2">
                <label for="exampleFormControlInput1">Status</label>
                <select class="form-control" id="status" name="status">
                      <option value="{{$registro[0]->status}}">{{$registro[0]->status}}</option>
                      <option value="Normal">Normal</option>
                      <option value="Falta">Falta</option>  
                      <option value="Normal">Férias</option>  
                      <option value="Normal">Folga</option> 
                </select>
                
             </div>
             
        </div>
        
        <div class="row">
           
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Entrada</label>
              <input type="text" class="form-control" id="entrada" name="entrada" value="{{$registro[0]->entrada}}" >           
           </div>
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Saída Almoço</label>
              <input type="text" class="form-control" id="saida_almoco" name="saida_almoco" value="{{$registro[0]->saida_almoco}}" >           
           </div>
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Chegada Almoço</label>
              <input type="text" class="form-control" id="chegada_almoco" name="chegada_almoco" value="{{$registro[0]->entrada_almoco}}" >           
           </div>
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Saída</label>
              <input type="text" class="form-control" id="saida" name="saida" value="{{$registro[0]->saida}}" >           
           </div>
         </div>
         <hr><h4>Ocorrências</h4>
         <div class="row">
           
           <div class="form-group mb-2 col-lg-2">
              <label for="exampleFormControlInput1">Atraso Entrada</label>
              <input type="text" class="form-control" id="atraso_entrada" name="atraso_entrada" value="{{$registro[0]->atrazo_entrada}}" >           
           </div>
           <div class="form-group mb-2 col-lg-2">
              <label for="exampleFormControlInput1">Antecipação Entrada</label>
              <input type="text" class="form-control" id="antes_entrada" name="antes_entrada" value="{{$registro[0]->hora_extra_entrada}}" >           
           </div>
           <div class="form-group mb-2 col-lg-2">
              <label for="exampleFormControlInput1">Atraso Almoço</label>
              <input type="text" class="form-control" id="atraso_almoco" name="atraso_almoco" value="{{$registro[0]->atrazo_almoco}}" >           
           </div>
           <div class="form-group mb-2 col-lg-2">
              <label for="exampleFormControlInput1">Antecipação Almoço</label>
              <input type="text" class="form-control" id="antes_almoco" name="antes_almoco" value="{{$registro[0]->hora_extra_almoco}}" >           
           </div>
         
         <div class="form-group mb-2 col-lg-2">
              <label for="exampleFormControlInput1">Antecipação Saída</label>
              <input type="text" class="form-control" id="antes_saida" name="antes_saida" value="{{$registro[0]->antes_saida}}" >           
           </div>
           <div class="form-group mb-2 col-lg-2">
              <label for="exampleFormControlInput1">Hora Extra</label>
              <input type="text" class="form-control" id="hora_extra" name="hora_extra" value="{{$registro[0]->hora_extra_saida}}" >           
           </div>
         </div>
           
       
        <div class="col-lg-12" style="text-align: right;">
           <button type="submit" class="btn btn-primary">Salvar</button>
           <a href="/lancamentos_ponto"><button type="button" class="btn btn-primary">Cancelar</button></a>
        </div>
       


    </form>


    
@stop

