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

	<div class="site-mobile-menu site-navbar-target">
		<div class="site-mobile-menu-header">
			<div class="site-mobile-menu-close">
				<span class="icofont-close js-menu-toggle"></span>
			</div>
		</div>
		<div class="site-mobile-menu-body"></div>
	</div>

	<nav class="site-nav">
		<div class="container">
			<div class="menu-bg-wrap">
				<div class="site-navigation">
					<div class="row g-0 align-items-center">
						<div class="col-2">							
							<a class="logo m-0 float-start navbar-brand" href="/"><img src="{{url('assets/images/logo.png')}}" width="100%" alt="Logo da empresa" /></a>
						</div>
						<div class="col-8 text-center">
							<form action="#" class="search-form d-inline-block d-lg-none">
								<input type="text" class="form-control" placeholder="Pesquisar...">
								<span class="bi-search"></span>
							</form>

							<ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mx-auto">
								<li class="active"><a href="index.html">PORTIFÓRIO</a></li>
								<li class="has-children">
									<a href="category.html">PRODUTOS</a>
									<ul class="dropdown">
										<li><a href="search-result.html">Search Result</a></li>
										<li><a href="blog.html">Blog</a></li>
										<li><a href="single.html">Blog Single</a></li>
										<li><a href="category.html">Category</a></li>
										<li><a href="about.html">About</a></li>
										<li><a href="contact.html">Contact Us</a></li>
										<li><a href="#">Menu One</a></li>
										<li><a href="#">Menu Two</a></li>
										<li class="has-children">
											<a href="#">Dropdown</a>
											<ul class="dropdown">
												<li><a href="#">Sub Menu One</a></li>
												<li><a href="#">Sub Menu Two</a></li>
												<li><a href="#">Sub Menu Three</a></li>
											</ul>
										</li>
									</ul>
								</li>
								<li><a href="category.html">DATAS COMEMORATIVAS</a></li>
								<li class="has-children">
									<a href="category.html">SOBRE NÓS</a>
									<ul class="dropdown">
											<li><a href="search-result.html">Nossa História</a></li>
											<li><a href="blog.html">Nossa Equipe</a></li>
											<li><a href="single.html">Contato</a></li>
									</ul>
								</li>
								
							</ul>
						</div>
						<div class="col-2 text-end">
							<a href="#" class="burger ms-auto float-end site-menu-toggle js-menu-toggle d-inline-block d-lg-none light">
								<span></span>
							</a>
							<form action="#" class="search-form d-none d-lg-inline-block">
								<input type="text" class="form-control" placeholder="Pesquisa...">
								<span class="bi-search"></span>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>


<header class="banner">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="Banner1" data-slide-to="0" class="active"></li>
    <li data-target="Banner2" data-slide-to="1"></li>
    <li data-target="Banner3" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="assets/images/banner/1.jpg?auto=yes&bg=777&fg=555&text=Primeiro Slide" alt="Primeiro Slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="assets/images/banner/2.jpg?auto=yes&bg=666&fg=444&text=Segundo Slide" alt="Segundo Slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="assets/images/banner/3.jpg?auto=yes&bg=555&fg=333&text=Terceiro Slide" alt="Terceiro Slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Anterior</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Próximo</span>
  </a>
</div>
	
