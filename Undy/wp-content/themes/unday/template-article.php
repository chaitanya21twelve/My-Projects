<?php

/*

	Template Name: Articles

*/

get_header();

$featured_img_url = get_the_post_thumbnail_url($post->ID, 'full');
?>


<section class="category_detail">

	
   

	
    <div class="container">
		<div class="boxerbriefs_min">

			

			
        </div>
       
        <div class="category_list">

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="category_right">

                        <div class="row">

							 
                            <?php
						
						$query = new WP_Query( array( 
									'post_type' => 'post',
									'post_status' => 'publish',
									'orderby'=>'date',
									'order'=>'DESC',
									'posts_per_page' => -1
								
							) );                 

							if ( $query->have_posts() ) : 
							while ( $query->have_posts() ) : $query->the_post(); 
						
							$featured_img_url = get_the_post_thumbnail_url($post->ID, 'full');
						
								
						?> 
							
							
							
							<div class="col-md-4 col-sm-4 col-xs-6">

                                <div class="category_min_box">

                                    <div class="category_min_images">

                                        <a href="<?php the_permalink(); ?>">

										<img src="<?php echo $featured_img_url; ?>" alt="" class="main-image">

										
										</a>

                                    </div>

                                    <div class="category_min_text">

                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                       
										
                                    </div>

                                </div>

                            </div>

							
                        <?php 
							
					endwhile; 
					wp_reset_postdata(); 
							endif; 
							?>

							
                         

                        </div>

					

                    </div>

                </div>

            </div>

        </div>

        

    </div>

</section>


<?php get_footer();?>