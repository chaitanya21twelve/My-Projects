<?php
/*
Template Name: Common Pages Template
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
<section id="payinfo" class="blogdesc instanser">
	<div class="middle-content">
		<div class="container">
			<div class="main">
				<div class="row">
					<div class="instanser-inner col-sm-12">
						<?php echo get_field("main_content"); ?>
						<!-- <p>Skatteforvaltningen i Danmark varetages af syv styrelser:</p>
						<ul>
							<li>Gældsstyrelsen, der forestår inddrivelse af gæld til det offentlige</li>
							<li>Vurderingsstyrelsen, der foretager offentlig vurdering af ejendomme og grunde</li>
							<li>Skattestyrelsen, der forestår afregning og kontrol af skatter og afgifter på person, erhvervs- og selskabsområderne</li>
							<li>Toldstyrelsen, der forestår afregning og kontrol på toldområdet</li>
							<li>Motorstyrelsen, der forestår registrering, afgiftsberegning og kontrol af motorkøretøjer i Danmark</li>
						</ul>
						<p>I langt de fleste af de sager vi påklager, er afgørelserne truffet af enten Skattestyrelsen eller Motorstyrelsen.</p> -->
					</div>
					<div class="instanser-inner-box">
						<div class="row">
							<?php echo get_field("content_block"); ?>
							<!-- <div class="col-md-6">
								<h5>Skatterådet</h5>
								<p>Skatterådet er et kollegialt lægmandsorgan, der består af 19 medlemmer.</p>
								<p>Skatterådet bistår Skatteforvaltningen ved forvaltningen af lovgivning om skatter og afgifter.</p>
								<p>Skatterådet afgør sager, som Skatteforvaltningen forelægger for Skatterådet til afgørelse. Det kan eksempelvis være bindende svar, hvor de har principiel betydning.</p>
							</div>
							<div class="col-md-6">
								<h5>Skatteankestyrelsen</h5>
								<p>Skatteankestyrelsen behandler klager over afgørelser truffet af Skattestyrelsen, Vurderingsstyrelsen, Motorstyrelsen, Gældsstyrelsen, Toldstyrelsen, Spillemyndigheden og Skatterådet.</p>
								<p>Skatteankestyrelsen fungerer som fælles sekretariat for flere administrative klageinstanser. Skatteankestyrelsen behandler og forbereder således forslag til afgørelse i klagesager, hvor et skatteankenævn eller Landsskatteretten træffer afgørelse.</p>
								<p>Skatteankestyrelsen træffer desuden selv afgørelse i en række sager.</p>
							</div>
							<div class="col-md-6">
								<h5>Skatteankenævn</h5>
								<p>De 19 skatteankenævn er lokale nævn, der træffer afgørelse i sager vedrørende fysiske personer og dødsboer vedrørende blandt andet ansættelse af indkomstskat.</p>
								<p>Medlemmerne af skatteankenævne er udnævnt efter kommunalbestyrelsens indstilling og har ikke nødvendigvis skattefaglig indsigt.</p>
								<p>Skatteankestyrelsen træffer desuden selv afgørelse i en række sager.</p>
							</div>
							<div class="col-md-6">
								<h5>Landsskatteretten</h5>
								<p>Landsskatteretten består af en ledende retsformand, fire retsformænd og 34 retsmedlemmer. </p>
								<p>Landsskatterettens medlemmer er udnævnt af Folketinget og Skatteministeren for en periode på seks år.</p>
								<p>Landsskatteretten træffer afgørelse  i sager, hvor klagen ikke afgøres af de øvrige administrative klageinstanser og alle klager over Skatterådets afgørelser.</p>
								<p>Landsskatteretten træffer blandt andet afgørelse i sager vedrørende selskabsskat, moms, told og afgifter  truffet af Skattestyrelsen og Toldstyrelsen, i sag vedrørende fysiske personer, dødsboer, ejendomsvurdering mv., hvis du har valgt, at sagen skal behandles af Landsskatteretten, og i alle principielle sager.</p>
								<p>Landsskatteretten afgør sagerne ved skriftlig votering eller på et retsmøde.</p>
							</div> -->
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>
</section>
<?php get_footer(); ?>