</header>





	<div class="section bg-light">
		<div class="container">

			<div class="row mb-4">
				<div class="col-sm-6">
					<h2 class="posts-entry-title"></h2>
				</div>
			<!--	<div class="col-sm-6 text-sm-end"><a href="category.html" class="read-more">Catálogo PDF</a></div>-->
			</div>

			<div class="row align-items-stretch retro-layout-alt">

				<div class="col-md-5 order-md-2">
					<a href="single.html" class="hentry img-1 h-100 gradient">
						<div class="featured-img" style="background-image: url('assets/images/4.jpg');"></div>
						<div class="text">
						<!--<span>February 12, 2019</span>
							<h2>Meta unveils fees on metaverse sales</h2>-->
						</div>
					</a>
				</div>

				<div class="col-md-7">

					<a href="single.html" class="hentry img-2 v-height mb30 gradient">
						<div class="featured-img" style="background-image: url('assets/images/1.jpg');"></div>
						<div class="text text-sm">
						<!--	<span>February 12, 2019</span>
							<h2>AI can now kill those annoying cookie pop-ups</h2>-->
						</div>
					</a>

					<div class="two-col d-block d-md-flex justify-content-between">
						<a href="single.html" class="hentry v-height img-2 gradient">
							<div class="featured-img" style="background-image: url('assets/images/3.jpg');"></div>
							<div class="text text-sm">
							<!--	<span>February 12, 2019</span>
								<h2>Don’t assume your user data in the cloud is safe</h2>-->
							</div>
						</a>
						<a href="single.html" class="hentry v-height img-2 ms-auto float-end gradient">
							<div class="featured-img" style="background-image: url('assets/images/2.jpg');"></div>
							<div class="text text-sm">
								<!--<span>February 12, 2019</span>
								<h2>Startup vs corporate: What job suits you best?</h2>-->
							</div>
						</a>
					</div>  

				</div>
			</div>

		</div>
	</div>


	<footer class="site-footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-4">
					<div class="widget">
						<h3 class="mb-4">Sobre Nós</h3>
						<p>O Cliente ou amigo é algo importante na vida de todos. E por isso existimos para presentear com sua LOGO (marca) essas pessoas.</p>
					</div> <!-- /.widget -->
					<div class="widget">
						<h3>Redes Sociais</h3>
						<ul class="list-unstyled social">
							<li><a href="https://www.instagram.com/acerte.no.presente"><span class="icon-instagram"></span></a></li>							
							<li><a href="https://www.facebook.com/acertenopresentee"><span class="icon-facebook"></span></a></li>
							
						</ul>
					</div> <!-- /.widget -->
				</div> <!-- /.col-lg-4 -->
				<div class="col-lg-4 ps-lg-5">
					<div class="widget">
						<h3 class="mb-4">Empresa</h3>
						<ul class="list-unstyled float-start links">
							<li><a href="#">Sobre Nós</a></li>
							<li><a href="#">Catálogo PDF</a></li>
							<li><a href="#">Visão</a></li>
							<li><a href="#">Missão</a></li>
							<li><a href="#">Termos</a></li>
							<li><a href="#">Privacidade</a></li>
						</ul>
						<ul class="list-unstyled float-start links">
							<li><a href="#">Afiliados</a></li>
							<li><a href="#">Mercado Livre</a></li>
							<li><a href="#">Shopee</a></li>
							<li><a href="#">Magalu</a></li>
							<li><a href="#">Amazon</a></li>
							
						</ul>
					</div> <!-- /.widget -->
				</div> <!-- /.col-lg-4 -->
				<!--
				<div class="col-lg-4">
					<div class="widget">
						<h3 class="mb-4">Recent Post Entry</h3>
						<div class="post-entry-footer">
							<ul>
								<li>
									<a href="">
										<img src="images/img_1_sq.jpg" alt="Image placeholder" class="me-4 rounded">
										<div class="text">
											<h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
											<div class="post-meta">
												<span class="mr-2">March 15, 2018 </span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="">
										<img src="images/img_2_sq.jpg" alt="Image placeholder" class="me-4 rounded">
										<div class="text">
											<h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
											<div class="post-meta">
												<span class="mr-2">March 15, 2018 </span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="">
										<img src="images/img_3_sq.jpg" alt="Image placeholder" class="me-4 rounded">
										<div class="text">
											<h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
											<div class="post-meta">
												<span class="mr-2">March 15, 2018 </span>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</div>


					</div> <!-- /.widget -->
				</div> <!-- /.col-lg-4 -->
			</div> <!-- /.row -->

			<div class="row mt-5">
				<div class="col-12 text-center">
          <!-- 
              **==========
              NOTE: 
              Please don't remove this copyright link unless you buy the license here https://untree.co/license/  
              **==========
            -->

            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script>. Todos os direitos reservados. &mdash; Designed Márcio Leal -  ME Soluções de Negócios  <!-- License information: https://untree.co/license/ -->
            </p>
          </div>
        </div>
      </div> <!-- /.container -->
    </footer> <!-- /.site-footer -->

    <!-- Preloader 
    <div id="overlayer"></div>
    <div class="loader">
    	<div class="spinner-border text-primary" role="status">
    		<span class="visually-hidden">Loading...</span>
    	</div>
    </div>

	-->

    <script src="{{url ('assets/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url ('assets/tiny-slider.js')}}"></script>

    <script src="{{url ('assets/flatpickr.min.js')}}"></script>


    <script src="{{url ('assets/js/aos.js')}}"></script>
    <script src="{{url ('assets/js/glightbox.min.js')}}"></script>
    <script src="{{url ('assets/navbar.js')}}"></script>
    <script src="{{url ('assets/counter.js')}}"></script>
    <script src="{{url ('assets/custom.js')}}"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
  </body>
  </html>
