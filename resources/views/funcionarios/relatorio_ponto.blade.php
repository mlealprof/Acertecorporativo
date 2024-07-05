@extends('adminlte::page')

@section('content_header')
    <h1>Relatórios de Ponto</h1>

@stop

@section('content')

<form method="post" action="/rel_cartao_ponto">
  @csrf
  <div class="row "> 
    <div class="col-sm-3">
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
                <select class="form-select" id="mes" name="ano">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>          

                </select>              
      </div> 
    <button class="btn btn-outline-primary" type="submit" id="btnNovo">Gerar</button>
</div>
  
</form>
<br>
<hr>
   <div class='row'>
        <div class='col'><h3> Funcionário: {{$func->nome}}</h3></div>
        <div class='col'><h3>  Mês: {{$mes}}</h3></div>
   </div> 
   
    <table class="display table table-striped" id="myTable">
        <thead>
        <tr>
            <th scope="col">ID</th>  
            <th scope="col">Data</th>      

 
            <th>Entrada</th>
            <th>Saída Almoço</th>
            <th>Chegada Almoço</th>                    
            <th>Saída</th>
            <th>Atraso Entrada</th>
            <th>Atraso Almoço</th>
            <th>Antecipação Almoço</th>
            <th>Antecipação Saída</th>
            <th>Hora Extra</th>
            
       
        </tr>
    </thead>
    <tbody>
    @foreach ($relatorio as $rel)
                  <tr>    
                    <td style="border: 1px solid black; border-radius: 1px;">{{$rel->id_funcionario}} </td>                
                    <td style="border: 1px solid black; border-radius: 1px;"> <?php echo date('d/m/Y', strtotime($rel->data)); ?> </td>
                   
                    <td style="border: 1px solid black; border-radius: 1px;">{{$rel->entrada}} </td>
                    <td style="border: 1px solid black; border-radius: 1px;">{{$rel->saida_almoco}} </td>
                    <td style="border: 1px solid black; border-radius: 1px;">{{$rel->entrada_almoco }}</td>
                    <td style="border: 1px solid black; border-radius: 1px;">{{$rel->saida}} </td>
                    @if($rel->atrazo_entrada<>null)
                       <td style="border: 1px solid black; border-radius: 1px;" bgcolor="red">{{$rel->atrazo_entrada}} </td>
                      
                    @else
                       <td style="border: 1px solid black; border-radius: 1px;"></td>
                    @endif
                    @if($rel->atrazo_almoco<>null)
                       <td style="border: 1px solid black; border-radius: 1px;" bgcolor="red">{{$rel->atrazo_almoco}} </td>
                    @else
                       <td style="border: 1px solid black; border-radius: 1px;"> </td>
                    @endif
                    @if($rel->hora_extra_almoco<>null)
                       <td style="border: 1px solid black; border-radius: 1px;" bgcolor="green">{{$rel->hora_extra_almoco}} </td>
                    @else
                       <td style="border: 1px solid black; border-radius: 1px;"> </td>
                    @endif
                    @if($rel->antes_saida<>null)
                       <td style="border: 1px solid black; border-radius: 1px;" bgcolor="red">{{$rel->antes_saida}} </td>
                    @else
                       <td style="border: 1px solid black; border-radius: 1px;"> </td>
                    @endif
                    @if($rel->hora_extra_saida<>null)
                       <td style="border: 1px solid black; border-radius: 1px;" bgcolor="green">{{$rel->hora_extra_saida}} </td>
                    @else
                       <td style="border: 1px solid black; border-radius: 1px;"> </td>
                    @endif
                    
                    
                 </tr>
               @endforeach  
          

       
    
    </table>
    <div style="font-size:20px;">
        <b>PONTOS NEGATIVOS</b><BR>
          <b>Total de Faltas:</b> {{$total_Falta}}<br>
          <b>Total Atrasos Entrada:</b>{{$total_Atraso_Entrada}}<br>  
          <b>Total Atrasos Almoço:</b>{{$total_Atraso_Almoco}}<br>
          <b>Total Antecipação Saída:</b>{{$total_Antecipacao_Saida}}<br><br>
          <b>PONTOS POSITIVOS</b><BR>
          <b>Total Antecipação Entrada:</b>{{$total_Antecipacao_Entrada}} <br>
          <b>Total Antecipação Almoço:</b>{{$total_Antecipacao_Almoco}}<br>
          <b>Total Horas Extras:</b>{{$total_hora_extra}} <br>
   </div>

   <div style="font-size:30px;">
      Banco de Horas: {{$banco_horas}}
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