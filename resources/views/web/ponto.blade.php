
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
</nav>
<div class="row">
    <div class="col-md-6 col-md">
        <video autoplay></video>
        <script type="text/javascript"><!--
            document.write( webcam.get_html(320, 240) );
           // --></script>
        <form>
            <input type="button" value="Configure..." onClick="webcam.configure()">
            <input type="button" value="Take Snapshot" onClick="take_snapshot()">
        </form>
    </div>
    <div class="col-md-6 col-md write" style="background: #8f8888;"><h2>Horas:</h3>
        <div class="relogio">
            <div class="display" style="font-size: 50px;">00:00:00</div> 
            <form action="/ponto_registro" method="post" class="form-group" enctype="multipart/form-data">
            @csrf
                <input type="text" name="senha">
                <canvas >
                    <input class="form-control" type="file" id="imagemFile" name="imagemFile">
                </canvas>
                
                <button type="submit" class="btn btn-secondary">Registrar</button>
            </form>           
        </div>
        <hr>
        <div class="ultimas">
            <div class="">Último Registro</div>            
        </div>
        
    </div>        
</div>

        
</body>
<script>
    var video = document.querySelector('video');

navigator.mediaDevices.getUserMedia({video:true})
.then(stream => {
    video.srcObject = stream;
    video.play();
})
.catch(error => {
    console.log(error);
})

document.querySelector('button').addEventListener('click', () => {
    var canvas = document.querySelector('canvas');
    canvas.height = video.videoHeight;
    canvas.width = video.videoWidth;
    var context = canvas.getContext('2d');
    context.drawImage(video, 0, 0);
    var link = document.createElement('a');
    link.download = 'foto.png';
    link.href = canvas.toDataURL();
    link.textContent = 'Clique para baixar a imagem';
    document.body.appendChild(link);
});

function atualizarTempo(){
    var display = document.querySelector('.display');

    var agora = new Date();
    
    var horario = corrigirHorario(agora.getHours()) + ':' + corrigirHorario(agora.getMinutes()) + ':' + corrigirHorario(agora.getSeconds());
    
    display.textContent = horario;
}

function corrigirHorario(numero){
    if (numero < 10) {
        numero = '0' + numero;
    }
    return numero;
}

atualizarTempo();
setInterval(atualizarTempo, 1000);

console.log(horario);


</script>



@include ('web.footer')