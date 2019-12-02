<?php
/*
Template Name: Profile Template
*/
get_header();
?>

<?php if( !current_user_can('administrator') ) {  ?>
<style>
	#fep-menu {
		display: none;
	}
</style>
<?php } ?>
<section id="banner-profile">
	<div class="img-inner">
		<div class="container">
			<div class="banner-text-white">
				<h3>Kundeportal</h3>
			</div>
		</div>
	</div>
</section>
<section id="dashboard-pro" style="padding: 0px 20px;">
	<div class="overview-detail-inner">
		<div class="row">
			<div class="sidebar col-sm-3 col-md-3 col-lg-2 text-white p-0">
				<ul class="discription-text">
					<a href="<?php echo site_url(); ?>/profile/" style="color: #fff;">
						<li class="test pt-3 pb-3 pl-2"><span><img src="<?php bloginfo('template_url');?>/image/icon-home.png" class="img-thumbnail"></span>Hjem</li>
					</a>
					<a href="<?php echo site_url(); ?>/beskeder/" style="color: #fff;">
						<li class="pt-3 pb-3 pl-2"><span><img src="<?php bloginfo('template_url');?>/image/msg-icon.png" class="img-thumbnail"></span>Beskeder</li>
					</a>
					<a href="<?php echo site_url(); ?>/betalingsstatus/" style="color: #fff;">
						<li class="pt-3 pb-3 pl-2"><span><img src="<?php bloginfo('template_url');?>/image/status-icon.png" class="img-thumbnail"></span>Betalingsstatus</li>
					</a>
					<a href="<?php echo site_url(); ?>/dokumenter/" style="color: #fff;">
						<li class="pt-3 pb-3 pl-2"><span><img src="<?php bloginfo('template_url');?>/image/document-icon.png" class="img-thumbnail"></span>Dokumenter</li>
					</a>
					<a href="<?php echo site_url(); ?>/user-profile/" style="color: #fff;">
                        <li class="pt-3 pb-3 pl-2"><span><img src="<?php bloginfo('template_url');?>/image/profile-icon.png" class="img-thumbnail"></span>Dine oplysninger</li>
                    </a>
				</ul>
			</div>
			<div class="col-sm-9 col-md-9 col-lg-10" style="background-color: #ebebeb; padding: 30px;">
				<div class="row">
					<div class="col-md-12 col-xl-5">



						<?php echo do_shortcode('[front-end-pm]'); ?>

						<div class="tbl-class" style="color: #000;">
							<h4>Betalingsstatus</h4>
							<table class="table">
								<thead>
									<tr>
										<th>Type</th>
										<th>Beløb</th>
										<th>Forfaldsdato</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>

									<?php
									$query = new WP_Query( array(
										'post_type' => 'sliced_invoice',
										'post_status' => 'publish',
										'order' => 'DESC',
										'posts_per_page' => 5
									) );

									// $posts = $query->posts;
									// echo "<pre>"; print_r($posts);               

									if ( $query->have_posts() ):

										while ( $query->have_posts() ): $query->the_post();
									$meta = get_post_meta( get_the_ID(), '', true );

									$mydata = unserialize($meta['_sliced_payment'][0]);
									$status = $mydata[0]['status'];
									//echo "<pre>"; print_r($mydata);
									if($status == "success"){ $status = "GENNEMFØRT"; }elseif ($status == "pending") { $status = "Igangværende";}elseif ($status == "failed") { $status = "Failed";}elseif ($status == "refunded") { $status = "Refunded";}elseif ($status == "cancelled") { $status = "Cancelled";}else { $status = "Igangværende";}
							
									//echo "<pre>"; print_r($meta);
									$date = $meta[ '_sliced_invoice_due' ][ 0 ];
									$due_date = date( "d .M", $date );
									$user_id = get_current_user_id();
									$client_id = $meta[ '_sliced_client' ][ 0 ];
									if ( !current_user_can( 'administrator' ) ) {

										if ( $user_id == $client_id ) {

											?>

									<tr class="tbl-desc">
										<td>
											<?php the_title(); ?>
											<?php echo $meta['_sliced_client'][0]; ?>
										</td>
										<td>
											<?php echo $meta['_sliced_totals_for_ordering'][0]; ?>
										</td>
										<td>
											<?php echo $due_date; ?>
										</td>
										<td class="status"><a href="<?php the_permalink(); ?>"><?php echo $status; ?></a>
										</td>
									</tr>


									<?php 
                    
			                          		}else{
			                                	// echo "<tr>
			                                	// <td>No result found.</td>
			                                	// </tr>";
			                             	}
			                          	}else{
                  					?>
									<tr class="tbl-desc">
										<td>
											<?php the_title(); ?>
											<?php echo $meta['_sliced_client'][0]; ?>
										</td>
										<td>
											<?php echo $meta['_sliced_totals_for_ordering'][0]; ?>
										</td>
										<td>
											<?php echo $due_date; ?>
										</td>
										<td class="status"><a href="<?php the_permalink(); ?>"><?php echo $status; ?></a>
										</td>
									</tr>


									<?php      
										}
                   						endwhile; wp_reset_postdata(); ?>
									<?php endif; ?>
								</tbody>
							</table>
						</div>

					</div>
					<div class="col-md-12 col-xl-7">
						<?php echo do_shortcode('[nm-wp-file-uploader]'); ?>

					</div>
				</div>
			</div>
		</div>
	</div>

	<?php 
    // if ( have_posts() ) {
    //   // Load posts loop.
    //   while ( have_posts() ) {
    //     the_post(); 
        
    //     the_content(
    //       sprintf(
    //         wp_kses(
    //           array(
    //             'span' => array(
    //               'class' => array(),
    //             ),
    //           )
    //         ),
    //         get_the_title()
    //       )
    //     );        
    //   }
    // } 
?>
</section>

<?php get_footer(); ?>