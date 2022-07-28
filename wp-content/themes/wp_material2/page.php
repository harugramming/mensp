<?php get_header() ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<article itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
<?php $headline = $post -> post_excerpt;
if(!$headline){
	$headline = mb_substr(strip_tags(get_the_content()), 0, 100);
} ?>
<meta itemprop="headline" content="<?php echo $headline ?>">
<meta itemprop="mainEntityOfPage" content="<?php the_permalink() ?>">

<div class="content_header">
<h1><?php the_title() ?></h1>

<p class="write_date"><span class="lsf calendar">calendar </span><time itemprop="datePublished" datetime="<?php the_time("Y-m-d") ?>"><?php the_time("Y年m月d日") ?></time></p>
<?php if(is_show_rewrite_date() && get_the_date() != get_the_modified_date()){ ?>
	<p class='write_date'><span class='lsf calendar'>reload </span><time itemprop="dateModified" datetime="<?php the_modified_time("Y-m-d") ?>"><?php the_modified_time("Y年m月d日"); ?></time></p>
<?php }else{ ?>
	<time itemprop="dateModified" datetime="<?php the_time("Y-m-d") ?>" />
<?php } ?>
<div class="space"></div>

<?php if(has_post_thumbnail() && is_eyecatch()){
	$title= get_the_title(); the_post_thumbnail('full', array( 'alt'=>$title, 'class'=>'eye_catch'));
} ?>

<span style="display:none" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
<?php if(has_post_thumbnail()){
	$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id());
	$thumbnail_url = $thumbnail[0]; ?>
		<meta itemprop="url" content="<?php echo $thumbnail[0] ?>">
		<meta itemprop="width" content="<?php echo $thumbnail[1] ?>">
		<meta itemprop="height" content="<?php echo $thumbnail[2] ?>">
<?php }else{
	$image_url = get_stylesheet_directory_uri()."/images/no_image.png"; ?>
	<meta itemprop="url" content="<?php echo $image_url ?>">
	<meta itemprop="width" content="270">
	<meta itemprop="height" content="270">
<?php } ?>
</span>

<?php if(is_share_top_of_content()){ ?>
	<?php get_template_part("share") ?>
<?php } ?>
</div>

<div class="clear"></div>

<div class="content_body">
<?php the_content() ?>
<div class="clear"></div>
<?php wp_link_pages(array(
	'before' => '<div class="page-links">' .'Pages:',
	'after' => '</div>'
)); ?>
</div>

<?php get_template_part("under_content") ?>

<?php endwhile; endif; ?>

<?php get_template_part("cat_lists") ?>

<?php get_sidebar() ?>
<?php get_footer() ?>