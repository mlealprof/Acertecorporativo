@extends('adminlte::page')

@section('content_header')
    <h1>Cadastro de Funcionários</h1>
    <hr>
@stop

@section('content')
    <form method="post" action="/funcionarios/salvar" enctype="multipart/form-data">
    @csrf
        <div class="row">
        <div class="form-group mb-2 col-lg-2">
                <label for="exampleFormControlInput1">Ativo</label>
                <select class="form-control" id="Ativo" name="Ativo">
                      @if ($funcionario->Ativo == 1)
                         <option value="{{$funcionario->Ativo}}">Sim</option>
                      @else
                         <option value="{{$funcionario->Ativo}}">Não</option>
                    @endif
                      <option value="1">Sim</option>
                      <option value="2">Não</option> 
                </select>           
             </div>
            <div class="form-group mb-2 col-lg-4">               
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome">
                </div>
            </div>
            <div class="form-group mb-2 col-lg-3">
                <label for="exampleFormControlInput1">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" >           
             </div>
             <div class="form-group mb-2 col-lg-3">
                <label for="exampleFormControlInput1">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" >           
             </div>
        </div>
        
        <div class="row">
           
           
           
           
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Data Admissão</label>
              <input type="date" class="form-control" id="data" name="data" >           
           </div>
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Salário</label>
              <input type="text" class="form-control" id="salario" name="salario" >           
           </div>
           <div class="form-group mb-2 col-lg-3">
            <label for="exampleFormControlInput1">Valor Vale</label>
            <input type="text" class="form-control" id="vale" name="vale" >           
           </div>
           <div class="form-group mb-2 col-lg-3">
            <label for="exampleFormControlInput1">Bonificação</label>
            <input type="text" class="form-control" id="bonificacao" name="bonificacao" >           
           </div>


        </div>
        <div class="row">
        <div class="form-group col-lg-3">
                <label for="exampleFormControlSelect1">Plano de Saúde</label>
                <select class="form-control" id="plano_saude" name="plano_saude">
                   <option value="0">...</option> 
                   <option value="1">Ativo</option> 
                   <option value="2">Inativo</option> 
                    
                </select>
           </div>
           <div class="form-group col-lg-3">
            <label for="exampleFormControlSelect1">Período</label>
            <select class="form-control" id="periodo" name="periodo">
               <option value="0">...</option> 
               <option value="1">Integral</option> 
               <option value="2">Meio</option> 
                
            </select>
            </div>
            
            <div class="form-group mb-3 col-lg-2">
                <label for="exampleFormControlInput1">Valor Plano</label>
                <input type="text" class="form-control" id="vr_plano" name="vr_plano" >
            
            </div>
            <div class="form-group mb-3 col-lg-2">
                <label for="exampleFormControlInput1">Porcentagem Plano</label>
                <input type="text" class="form-control" id="porcentagem_pagar" name="porcentagem_pagar" >
            
            </div>
            <div class="form-group mb-3 col-lg-2">
                <label for="exampleFormControlInput1">Valor a Pagar</label>
                <input type="text" class="form-control" id="vr_pagar" name="vr_pagar" >
            
            </div>
            
           <div class="form-group mb-3 col-lg-2">
                <label for="exampleFormControlInput1">Saldo Plano</label>
                <input type="text" class="form-control" id="saldo_plano" name="saldo_plano" >
            
            </div>
            <div class="form-group mb-3 col-lg-2">
                <label for="exampleFormControlInput1">PIX</label>
                <input type="text" class="form-control" id="pix" name="pix" >
            
            </div>
            <div class="form-group mb-3 col-lg-8">
                <label for="exampleFormControlInput1">E-mail</label>
                <input type="text" class="form-control" id="email" name="email" >
            
            </div>
      
        </div>
        
        
        
        <div class="form-group">
            <label for="exampleFormControlTextarea1">OBS.:</label>
            <textarea class="form-control" id="obs" name="obs" rows="3"></textarea>
        </div>
       
       
        <div class="col-lg-12" style="text-align: right;">
           <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
       


    </form>


    
@stop

