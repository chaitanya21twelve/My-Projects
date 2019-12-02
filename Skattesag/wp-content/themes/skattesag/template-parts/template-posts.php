<?php
/*
Template Name: Posts Template
*/
get_header();
?>

<section id="blog-banner">

	<div class="left-img d-flex flex-wrap align-content-center">
		<div class="container">
			<div class="title text-white">

				<h2>
					<?php echo get_field("page_title"); ?>
				</h2>
			
			</div>
		</div>
	</div>
</section>
<section id="payinfo" class="blogdesc">
	<div class="middle-content">
		<div class="container">
			<?php echo get_field("page_content"); ?>
			<div class="main">
				<div class="row">

					<?php
					$query = new WP_Query( array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'order' => 'DESC',
						'posts_per_page' => -1
					) );



					if ( $query->have_posts() ):

						while ( $query->have_posts() ): $query->the_post();

						$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
					?>
					<div class="column nature">
						<div class="content">
							<a href="<?php the_permalink(); ?>"><img src="<?php echo $featured_img_url; ?>" style="width: 100%;">
					      		<h4><?php the_title(); ?></h4></a>
						</div>
					</div>
					<?php   
         				endwhile; wp_reset_postdata(); ?>
					<?php endif; ?>

				</div>
			</div>


			<div class="profile-wrap-right">
				<div class="row">
					<div class="profile-text col-md-8 d-flex flex-wrap align-content-center">
						<h2>
							<?php echo get_field("help_title"); ?>
						</h2>
					
						<p>
							<?php echo get_field("help_description"); ?>
						</p>
						<a href="<?php echo get_field("help_button_link"); ?>"><button type="button" class="btn btn-primary"><?php echo get_field("help_button_text"); ?></button></a>
					</div>
					<div class="col-md-4"> <img src="<?php echo get_field("help_image"); ?>" alt="" width="100%"> </div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
<script>
	filterSelection( "all" )

	function filterSelection( c ) {
		var x, i;
		x = document.getElementsByClassName( "column" );
		if ( c == "all" ) c = "";
		for ( i = 0; i < x.length; i++ ) {
			w3RemoveClass( x[ i ], "show" );
			if ( x[ i ].className.indexOf( c ) > -1 ) w3AddClass( x[ i ], "show" );
		}
	}

	function w3AddClass( element, name ) {
		var i, arr1, arr2;
		arr1 = element.className.split( " " );
		arr2 = name.split( " " );
		for ( i = 0; i < arr2.length; i++ ) {
			if ( arr1.indexOf( arr2[ i ] ) == -1 ) {
				element.className += " " + arr2[ i ];
			}
		}
	}

	function w3RemoveClass( element, name ) {
		var i, arr1, arr2;
		arr1 = element.className.split( " " );
		arr2 = name.split( " " );
		for ( i = 0; i < arr2.length; i++ ) {
			while ( arr1.indexOf( arr2[ i ] ) > -1 ) {
				arr1.splice( arr1.indexOf( arr2[ i ] ), 1 );
			}
		}
		element.className = arr1.join( " " );
	}


	// // Add active class to the current button (highlight it)
	// var btnContainer = document.getElementById( "myBtnContainer" );
	// var btns = btnContainer.getElementsByClassName( "btn" );
	// for ( var i = 0; i < btns.length; i++ ) {
	// 	btns[ i ].addEventListener( "click", function () {
	// 		var current = document.getElementsByClassName( "active" );
	// 		current[ 0 ].className = current[ 0 ].className.replace( " active", "" );
	// 		this.className += " active";
	// 	} );
	// }
</script>