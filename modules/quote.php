<?php
  $author = get_field('quote_author');
  $quote = get_field('quotation');
  $color = get_field('quote_color');
?>
<blockquote class="quote-wrap quote-color-<?php echo $color; ?>">
  <q>&ldquo;<?php echo $quote; ?>&rdquo;</q>
  <cite>~ <?php echo $author; ?></cite>
</blockquote>
