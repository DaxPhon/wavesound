<?php
/*
  Template Name: Search Page
*/
get_header();
global $wp_query;
?>

<h1 class="search-title"><?php echo $wp_query->found_posts; ?><?php _e( ' Suchergebnisse für ', 'locale' ); ?>"<?php the_search_query(); ?>"</h1>

  <?php if ( have_posts() ) { ?>

      <ul class="search-results">

      <?php while ( have_posts() ) { the_post(); ?>

         <li class="result">
           <h3><a href="<?php echo get_permalink(); ?>">
             <?php search_title_highlight(); ?>
           </a></h3>
           <?php  the_post_thumbnail('medium') ?>
           <?php echo substr(search_excerpt_highlight(), 0,150); ?>
           <div class="read-more"><a href="<?php the_permalink(); ?>">mehr &hellip;</a></div>
         </li>

      <?php } ?>

      </ul>

     <?php echo paginate_links(); ?>

  <?php } ?>

<?php get_footer(); ?>
