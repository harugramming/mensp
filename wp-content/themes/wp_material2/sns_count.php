<div class="sns_counts">
<?php if(function_exists('get_scc_twitter')){ ?>
	<p class="sns_count"><span class="lsf twitter l">twitter </span><?php echo get_scc_twitter() ?></p>
<?php } ?>

<?php if(function_exists('get_scc_facebook')){ ?>
	<p class="sns_count"><span class="lsf fb l">facebook </span><?php echo get_scc_facebook(); ?></p>
<?php } ?>

<?php if(function_exists('get_scc_hatebu')){ ?>
	<p class="sns_count"><span class="lsf hatebu l">hatenabookmark </span><?php echo get_scc_hatebu(); ?></p>
<?php } ?>
</div>