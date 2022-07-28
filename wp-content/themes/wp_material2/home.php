<?php get_header() ?>

<h2 class="archive_title accent_header">記事一覧</h2>
<?php get_template_part("main_loop") ?>

<?php get_template_part("ad_w_rectangle") ?>

<?php get_template_part("cat_lists") ?>

<?php if(wp_is_mobile()){ get_template_part("ad_728"); } ?>

<?php get_sidebar() ?>
<?php get_footer() ?>