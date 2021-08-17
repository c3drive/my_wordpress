<?php get_header(); ?>
      <section id="contents">
          <?php
          if(have_posts()):
            while(have_posts()):
                the_post();
            ?>
            <article>
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>
                <section class="entry-content">
                    <?php the_content(); ?>
                </section>
            </article>
            <?php
                the_content();
            endwhile;
          endif;
          ?>
      </section><!-- #contents end -->
    <?php get_sidebar(); ?>
  <?php get_footer(); ?>
