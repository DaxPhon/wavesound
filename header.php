<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <title><?php echo get_bloginfo( 'name' ); ?></title>
    <?php wp_head();?>
  </head>
  <body>
    <script async></script>
    <header class="wavesound-header<?php if ( !is_front_page() ) { echo " subpage"; } ?>">
      <nav class="main-nav fixed-top" aria-labelledby="primary-navigation" role="navigation">
        <a class="main-nav-brand" href="<?php bloginfo('url'); ?>">
          <img class="logo" src="<?php bloginfo('template_directory'); ?>/assets/images/logo.svg" alt="logo wavesound" />
        </a>
        <button type="button" class="main-nav-toggler">
          <span class="hamburger-icon-line"></span>
          <span class="hamburger-icon-line"></span>
          <span class="hamburger-icon-line"></span>
        </button>
        <?php wavesound_main_menu(); ?>
      </nav>
      <img class="header-image" src="<?php header_image(); ?>" alt="titelbild wavesound" />
      <div class="container">
        <h1 class="page-title"><?php if ( is_front_page() ) { echo "Wavesound <em class='light'>Herborn e.V.</em>"; } else { wp_title($sep = ''); } ?></h1>
      </div>
    </header>

    <div class="main">
