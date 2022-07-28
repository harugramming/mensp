<!--  フォローボタン  -->
<?php if(is_twitter_follow()||is_fb_follow()||is_g_follow()||is_feedly_follow()||is_line_follow()){
	$twitter_account = get_option('twitter_account'); 
	$facebook_url = get_option('facebook_url');
	$g = get_option('google_plus_account');
	$line_id = strtolower(get_option('line_id')); 
?>
<div class="follow-box">
<h2>フォローする</h2>

<div class="follow_buttons">
<?php if(is_twitter_follow()){ ?>
	<?php if($twitter_account){ ?>
		<a href="https://twitter.com/<?php echo $twitter_account ?>" rel="nofollow" target="_blank">
	<?php } ?>
	<p class="lsf follow-icon twitter<?php if(!$twitter_account){ echo " not";} ?>">twitter</p>
	<?php if($twitter_account){ ?>
		</a>
	<?php } ?>
<?php } ?>

<?php if(is_fb_follow()){ ?>
	<?php if($facebook_url){ ?>
		<a href="<?php echo $facebook_url ?>" rel="nofollow" target="_blank">
	<?php } ?>
	<p class="lsf follow-icon fb<?php if(!$facebook_url){ echo " not";} ?>">facebook</p>
	<?php if($facebook_url){ ?>
		</a>
	<?php } ?>
<?php } ?>

<?php if(is_g_follow()){ ?>
	<?php if($g){ ?>
		<a href="https://plus.google.com/u/0/<?php echo $g?>" rel="nofollow" target="_blank">
	<?php } ?>
	<p class="lsf follow-icon g-plus<?php if(!$g){ echo " not";} ?>">google</p>
	<?php if($g){ ?>
		</a>
	<?php } ?>
<?php } ?>

<?php if(is_feedly_follow()){ ?>
<a href="https://feedly.com/i/subscription/feed/<?php bloginfo('rss2_url'); ?>" rel="nofollow" target="_blank">
<p class="lsf follow-icon feedly">feed</p>
</a>
<?php } ?>

<?php if(is_line_follow()){ ?>
	<?php if($line_id){ ?>
		<a href="https://line.me/ti/p/%40<?php echo $line_id; ?>" rel="nofollow" target="_blank">
	<?php } ?>
	<p class="lsf follow-icon line<?php if(!$line_id){ echo " not";} ?>">line</p>
	<?php if($line_id){ ?>
		</a>
	<?php } ?>
<?php } ?>

<div class="clear"></div>
</div>
</div><!-- .follow_buttons -->
<?php } ?>