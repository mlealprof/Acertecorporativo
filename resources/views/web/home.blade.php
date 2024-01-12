@include ('web.header')
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
@include ('web.footer')