<?php
/*
Template Name: Priser Subpage Template
*/
get_header();
?>

<section id="blog-banner">
	<div class="left-img d-flex flex-wrap align-content-center">
		<div class="container">
			<div class="title text-white">
				<h2><?php the_title(); ?></h2>
			</div>
		</div>
	</div>
</section>
<section id="payinfo" class="instanser Faste-priser">
	<div class="middle-content">
		<div class="container">
			<div class="main">
				<div class="row">
					<div class="instanser-inner col-sm-12">
						<?php echo get_field("main_content"); ?>
						<!-- <p>Skatteforvaltningen i Danmark varetages af syv styrelser:</p>
						<p>I langt de fleste af de sager vi påklager, er afgørelserne truffet af enten Skattestyrelsen eller Motorstyrelsen.</p> -->
					</div>
					<?php echo get_field("content_block"); ?>
					<!-- <div class="Faste-priser-bg">
						<h6>Eksempel:</h6>
						<p>Du har modtaget en afgørelse fra Skattestyrelsen, men mener, at Skattestyrelsen med urette har beskattet dig af fri bil og af et beløb, der er blevet indsat på din konto. Du ønsker derfor din skatteansættelse nedsat med i alt kr. 250.000. Påstanden er derfor en samlet nedsættelse på kr. 250.000 og sagen vedrører to klagepunkter.</p>
						<p>Med udgangspunkt i vores faste intropriser, vil den faste pris i ovenstående eksempel være kr. 29.990 inkl. moms for at føre sagen fra Skattestyrelsen har truffet afgørelse til Skatteankestyrelsen, et skatteankenævn eller Landsskatteretten har truffet afgørelse.</p>
						<h6>Hvis du er berettiget til omkostningsgodtgørelse udgør din egenbetaling maksimalt halvdelen, dvs. kr. 14.995 inkl. moms.</h6>
						<p>Den faste pris inkluderer som udgangspunkt alt arbejde forbundet med sagen. Arbejdet med den konkrete sag specificeres i vores rådgiveraftale.</p>
					</div>
					<div class="pt-5">
						<h4>Det med smat SKREVET MED STORT</h4>
						<p>Vores faste priser er baseret på, at vi kommunikerer via vores kundeportal og/eller telefon. Hvis du ønsker et fysisk møde med os, er du velkommen hos os. Hvis du ønsker, at vi skal mødes hos dig, betaler du for kørsel til en lavere timesats og for kørsel efter Statens takster (2019: 3,56 pr. km).</p>
						<p>Møde med sagsbehandleren i Skatteankestyrelsen er som udgangspunkt et telefonmøde. Hvis vi sammen vurderer, at vi med fordel kan tage et fysisk møde med sagsbehandleren, afregnes der ligeledes for kørsel til dette møde.</p>
						<p>Eventuel kørsel til møde med skatteankenævnet eller retsmøde i Landsskatteretten afregnes ligeledes efter samme principper og er således ikke omfattet af den faste pris.</p>
						<p>Årsagen, til at kørsel til møder ikke er inkluderet, er, at udgiften er variabel og afhænger af, hvor i landet mødet foregår.</p>
						<p>Udarbejdelse af materiale såsom kørselsregnskab og lignende er ikke omfattet af den faste pris.</p>
					</div> -->
				</div>
				<div class="profile-wrap-right">
					<div class="row">
						<div class="profile-text col-md-8 d-flex flex-wrap align-content-center">
							<h2><?php echo get_field("help_title"); ?></h2>
							<p><?php echo get_field("help_text"); ?></p>
							<?php if(get_field("help_button_link") != ''){ ?><a href="<?php echo get_field("help_button_link"); ?>"><button type="button" class="btn btn-primary"><?php echo get_field("help_button_text"); ?></button></a> <?php } ?>
						</div>
						<div class="col-md-4"> <img src="<?php echo get_field("right_image"); ?>" alt="" width="100%"> </div>
					</div>
				</div>
			
			</div>			
		</div>
	</div>
</section>
<?php get_footer(); ?>
