<?php
	$val = '';
	if(is_search()) {
		$val = get_search_query();
	}
?>
<form role="search" method="get" class="search-form-inline" action="<?php echo home_url( '/' ); ?>">
	<input type="search" class="search-field" placeholder="Search&mldr;" value="<?php echo $val; ?>" name="s" title="Search for:" />
	<button type="submit" class="search-submit" value="Search" /><span>Search</span></button>
</form>
