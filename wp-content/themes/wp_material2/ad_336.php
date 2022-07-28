<?php 
if(is_singular()){
	$is_no_adsense = get_post_meta(get_the_ID(),'is_no_adsense',true);
}
if(!$is_no_adsense && !is_404()){
  if(!wp_is_mobile()){
    if(get_option("ad_336")){ ?>
      <div class="ad ad_336">
        <p>スポンサーリンク</p>
        <?php echo get_option("ad_336"); ?>
      </div>
    <?php }
  }else{
    if(get_option("ad_responsive")){ ?>
      <div class="ad">
        <p>スポンサーリンク</p>
        <?php echo get_option("ad_responsive"); ?>
      </div>
    <?php }	
  }
} ?>