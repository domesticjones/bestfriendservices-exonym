<h2 class="testimonials-heading"></h2>
<?php if(have_rows('testimonials_collection')): ?>
  <?php if(get_field('testimonials_heading')) { echo '<h2 class="testimonials-heading">' . get_field('testimonials_heading') . '</h2>'; } ?>
  <div id="testimonials-slider">
    <?php while(have_rows('testimonials_collection')): the_row(); $data = get_sub_field('data'); ?>
      <blockquote>
        <ul class="testimonial-stars">
          <?php
            $starCount = $data['rating'];
            for($stars = 1; $stars <= 5; $stars++) {
              if($stars <= $starCount) {
                echo '<li class="star"></li>';
              }
            }
          ?>
        </ul>
        <q>&ldquo;<?php the_sub_field('testimonial'); ?>&rdquo;</q>
        <cite>~ <?php echo $data['credit']; ?></cite>
      </blockquote>
    <?php endwhile; ?>
  </div>
<?php endif; ?>
