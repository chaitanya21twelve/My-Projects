<?php
/*
Template Name: Call Template
*/
get_header();
?>

<section id="" class="telefonmode-wrap" style="background-color: #f5f5f5 !important;">
	<div class="middle-content">
		<div class="container-fluid">

			<div class="profile-wrap-left ">
				<div class="row">
					<div class="col-xl-12">
						<div class="telefonmode-inner text-center">
							<div class="m-auto content-title">
								<h1>Book et gratis telefonmøde her</h1>
								<p>Aftal et gratis telefonmøde, hvor vi gennemgår din skattesag</p>
								<p>Hvis det haster, er du altid velkommen til at ringe til os på 2020 0520.</p>
								<p>Vi vil meget gerne læse den afgørelse, du vil klage over, inden telefonmødet. Alle oplysninger behandles fortroligt.</p>
							</div>
							<p></p>
							<?php echo do_shortcode('[contact-form-7 id="277" title="Book a free conference call"]'); ?>
						</div>
					</div>
					<!-- <div class="profile-text col-md-4 d-flex flex-wrap align-content-center p-0">
						<img src="http://simplewebdesign.dk/skattesag/wp-content/themes/skattesag/image/contact.jpg" width="100%">
					</div> -->
				</div>
			</div>

		</div>
	</div>
</section>

<?php get_footer(); ?>