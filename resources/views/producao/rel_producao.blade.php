@extends('adminlte::page')

@section('content_header')
    <h1>Relatórios de Produção</h1>

@stop

@section('content')

<form method="post" action="/producao/relatorio">
  @csrf
  <div class="row "> 
  <div class="col-sm-4">
        Funcionário
      <select  class="form-select" id="id_funcionario" name="id_funcionario" >
        <option value="1">Selecione</option>
        @foreach ($funcionarios as $funcionario) 
            <option value="{{$funcionario->id}}">{{$funcionario->nome}}</option>
        @endforeach
      </select>
    </div>  
      <div class="col-sm-3">
            Mês <br>
            <select class="form-select" id="mes" name="mes">
                    <option value="0">Atual</option>
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>

                </select> 
    </div>  

    <div class="col-sm-3">
                Ano:<br>
                <select class="form-select" id="ano" name="ano">
                    <option value="2025">2025</option>                      
                    <option value="2026">2026</option> 
                    <option value="2027">2027</option> 
                    <option value="2028">2028</option> 
                    <option value="2029">2029</option> 
                    <option value="2030">2030</option>       

                </select>              
      </div> 
    <button class="btn btn-outline-primary" type="submit" id="btnNovo">Gerar</button>
</div>
  
</form>
<br>
<hr>
<div class='row'>
        <div class='col-sm-8'><h3> Funcionário: {{$func}}</h3></div>
        <div class='col-sm-4'><h3>  Mês: {{$mes}}</h3></div>
   </div>
   <hr>
    <div style="font-size:16px;"><b>
       PRODUÇÃO GERAL: {{$qt_feita}}
       <br>DEVOLUÇÕES ERRO:
       <br>TOTAL BRUTO: R$ <?php echo number_format($valor_total, 2, ',', ' '); ?>
       <br>TOTAL ERRO: R$ 
       <br>TOTAL LÍQUIDO: R$ 
</b>
    <div>


    <table style="border: 1px solid ;" class="display" id="myTable">
        <thead>
        <tr>   
            
            <th  style="border: 1px solid ;" >Ordem Produzida</th>
            <th  style="border: 1px solid ;" >Qt Feita</th>
            <th  style="border: 1px solid ;" >Valor</th>                    
            <th  style="border: 1px solid ;" >Total</th>
      

        </tr>
    </thead>
    <tbody>
        
      @foreach ($producao as $produto)
   
           <tr>
     
                <td style="border: 1px solid ;" >{{$produto->id}}</td>
                <td style="border: 1px solid ;" >{{$produto->qt_feita}}</td>
                <td style="border: 1px solid ;" >R$ <?php echo number_format($produto->valor, 2, ',', ' '); ?></td>
                <td style="border: 1px solid ;" >R$ <?php echo number_format($produto->total, 2, ',', ' '); ?></td>    
                
      
           </tr>
      
       @endforeach  
    
    </table>

        <hr>

    <div style="font-size:20px;">
        <b>FECHAMENTO PEDIDOS</b><BR>
          FINALIZADOS: @if (isset($pedidos_finalizados)) 
                          {{$pedidos_finalizados}} 
                        @endif <br>
          CANCELADOS: @if (isset($pedidos_cancelados)) 
                          {{$pedidos_cancelados}} 
                        @endif<br>  
          DEVOLUÇÃO ERRO: @if (isset($pedidos_devolucao_erro)) 
                          {{$pedidos_devolucao_erro}} 
                        @endif<br>
          DEVOLUÇÃO DESISTÊNCIA: @if (isset($pedidos_devolucao_desistencia)) 
                          {{$pedidos_devolucao_desistencia}} 
                        @endif<br>
    </div>

   
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

</script>

@stop