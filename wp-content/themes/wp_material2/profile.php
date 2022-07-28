<!-- プロフィール欄 -->
<?php if(get_option("is_prof")){ ?>
<div class="box">
<h2 class=""><?php echo get_option("prof_title") ?></h2>
<div class="image-text">
<?php if(get_option("prof_image")){ ?>
	<img class="prof-image" src="<?php echo get_option("prof_image") ?>" alt="<?php echo get_option("prof_name") ?>">
<?php } ?>
<p class="prof-name"><?php echo get_option("prof_name") ?></p>
<p class="prof-text">
	<?php echo nl2br(get_option("prof_text")) ?>
	<?php if(get_option("prof_url")){ ?><a style="text-decoration:underline; color:darkblue; display:inline-block" href="<?php echo get_option("prof_url") ?>">[詳細]</a><?php } ?></p>
</div><!-- .image-text -->

<?php if(get_option("prof_twitter")){ ?>
	<div class="twiiter-follow">
<?php if(get_option("twitter_account")){ ?>
	<a href="https://twitter.com/<?php echo get_option("twitter_account"); ?>" class="twitter-follow-button" data-show-count="true" data-lang="en" data-dnt="true">Follow @<?php echo get_option("twitter_account"); ?></a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

<?php }else{ ?>
	<p class="no_account_error">Twitterフォローボタンを表示するには、テーマカスタマイザーの<span class="b">SNS設定</span>→<span class="b">Twitterアカウント</span>を入力してください</p>
<?php } ?>
	</div><!-- .prof-twitter -->
<?php } ?>

<?php if(get_option("prof_g_plus")){ ?>
<?php if(get_option("google_plus_account")){ ?>
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/<?php echo get_option("google_plus_account") ?>" data-rel="publisher"></div>
<?php }else{ ?>
	<p class="no_account_error">Google+フォローボタンを表示するには、テーマカスタマイザーの<span class="b">SNS設定</span>→<span class="b">Google+ページのID</span>を入力してください</p>
<?php } ?>
<?php } ?>

<?php if(get_option("prof_fb")){
	if(get_option("facebook_url")){ ?>
		<div class="like-box">
		<div class="fb-page" data-href="<?php echo get_option("facebook_url") ?>" data-width="500px" data-hide-cover="false" data-show-facepile="true" data-show-posts="<?php if(get_option("prof_fb_timeline")){echo "true";}else{echo "false";} ?>"></div>
		</div>
	<?php }else{ ?>
		<p class="no_account_error">LikeBoxを表示するには、テーマカスタマイザーの<span class="b">SNS設定</span>→<span class="b">FacebookページURL</span>を入力してください</p>
	<?php } ?>
<?php } ?>

</div><!-- .prof-box -->
<style>.no_account_error{font-size:0.7em; margin-bottom:10px;}</style>
<?php } ?>