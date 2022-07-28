<?php if(get_option("is_prof_under_content")){ ?>
	<div class="profile_under_content box">
	<h2 class="accent_header"><?php echo get_option("prof_title") ?></h2>
	<div class="prof-box">
	<meta itemprop="author" content="<?php echo get_option("prof_name") ?>">
	<div class="image-text">
	<?php if(get_option("prof_image")){ ?>
		<img class="prof-image" src="<?php echo get_option("prof_image") ?>" alt="<?php echo get_option("prof_name") ?>">
	<?php } ?>
	<p class="prof-name"><?php echo get_option("prof_name") ?></p>
	<p class="prof-text">
	<?php echo nl2br(get_option("prof_text")) ?>
	<?php if(get_option("prof_url")){ ?><a style="text-decoration:underline; color:blue; display:inline-block" href="<?php echo get_option("prof_url") ?>">[詳細]</a><?php } ?></p>
	</div><!-- .image-text -->
	</div><!-- .prof-box-->
	
	<?php get_template_part("follow") ?>
	</div><!-- .profile_under_content -->
<?php } ?>