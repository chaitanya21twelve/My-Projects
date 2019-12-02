<?php
/*
Template Name: Om Os
*/
get_header();
?>
<section id="payinfo-banner">
	<div class="img-inner text-right">
		<img src="<?php echo get_field("banner_image"); ?>" alt="">
	</div>
	<div class="left-img d-flex flex-wrap align-content-center">
		<div class="container">
			<div class="text-white">
				<h2><?php the_title(); ?></h2>
			</div>
		</div>
	</div>
</section>
<section id="payinfo" class="about-us">
	<div class="middle-content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-left">
					<div class="m-auto content-title">
						<?php echo get_field("main_content"); ?>
						<!-- <p>Skattesag.com drives af Bach & Albert ApS, der er en juridisk rådgivningsvirksomhed specialiseret i levering af en række juridiske ydelser, herunder særligt at føre skatte- og afgiftssager i det administrative klagesystem.</p>
						<p class="p1">Vi fører som udgangspunkt din sag fra start til slut for en fast og forudaftalt pris. Den eneste variable omkostning er kørsel. Da vi har sager i hele landet, er eventuel kørsel til møder med dig og/eller Skatteankestyrelsen, skatteankenævn og Landsskatteretten ikke inkluderet i prisen.Vi oplever at mange skattesager ikke bliver ført, at sagerne bliver ført på et dårligt grundlag, og at det er dyrt at få sagerne ført. </p> -->
					</div>
				</div>
			</div>
			<div class="about-us-bg mt-4">
				<?php echo get_field("content_block"); ?>
				<!-- <div class="row">
					<div class="about-box col-md-4 text-center">
						<img src="http://simplewebdesign.dk/skattesag/wp-content/themes/skattesag/image/mission.png" alt="">
						<h5>Mission</h5>
						<p>Vi fører skattesager på et højt fagligt niveau ved de administrative klageinstanser.</p>
					</div>
					<div class="about-box col-md-4 text-center">
						<img src="http://simplewebdesign.dk/skattesag/wp-content/themes/skattesag/image/vision.png" alt="">
						<h5>Vision</h5>
						<p>Vi vil være den foretrukne rådgiver til at føre skatte- og afgiftssager ved de administrative klageinstanser. Vi vil tiltrække og udvikle de bedste medarbejdere.</p>
					</div>
					<div class="about-box col-md-4 text-center">
						<img src="http://simplewebdesign.dk/skattesag/wp-content/themes/skattesag/image/Værdier.png" alt="">
						<h5>Værdier</h5>
						<p>Vores værdier er tryghed, ordentlighed og faglighed.</p>
					</div>
				</div>
				<div class="about-description-text">
					<p>Tryghed for vores medarbejdere i deres ansættelse og arbejdsvilkår. Tryghed for vores kunder i relation til deres sag og vores samarbejde hermed.</p>
					<p>Ordentlighed i forhold til egne medarbejderes vilkår. Ordentlighed i forhold til kunder, medarbejdere i styrelser og klageinstanser, andre samarbejdspartnere og konkurrenter. Vi taler ikke dårligt om nogen. </p>
					<p>Ordentlighed i forhold til løsning af opgaver og gennemskuelige priser. </p>
					<p>Faglighed, fordi det er hjørnestenen i det arbejde, vi udfører. Vores kunder kan forvente, at deres sag behandles på et højt niveau. Modtagerne af vores arbejde kan forvente, at vores arbejde er på højt niveau.</p>
				</div> -->
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>