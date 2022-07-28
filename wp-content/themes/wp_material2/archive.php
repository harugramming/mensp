<?php get_header() ?>

<h2 class="archive_title accent_header">
<?php if(is_category()){ ?><span class="lsf">folder </span><?php single_cat_title(); ?>
<?php }else if(is_tag()){ ?><span class="lsf">tag </span><?php single_cat_title(); ?>
<?php }else if(is_date()){ ?><span class="lsf">time </span><?php echo year_month(); echo day() ?>
<?php } ?>
</h2>

<?php error_reporting(0);
if(is_category() && category_description != ""){ ?>
<div class="category_desc"><?php echo nl2br(category_description()); ?></div>
<?php } ?>

<?php get_template_part("main_loop") ?>

<?php get_template_part("ad_w_rectangle") ?>

<?php get_template_part("cat_lists") ?>

<?php if(wp_is_mobile()){ get_template_part("ad_728"); } ?>

<?php get_sidebar() ?>
<?php get_footer() ?>