<?php get_header(); $blog = get_option('page_for_posts'); ?>
  <?php ex_wrap('start', 'blog_heading', '', $blog); ?>
    <h1 class="woocommerce-page-title"><?php the_field('blog_heading', $blog); if(is_category()) { echo ': ' . single_cat_title('', false); } ?></h1>
  <?php ex_wrap('end'); ?>
  <ul id="blog-wrap">
    <?php if(have_posts()): while(have_posts()): the_post(); ?>
      <a href="<?php the_permalink(); ?>">
        <li>
          <?php
            $image = get_field('logo', 'options')['alternate']['light']['url'];
            $imageClass = 'no-thumb';
            if(!empty(get_the_post_thumbnail($post->ID))) {
              $image = get_the_post_thumbnail_url($post->ID, 'medium');
              $imageClass = 'has-thumb';
            }
          ?>
          <div class="blog-image <?php echo $imageClass; ?>" style="background-image: url(<?php echo $image; ?>)">
            <?php the_post_thumbnail('medium'); var_dump(); ?>
          </div>
          <div class="blog-data">
            <h2><?php the_title(); ?></h2>
            <?php the_excerpt(); ?>
          </div>
        </li>
      </a>
    <?php endwhile; endif; ?>
  </ul>
<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>
