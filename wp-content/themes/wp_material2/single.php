<?php get_header() ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<article itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
<?php $headline = $post -> post_excerpt;
if(!$headline){
	$headline = mb_substr(strip_tags(get_the_content()), 0, 100);
} ?>
<meta itemprop="headline" content="<?php echo $headline ?>">
<meta itemprop="mainEntityOfPage" content="<?php the_permalink() ?>">

<?php $author_name = ""; ?>
<?php 
$author = get_the_author();
if($author){
	$author_name = $author;
}else{
	$author_name = "不明";
} ?>
<meta itemprop="author" content="<?php echo $author_name ?>">
<span style="display:none" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
	<meta itemprop="url" content="<?php echo get_image_url() ?>">
</span>
<span style="display:none" itemprop="publisher" itemscope itemtype='https://schema.org/Organization'>
	<meta itemprop="name" content="<?php echo bloginfo("name") ?>">
	<span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
		<meta itemprop="url" content="<?php echo get_site_image_url() ?>">
	</span>
</span>

<div class="content_header">
<h1><?php the_title() ?></h1>
<p class="write_date"><span class="lsf calendar">calendar </span><time itemprop="datePublished" datetime="<?php the_time("Y-m-d") ?>"><?php the_time("Y年m月d日") ?></time></p>
<?php if(is_show_rewrite_date() && get_the_date() != get_the_modified_date()){ ?>
	<p class='write_date'><span class='lsf calendar'>reload </span><time itemprop="dateModified" datetime="<?php the_modified_time("Y-m-d") ?>"><?php the_modified_time("Y年m月d日"); ?></time></p>
<?php }else{ ?>
	<time itemprop="dateModified" datetime="<?php the_time("Y-m-d") ?>" />
<?php } ?>

<p class="cat_link"><span class="lsf cat_folder">folder </span><span itemprop="articleSection"><?php the_category(' ') ?></span></p>

<?php if(has_post_thumbnail() && is_eyecatch()){
	$title= get_the_title(); the_post_thumbnail('full', array( 'alt'=>$title, 'class'=>'eye_catch'));
} ?>

<?php if(is_share_top_of_content()){ ?>
	<?php get_template_part("share") ?>
<?php } ?>
</div>

<div class="clear"></div>

<div class="content_body" itemprop="articleBody">
<?php the_content() ?>
<div class="clear"></div>
<?php wp_link_pages(array(
	'before' => '<div class="page-links">' .'Pages:',
	'after' => '</div>'
)); ?>
</div>
</article>

<?php get_template_part("under_content") ?>

<?php endwhile; endif; ?>

<?php get_template_part("cat_lists") ?>

<?php get_sidebar() ?>
<?php get_footer() ?>