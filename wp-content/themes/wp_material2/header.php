<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/blog#">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">

<!-- ファビコン -->
<?php if(get_option("favicon_setting")){ ?>
<link rel="shortcut icon" href="<?php echo get_option("favicon_setting") ?>" >
<?php } ?>

<!-- Apple touch アイコン -->
<?php if("apple_setting"){ ?>
<link rel="apple-touch-icon" href="<?php echo get_option("apple_setting") ?>">
<?php } ?>

<!-- awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<!-- ページ情報を取得 -->
<?php 
$page_title = get_the_page_title();
$description = get_the_description();
$image_url = get_image_url();
?>

<title><?php echo $page_title ?></title>
<meta name="description" content="<?php echo $description; ?>">

<!-- ogp -->
<meta property="og:title" content="<?php echo $page_title ?>" >
<meta property="og:type" content="blog" />
<meta property="og:description" content="<?php echo $description; ?>">
<meta property="og:url" content="<?php echo (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>" >
<meta property="og:image" content="<?php echo $image_url ?>" >
<meta property="og:site_name" content="<?php bloginfo('name'); ?>" >
<meta property="fb:app_id" content="<?php echo get_option('app_id') ?>" >

<!-- twitter card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="https://twitter.com/<?php echo get_option('twitter_account') ?>">

<!-- 分割ページSEO -->
<?php error_reporting(0);
	global $paged, $wp_query;
	if ( !$max_page )$max_page = $wp_query->max_num_pages;
	if ( !$paged )
	$paged = 1;
	$nextpage = intval($paged) + 1;
	if ( null === $label )$label = __( 'Next Page &raquo;' );
	if ( !is_singular() && ( $nextpage <= $max_page ) ) {
?>
<link rel="next" href="<?php echo next_posts( $max_page, false ); ?>" />
<?php }
	global $paged;
	if ( null === $label )$label = __( '&laquo; Previous Page' );
	if ( !is_singular() && $paged > 1  ) 
	{
?>
<link rel="prev" href="<?php echo previous_posts( false ); ?>" />
<?php } ?>

<!-- 404と検索結果ページはnoindex -->
<?php if(is_404() || is_search()){ ?>
	<meta name="robots" content="noindex,follow">
<?php } ?>

<?php if (is_singular()) wp_enqueue_script("comment-reply"); ?>

<?php wp_head() ?>
</head>

<body class="drawer drawer--left <?php echo implode(" ", get_body_class()); ?>">
<!-- Analytics -->
<?php if(get_option("analy_code")){
	if(get_option("reject_logged_in")){
		if(!is_user_logged_in()){
			echo get_option("analy_code");
		}
	}else{
		echo get_option("analy_code");
	} 
} ?>

<div class="main_side">
<div class="main">
<div class="header">
<div class="header_inner">

<?php
$site_title;
if(get_header_image()){
  $site_title = "<img class='header_img' src='".get_header_image()."' alt='".get_bloginfo('name')."'>";
  echo "<style>.site_desc{margin-top:20px;}</style>";
}else{
  $site_title = get_bloginfo('name');
} ?>

<?php if(!is_singular()){ ?>
  <?php if(get_header_image()){ ?>
    <h1 class="header_img"><a href="<?php echo home_url() ?>"><?php echo $site_title ?></a></h1>
  <?php }else{ ?>
    <h1 class="site_title"><a href="<?php echo home_url() ?>" class="hover_color"><?php echo $site_title ?></a></h1>
  <?php } ?>
<?php }else{ ?>
  <?php if(get_header_image()){ ?>
    <p class="header_img"><a href="<?php echo home_url() ?>"><?php echo $site_title ?></a></p>
  <?php }else{ ?>
    <p class="site_title"><a href="<?php echo home_url() ?>" class="hover_color"><?php echo $site_title ?></a></p>
  <?php } ?>
<?php } ?>

<?php if(is_desc()){ ?><p class="site_desc"><?php bloginfo("description") ?></p><?php } ?>

</div><!-- .header_inner -->
</div><!-- .header -->

<div class="main_inner">

<?php if(!is_singular() && is_ad_top_of_index()){ get_template_part("ad_728"); } ?>

<?php get_template_part("bread") ?>