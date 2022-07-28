<div class="posts">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div class="post">
  <?php if(!is_not_display_thumbnail()){ ?>
    <a href="<?php the_permalink() ?>">
    <div class="thumb_box">
    <?php if(has_post_thumbnail()){ ?>
      <?php $title=get_the_title(); the_post_thumbnail(array(350, 350), array('alt'=>$title)); ?>
    <?php }else{ ?>
      <p class="hover_color">No Image</p>
    <?php } ?>
    </div>
    </a>
  <?php }else{ ?>
<style>.post_info{width:100%; float:none; padding-bottom:10px;}</style>
  <?php } ?>

<div class="post_info">
<p class="write_date"><?php the_time('Y/n/j') ?></p>
<?php get_template_part("sns_count") ?>
<div class="clear"></div>
<h3><a href="<?php the_permalink() ?>" class="hover_color"><?php the_title() ?></a></h3>
<p class="cat_link"><span class="lsf cat_folder">folder </span><?php the_category(' ') ?></p>
</div><!-- .post_info -->
</div><!-- .post -->

<?php endwhile;
if (function_exists("pagination")) { pagination(); }
?>

<?php else: ?>
<div class="content_body">
<p>お探しの記事は見つかりませんでした。</p>
</div>
<?php endif; ?>
</div><!-- .posts -->