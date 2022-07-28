<?php 
$count_cat = get_count_cat_post(); //カテゴリーごとに表示する記事数
?>

<div class="cat_lists">

<?php
$args = array('parent'=>0);
$categories = get_categories($args);
$count = 1;
foreach($categories as $category){ ?>
	<div class="cat_list<?php if($count%2==0){echo " right";}else{echo " left";} ?>">
	<h2 class="cat_header accent_header"><span class="lsf">folder </span><?php echo $category->name; ?></h2>
<?php	$cat_id = $category->cat_ID;
	$args = array('cat'=>$cat_id, 'posts_per_page' => $count_cat);
	$the_query = new WP_Query($args);

	if($the_query->have_posts()){
		while($the_query->have_posts()){
			$the_query->the_post();
?>
	<div class="post">
	<?php if(!is_not_display_thumbnail()){ ?>
	<a href="<?php the_permalink() ?>">
		<div class="thumb_box">
		<?php if(has_post_thumbnail()){
			$title= get_the_title();
			the_post_thumbnail(array(200, 200), array( 'alt' =>$title, 'title' => $title));
		}else{ ?>
			<p class="hover_color">No Image</p>
		<?php } ?>
		</div><!-- .thumb_box -->
	</a>
	<?php }else{ ?>
<style>.cat_list .post_info{width:100%; float:none; padding:8px 3px 8px 8px;}</style>
	<?php } ?>

	<div class="post_info">
		<p class="write_date"><?php the_time('Y/n/j') ?></p>
		<?php get_template_part("sns_count") ?>
		<div class="clear"></div>
		<h3><a href="<?php the_permalink() ?>" class="hover_color"><?php the_title(); ?></a></h3>
	</div><!-- .post_info -->
	</div><!-- .post -->
<?php
		}
	}
?>
	<a class="more accent_color hover_back_color" href="<?php echo home_url() ?>/?cat=/<?php echo $category->cat_ID ?>">more...</a>
	</div><!-- .cat_list -->
<?php $count++;
} ?>

</div><!-- .cat_lists -->