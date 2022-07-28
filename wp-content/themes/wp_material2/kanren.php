<?php error_reporting(0);
$count = get_count_kanren();
if($count > 0 && is_single()){
	$tags = get_the_tags();
	$categories = get_the_category();
	$id = get_the_ID();
	$args;

	if($categories){
		$cat_array = array();
		foreach($categories as $category){
			array_push($cat_array, $category->slug);
			if($cats_string)$cats_string .= ",";
			$cats_string .= $category->slug;
		}
	}

	if($tags){
		$tag_array = array();
		foreach($tags as $tag){	
			array_push($tag_array, $tag->slug);
		}

		$args = array(
			'tax_query' => array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => $cat_array,
					'include_children' => true,
					'operator' => 'IN'
				),
				array(
					'taxonomy' => 'post_tag',
					'field' => 'slug',
					'terms' => $tag_array,
					'include_children' => false,
					'operator' => 'IN'
				)
			),
			'post__not_in' => array($id),
			'orderby'=>'rand',
			'posts_per_page' => $count
		);
	}else{
		$args = array(
			'category_name' => $cats_string,
			'post__not_in' => array($id),
			'orderby'=>'rand',
			'posts_per_page' => $count
		);
	}

	$count_LorR = 0;
	$the_query = new WP_Query($args);
	if($the_query->have_posts()){ ?>
		<div class="kanren box">
		<h2 class="under_content accent_header">関連記事</h2>
		<div class="kanren_posts cat_list">
		<?php while($the_query->have_posts()){$the_query->the_post(); $count_LorR++; ?>
			<div class="post <?php echo $count_LorR%2==0? right: left ?>">
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
		<?php } ?>
		</div><!-- .kanren_posts -->
		<div class="clear"></div>

		<?php if($tags){ ?>
			<p class="cat_link tag_link"><span class="lsf tag_icon">tag </span>
			<?php foreach($tags as $tag){ ?>
				<a href="<?php echo home_url().'/?tag='.$tag->slug; ?>">
				<?php echo $tag->name; ?>
				</a>
			<?php } ?>
			</p>
		<?php } ?>

		<?php if($categories){ ?>
			<p class="cat_link"><span class="lsf cat_folder">folder </span>
			<?php foreach($categories as $category){ ?>
				<a href="<?php echo home_url().'/?cat='.$category->cat_ID; ?>">
				<?php echo $category->name; ?>
				</a>
			<?php } ?>
			</p>
		<?php } ?>
		</div><!-- .kanren -->
	<?php }
} ?>