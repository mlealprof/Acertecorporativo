<!-- /*
* Template Name: Blogy
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Márcio Leal" content="ME Soluções em Negócios">
	<link rel="shortcut icon" href="favicon.png">

	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap5" />

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600;700&display=swap" rel="stylesheet">


	<link rel="stylesheet" href="{{url ('assets/fonts/icomoon/style.css')}}">
	<link rel="stylesheet" href="{{url ('assets/fonts/flaticon/font/flaticon.css')}}">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css')}}">

	<link rel="stylesheet" href="{{url ('assets/css/tiny-slider.css')}}">
	<link rel="stylesheet" href="{{url ('assets/css/aos.css')}}">
	<link rel="stylesheet" href="{{url ('assets/css/glightbox.min.css')}}">
	<link rel="stylesheet" href="{{url ('assets/css/style.css')}}">

	<link rel="stylesheet" href="{{url ('assets/css/flatpickr.min.css')}}">
	
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


	<title>Acerte no Presente</title>



</head>
<body>

<a href="https://api.whatsapp.com/send?phone=5537999062728&text=Quero%20saber%20 sobre%20 brindes%20 Corporativos"
    target="_blank"
    style="position:fixed;bottom:20px;right:30px;">
    <svg enable-background="new 0 0 512 512" width="50" height="50" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104  l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z" fill="#4CAF50"/><path d="m405.02 361.5c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.62-127.46-112.58-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016 0.16 8.576 0.288 7.52 0.32 11.296 0.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744s-7.36 7.68-11.136 12.352c-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" fill="#FAFAFA"/></svg>
</a>

		<nav class="site-nav ">
		<div class="container">
			<div class="menu-bg-wrap">
				<div class="site-navigation">
					<div class="row g-0 align-items-center">
						<div class="col-3 logo">							
							<a class="" href="/"><img src="{{url('assets/images/logo.png')}}" width="100%" alt="Logo da empresa" /></a>
						</div>
						<div class="col-7 text-center menu">
							<form action="#" class="search-form d-inline-block d-lg-none">
								<input type="text" class="form-control" placeholder="Pesquisar...">
								<span class="bi-search"></span>
							</form>

							<ul class=" site-menu mx-auto">
								<li class="active"><a href="/portifolio">PORTIFÓRIO</a></li>
								<li class="has-children">									
									<a href="#">PRODUTOS</a>
									<ul class="dropdown">
										@foreach ($categorias as $categoria)
											<li><a href="/categorias/{{$categoria->id}}">{{$categoria->nome}}</a></a></li>
											<!--
											<li class="has-children">
												<a href="#">Dropdown</a>
												<ul class="dropdown">
													<li><a href="#">Sub Menu One</a></li>
													<li><a href="#">Sub Menu Two</a></li>
													<li><a href="#">Sub Menu Three</a></li>
												</ul>
											</li>
											-->
										@endforeach
									</ul>
								</li>
								<li><a href="category.html">DATAS COMEMORATIVAS</a></li>
								<li class="has-children">
									<a href="#">ACESSOS</a>
									<ul class="dropdown">
											<li><a href="/home">Afiliados</a></li>
											<li><a href="/home">Colaborador</a></li>
											<li><a href="/home">Cliente</a></li>
											<li><a href="/registrar">Cadastrar / Registrar</a></li>
									</ul>
								</li>
								
							</ul>
						</div>
						<div class="col-2 text-end">						
							
							<form action="/busca" class="search-form d-none d-lg-inline-block" method="get">
								<input type="text" class="form-control text-white" name="busca" placeholder="Pesquisa...">
								
							</form>
							
						</div>
					</div>
                    <div class="carrinho">							
						<a href="/carrinho">
							<img class="carrinho" src="{{url('assets/images/carrinho.png')}}" alt="Carrinho de Compras"  />
							<span class="position-absolute icone start-100 translate-middle badge rounded-pill bg-danger">
							  {{\Cart::getContent()->count()}}
							  
							</span>
						  </a>
					</div>



				</div>
				

			</div>
		</div>
		



	</nav>

