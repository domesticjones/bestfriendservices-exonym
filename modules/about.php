<?php
  $cols = get_field('about_columns');
  $left = $cols['left'];
  $right = $cols['right'];
?>
<div class="about-left about-color-<?php echo $left['color']; ?>" style="width: <?php echo $left['width']; ?>%">
  <?php echo $left['content']; ?>
</div>
<div class="about-right about-color-<?php echo $right['color']; ?>" style="width: <?php echo $right['width']; ?>%">
  <?php echo $right['content']; ?>
</div>
<?php ex_cta(get_field('about_call_to_action')); ?>
