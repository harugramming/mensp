<div class="footer accent_color">
<p><a href="https://wp-material2.net">WordPress Theme マテリアル2</a></p>
</div><!-- .footer -->

<button type="button" class="drawer-toggle drawer-hamburger sidebar_color">
	<span class="sr-only">toggle navigation</span>
	<span class="drawer-hamburger-icon"></span>
</button>

<?php if(is_set_to_top() || is_set_to_home()){ ?>
	<div class="move_buttons">
	<?php if(is_set_to_top()){ ?>
		<p class="lsf to_top sidebar_color">arrowup</p>
	<?php } ?>
	<?php if(is_set_to_home() && !is_front_page()){ ?>
		<a href="<?php echo home_url() ?>"><p class="lsf to_home sidebar_color">home</p></a>
	<?php } ?>
	<?php if(is_user_logged_in() && is_singular()){
		wp_reset_query(); ?>
		<a href="<?php echo get_edit_post_link() ?>"><p class="lsf to_edit sidebar_color">edit <span style="font-size:0.9em">編集</p></a>
	<?php } ?>
	</div>
<?php } ?>

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

<div class="drawer-overlay"></div>
<?php wp_footer() ?>
</body>
</html>