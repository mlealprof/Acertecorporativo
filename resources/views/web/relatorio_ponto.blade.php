
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartão de Ponto</title>
    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="webcam.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="{{url ('assets/css/style.css')}}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<nav class="site-nav ">
    <div class="container">
        <div class="menu-bg-wrap">
            <div class="site-navigation">
                <div class="row g-0 align-items-center">
                    <div class="col-3 logo">							
                        <a class="" href="/"><img src="{{url('assets/images/logo.png')}}" width="100%" alt="Logo da empresa" /></a>
                    </div>
                </div>                    
            </div>
        </div>
    </div>
</nav><br><br>
<form class="needs-validation mb-3" action="/relatorio_ponto" method="post">
        @csrf
        <div class="row">
          
            <div class="col-sm-3">
                <label class="form-label">Senha:</label><br>
                <input type="password" name="senha">                
            </div>
            <div class="col-sm-3">
                <label class="form-label">Mês:</label>
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
                <label class="form-label">Ano:</label>
                <select class="form-select" id="mes" name="ano">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>          

                </select>              
            </div>
  
            <div class="col-sm-3 align-self-end text-end ">
                <button class="btn btn-outline-primary" type="submit" id="btnNovo">Gerar</button>
            </div>
        </div>
    </form>
     <hr> 

     <div style="font-size:30px;">

       <b>Funcionário:</b> {{$funcionario->nome}}<br>
       <b>Banco de Horas:</b> {{$banco_horas}}

    </div>
    <hr>  
     <div class="container">
     <table id="tableAulas" class="" border='0' style="width:70%;border: 1px solid black;">
            <thead  >
                <tr style="border: 2px solid black; border-radius: 10px;">
                    <th>Data</th>
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
          
            </tbody>
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
</div>
   
     



</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
  
</script>



@include ('web.footer')