<?php
/*
  Template Name: De bedste gaveideer til maend

 */
get_header();
?>

<div class="innerContentPage">
    <div class="container">

        <div class="commonContentBlock">
            <h1>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </h1>
            <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            <p>Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. </p>
            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
        </div>

        <div class="commonImagesBlock">
            <div class="commonImg">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img_01.png">
                <a href="javascript:void(0);" class="overlayButton">dummy text ever since</a>
            </div>
            <p>Editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.</p>
        </div>

        <div class="commonContentBlock">
            <h3>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </h3>
            <p>All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>
        </div>


        <div class="productListing">

            <ul class="products">  
                <?php
                    $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 4, 
                    'order' => 'asc',
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

        <div class="commonContentBlock">
            <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        </div>
        
        <div class="productListing">
                        <ul class="products">  
                <?php
                    $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 4, 
                    'order' => 'asc',
                    'meta_query'     => array( array(
                    'key' => 'select_product_type',
                    'value' => 'bottom_product' ,
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
        
        <div class="commonContentBlock">
            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. </p>
            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
        </div>

    </div>
</div> 


<?php get_footer(); ?>

