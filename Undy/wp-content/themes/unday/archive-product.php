<?php get_header();?>

<?php $shop_page_id = wc_get_page_id('shop');?>

<?php 

$image = get_the_post_thumbnail_url($shop_page_id,'full');

$postData = get_post($shop_page_id);

?>

<section class="category_detail">

	<?php if(!empty($image)){?>

    <div class="category_banner">

            <img src="<?php echo $image;?>" alt="images">

        <div class="category_text">

            <div class="container">

                <div class="category_bar">

                    <h2><?php echo $postData->post_title;?></h2>

                </div>

            </div>

        </div>

    </div>

	<?php }?>

    <div class="container">

        <div class="boxerbriefs_min">

			<ul>

            <?php bcn_display();?>

			</ul>

			<?php /*?><ul>

                <li><a href="#">Forside <i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>

                <li><a href="#">boxerbriefs_min</a></li>

            </ul><?php */?>

        </div>

        <div class="category_list">

            <div class="row">

				

                <div class="col-md-3 col-sm-3 col-xs-12">

                    <div class="category_left">

                        <div class="doxerbriefs_left">

                            <h4>Shop</h4>

                        </div>

						<?php 

						$terms = get_terms( 'color-category', array(

							'hide_empty' => false,

						) );

						if(!empty($terms)){

						?>

                        <div class="farve_min">

                            <h5>Farve</h5>

                            <ul>

                                <?php foreach($terms as $term){

								$image = types_render_termmeta("color-category-image",array("term_id"=>$term->term_id,'url'=>true));

								if(isset($_GET['size']) && !empty($_GET['size'])){

									if(isset($_GET['color']) && $_GET['color'] == $term->term_id){

										$url = get_site_url().'/shop?size='.$_GET['size'];									

									}else{

										$url = get_site_url().'/shop?color='.$term->term_id.'&size='.$_GET['size'];

									}

								}else{

									

									if(isset($_GET['color']) && $_GET['color'] == $term->term_id){

										$url = get_site_url().'/shop';

									}else{

										$url = get_site_url().'/shop?color='.$term->term_id;

									}

								}

								?>

								<li <?php if(isset($_GET['color']) && $_GET['color'] == $term->term_id){?> class="current" <?php }?>><a href="<?php echo $url;?>" data-id="<?php echo $term->term_id;?>" style="background-image:url('<?php echo $image;?>')"></a> <span><?php echo $term->name;?></span></li>

								<?php }?>

                            </ul>

                        </div>

						<?php }?>

						<?php 

						$terms = get_terms( 'pa_size', array(

							'hide_empty' => false,

						) );

						if(!empty($terms)){

						?>

                        <div class="størrelse_min">

                            <h5>Størrelse</h5>

                            <ul>

								<?PHP foreach($terms as $term){

								if(isset($_GET['color']) && !empty($_GET['color'])){

									if(isset($_GET['size']) && $_GET['size'] == $term->term_id){

										$url = get_site_url().'/shop?color='.$_GET['color'];						

									}else{

										$url = get_site_url().'/shop?size='.$term->term_id.'&color='.$_GET['color'];

									}

									

								}else{

									if(isset($_GET['size']) && $_GET['size'] == $term->term_id){

										$url = get_site_url().'/shop';

									}else{

										$url = get_site_url().'/shop?size='.$term->term_id;

									}

								}

								?>

                                <li <?php if(isset($_GET['size']) && $_GET['size'] == $term->term_id){?> class="current" <?php }?>><a href="<?php echo $url;?>" data-id="<?php echo $term->term_id;?>"><?php echo $term->name;?></a></li>

								<?php }?>

                            </ul>
							
                        </div>

						<?PHP }?>

                        <div class="modtag_morgen">

                            <h5>Modtag i morgen</h5>

                            <div class="modtag_morgen_img">

                                <img src="<?php echo IMAGES_URL;?>/truch_icon_min.png" alt=""/>

                            </div>

                            <div class="modtag_morgen_details">

                                <p>Levering med DAO365.</p>

                                <p>Bestil inden kl 17.00 og få</p>

                                <p>leveret imorgen</p>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-md-9 col-sm-9 col-xs-12">

                    <div class="category_right">

                        <div class="row">

							 <?php 

							$mypost = array(

								'post_type' => 'product',

								'posts_per_page'=>-1

							);

							if(isset($_GET['color']) && !empty($_GET['color'])){

								$mypost['tax_query'] = array(

										array(

											'taxonomy' => 'color-category',

											'field'    => 'term_id',

											'terms'    => array($_GET['color']),

										),

									);

							}

							if(isset($_GET['size']) && !empty($_GET['size'])){

								if(isset($mypost['tax_query'])){

									$mypost['tax_query'][] = array(

												'taxonomy' => 'pa_size',

												'field'    => 'term_id',

												'terms'    => array($_GET['size']),

										);

								}else{

									$mypost['tax_query'] = array(

											array(

												'taxonomy' => 'pa_size',

												'field'    => 'term_id',

												'terms'    => array($_GET['size']),

											),

										);

								}

								

							}

							if(isset($mypost['tax_query'])){

								$mypost['tax_query']['relation'] = "AND";

							}

							

							$loop = new WP_Query( $mypost );

							if ( $loop->have_posts() ): $i = 1; while ( $loop->have_posts() ) : $loop->the_post();							

							$checkSubscription = get_post_meta(get_the_ID(),'_subscriptio',true);

							if($checkSubscription == "yes"){ continue;}

							$product = wc_get_product( get_the_ID() );

							$image = get_the_post_thumbnail_url(get_the_ID(),'full');

							$hoverimage = types_render_field("product-hover-image",array("url"=>true));

							if(empty($hoverimage)){

								$hoverimage = $image;

							}
							
							if(isset($_GET['size']) && !empty($_GET['size'])){
								$curSize = get_term($_GET['size'],'pa_size');
								$availableVariations = $product->get_available_variations();
								if(!empty($availableVariations)){
									$found =  false;
									$available = array();
									foreach($availableVariations as $availableVariation){
										if(isset($availableVariation['attributes']['attribute_pa_size'])){
											$available[] = $availableVariation['attributes']['attribute_pa_size'];
										}
									}
								}
								if(!in_array($curSize->slug,$available)){
									continue;
								}
							}

							?>

                            <div class="col-md-4 col-sm-4 col-xs-6">

                                <div class="category_min_box">

                                    <div class="category_min_images">

                                        <a href="<?php the_permalink();?>" class="product-image-hover">

										<img src="<?php echo $image;?>" alt="<?php the_title();?>" class="main-image" >

										<img src="<?php echo $hoverimage;?>" alt="<?php the_title();?>" class="hover-image" >

										<?php ?>

										</a>

                                    </div>

                                    <div class="category_min_text">

                                        <h3><a href="<?php the_permalink();?>"><?php echo mb_strimwidth(get_the_title(), 0, 20, '...');;?></a></h3>

                                        <?php 

										  echo $product->get_price_html();

										  ?>

										<?php /*?><span>99 kr.</span><?php */?>

                                    </div>

                                </div>

                            </div>

							<?php endwhile; 

							

							else: ?>

							

							<div class="col-xs-12">

                                <div class="category_min_box">

                                    <div class="category_min_text">

                                        <p>No Products Found</p>

										<?php /*?><span>99 kr.</span><?php */?>

                                    </div>

                                </div>

                            </div>

							

							<?php endif; wp_reset_query();?>

                            

                            

                        </div>

						

                        <div class="category_hading">

                            <?php 

							echo apply_filters('the_content',$postData->post_content);

							?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        

    </div>

</section>

<?php get_footer();?>

