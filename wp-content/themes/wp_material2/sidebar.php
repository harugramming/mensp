<?php get_template_part("main_footer") ?>
</div><!-- .main_inner -->
</div><!-- .main -->

<!-- サイドバー -->
<div class="side sidebar_color" role="navigation">
<div class="side_inner">

<!--  検索フォーム  -->
<?php get_template_part("search_form") ?>

<?php dynamic_sidebar(sidebar_0) ?>



<?php if(trim(strip_tags(wp_nav_menu(array('theme_location'=>'main_menu', 'echo'=>false)))) != ""){ ?>
<div class="box">
<h2>MENU</h2>
<nav>
<?php wp_nav_menu(array('theme_location' => 'main_menu')); ?>
</nav>
</div>
<?php } ?>

<?php dynamic_sidebar(sidebar_1) ?>

<?php get_template_part("profile") ?>

<?php dynamic_sidebar(sidebar_2) ?>

<div class="box">
<?php get_template_part("follow") ?>
</div>

<?php if(!is_singular()){ ?>
<h2>シェアする</h2>
<?php get_template_part("share") ?>
<?php } ?>
<div class="clear"></div>

<?php dynamic_sidebar(sidebar_3) ?>

</div><!-- .side_inner -->
</div><!-- .side -->
</div ><!-- .main_side -->


<?php if(get_option("prof_fb")){ ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&appId=<?php get_option("app_id") ?>&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php } ?>
