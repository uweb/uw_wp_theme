<?php
/**
 * Template Name: No image
 */
?>

<?php get_header();
     // $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
      $sidebar = get_post_meta($post->ID, "sidebar");   ?>

<div class="uw-hero-image hero-blank">
	<h1 class="container-fluid uw-site-title-blank"><?php the_title(); ?></h1>
</div>

<div class="container-fluid uw-body">

  <div class="row">

    <div class="col-md-<?php echo (($sidebar[0]!="on") ? "8" : "12" ) ?> uw-content" role='main'>
    <?php echo uw_breadcrumbs() ?>

      <div id='main_content' class="uw-body-copy" tabindex="-1">

        <?php
          // Start the Loop.
          while ( have_posts() ) : the_post();

            //the_content();
            get_template_part( 'template-parts/content', 'page-noheader' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
              comments_template();
            }

          endwhile;
        ?>

      </div>

    </div>

    <?php
      if($sidebar[0]!="on"){
        get_sidebar();
      }
    ?>

  </div>

</div>

<?php get_footer(); ?>

