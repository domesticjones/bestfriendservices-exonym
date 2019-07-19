<?php /* Ensure to check against existance of ID for a scrollto effect instead of duplicating form ID's on a page. Maybe Modal in next phase */ ?>
<form id="funnel" type="POST" action="<?php echo get_permalink(woocommerce_get_page_id('shop')); ?>">
  <input id="pet-name" type="text" placeholder="Your Pet's Name" required>
  <select id="pet-type" required>
    <option value="" selected disabled>Type of Pet</option>
    <option value="Dog">Dog</option>
    <option value="Cat">Cat</option>
  </select>
  <div class="funnel-bottom-row">
    <span class="funnel-weight"><input id="pet-weight" type="number" value="13" required><i class="numcontrol up"></i><i class="numcontrol down"></i></span>
    <button type="submit" class="cta-button">Get Started</button>
  </div>
</form>
