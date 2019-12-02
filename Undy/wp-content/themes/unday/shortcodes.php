
 <div class="productListing">

         	<ul class="products">  
                <?php
                    $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 4, 
                    'order' => 'desc',
                    'meta_query'     => array( array(
                    'key' => 'select_product_type',
                    'value' => 'top_product' ,
                    'compare' => '=',
                ) ),
                );

                $loop = new WP_Query( $args );

                while ( $loop->have_posts() ) : $loop->the_post();
                    global $product;
                    ?>
                <li class="product">
                    <a href="<?php echo get_permalink(); ?>">
                        <div class="productImage">
                            <?php echo woocommerce_get_product_thumbnail(); ?>
                        </div>
                        <div class="productContent">
                            <h3><?php echo get_the_title(); ?></h3>
                            <span class="priceProduct"><?php $price = get_post_meta( get_the_ID(), '_price', true ); ?>
                                <p><?php echo wc_price( $price ); ?></p></span>
                        </div>
                    </a>
                </li>

                <?php
                endwhile;
               wp_reset_query();
                ?>
            </ul>
        </div>