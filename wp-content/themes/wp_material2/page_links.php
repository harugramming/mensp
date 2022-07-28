<?php
$is_for_category = is_for_category();
$previous_post = get_previous_post($is_for_category);
$next_post = get_next_post($is_for_category);
$categories = get_the_category();
$category_id = $categories[0]->term_id;
$category_name = $categories[0]->name;
?>

<?php if($previous_post || $next_post){ ?>
<div class="page_links">
<?php if($is_for_category){ ?>
<p class="cat_top_link"><span class="lsf">folder</span> <a href="<?php echo home_url() ?>/?cat=<?php echo $category_id ?>"><?php echo $category_name ?></a></p>
<?php }else{ ?>
<p class="cat_top_link"><span class="lsf">home</span> <a href="<?php echo home_url() ?>">Home</a></p>
<?php } ?>
<div class="previous_and_next">
<div class="previous_link_box">
<?php if($previous_post){
	$previous_name = $previous_post-> post_title;
	$previous_url = get_permalink($previous_post->ID);
?>
<p class="lsf previous_arrow">arrowleft</p>
<p class="previous_link"><a href="<?php echo $previous_url ?>"><?php echo $previous_name ?></a></p>
<?php } ?>
</div>

<div class="next_link_box">
<?php if($next_post){
	$next_name = $next_post-> post_title;
	$next_url = get_permalink($next_post->ID);
?>
<p class="lsf next_arrow">arrowright</p>
<p class="next_link"><a href="<?php echo $next_url ?>"><?php echo $next_name ?></a></p>
<?php } ?>
</div>

<div class="clear"></div>
</div><!-- .previous_and_next -->
</div><!-- .page_links -->
<?php } ?>