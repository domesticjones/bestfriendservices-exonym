<?php
  $funnelCatsIncludeCat = get_field('sales_funnel_categories_for_cats', 'options');
  $funnelCatsIncludeDog = get_field('sales_funnel_categories_for_dogs', 'options');
  $funnelCatsCatArgs = array(
    'include'     => $funnelCatsIncludeCat,
    'hide_empty'  => false,
  );
  $funnelCatsDogArgs = array(
    'include'     => $funnelCatsIncludeDog,
    'hide_empty'  => false,
  );
  $funnelCatsCat = get_terms('product_cat', $funnelCatsCatArgs);
  $funnelCatsDog = get_terms('product_cat', $funnelCatsDogArgs);
  $funnelCatsPrint = '';
  if($funnelCatsCat) {
    $funnelCatsPrint .= '<nav class="cats-list cats-list-cat">';
      foreach($funnelCatsCat as $cat) {
        $thumbId = get_term_meta( $cat->term_id, 'thumbnail_id', true);
        $funnelCatsPrint .= '<a href="' . get_term_link($cat->term_id, 'product_cat') . '">' . wp_get_attachment_image($thumbId, 'thumbnail') . '<span>' . $cat->name . '</span></a>';
      }
    $funnelCatsPrint .= '</nav>';
  } if($funnelCatsDog) {
    $funnelCatsPrint .= '<nav class="cats-list cats-list-dog">';
      foreach($funnelCatsDog as $cat) {
        $thumbId = get_term_meta( $cat->term_id, 'thumbnail_id', true);
        $funnelCatsPrint .= '<a href="' . get_term_link($cat->term_id, 'product_cat') . '">' . wp_get_attachment_image($thumbId, 'thumbnail') . '<span>' . $cat->name . '</span></a>';
      }
    $funnelCatsPrint .= '</nav>';
  }
  $funnelInfoDesc = get_field('sales_funnel_info_description', 'options');
  $funnelChoiceDesc = get_field('sales_funnel_choice_description', 'options');
  $funnelStep1Start = '<section id="funnel-info" class="funnel-step is-active">';
  $funnelStep2Start = '<section id="funnel-choice" class="funnel-step">';
  $funnelStepEnd = '</section>';
  ob_start();
    include(TEMPLATEPATH . '/modules/funnel-form.php');
    $funnelForm = ob_get_contents();
  ob_end_clean();
  $funnelEscape = '<a href="#" class="modal-close">Put customization temporarily on hold</a>';
  $funnelNavA = '<nav class="funnel-modal-nav"><a href="#" class="funnel-step-1 cta-button cta-color-green">Next: Choose Style</a>' . $funnelEscape . '</nav>';
  $funnelNavB = '<nav class="funnel-modal-nav"><a href="' . get_permalink(wc_get_page_id('shop')) . '" class="cta-button cta-color-green">Browse All Styles</a><a href="#edit">Edit Your Pet\'s Info</a></nav>';
  $funnelContentA =  $funnelStep1Start . $funnelInfoDesc . $funnelForm . $funnelNavA . $funnelStepEnd;
  $funnelContentB =  $funnelStep2Start . '<h2>Find the perfect memorial for <span class="funnel-name"></span></h2>' . $funnelChoiceDesc . $funnelCatsPrint . $funnelNavB . $funnelStepEnd;
  $funnelContent =  $funnelContentA . $funnelContentB;
  echo ex_modal('find', $funnelContent);

?>
