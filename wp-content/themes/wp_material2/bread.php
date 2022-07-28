<?php if(!is_front_page()){ ?>
	<?php $content_count = 1; ?>
	<div class="bread" vocab="https://schema.org/" typeof="BreadcrumbList">
		<span property="itemListElement" typeof="ListItem">
			<a href="<?php echo home_url(); ?>" property="item" typeof="WebPage"><i class="fas fa-home"></i><span property="name">Home</span></a>
			<meta property="position" content="<?php echo $content_count++ ?>">
		</span>
		<span> &raquo; </span>
		<?php if(is_search()){ ?>
			<span property="itemListElement" typeof="ListItem">
				<span property="name">「<?php the_search_query(); ?>」の検索結果</span>
				<meta property="position" content="<?php echo $content_count++ ?>">
			</span>	
		<?php }else if(is_404()){ ?>
			<span property="itemListElement" typeof="ListItem">
				<span property="name">404 NOT FOUND</span>
				<meta property="position" content="<?php echo $content_count++ ?>">
			</span>
		<?php }else if(is_tag()){ ?>
			<span property="itemListElement" typeof="ListItem">
				<span property="name"><i class="fas fa-tag"></i><?php single_tag_title(); ?></span>
				<meta property="position" content="<?php echo $content_count++ ?>">
			</span>
		<?php }else if(is_category()){ ?>
			<?php
			$parents = array();
			//現在表示しているページのカテゴリー情報を$tmpに格納
			$cat = get_queried_object();
			$tmp = $cat;
			//現在のページの親が無くなるまで処理を繰り返す	
			while( $tmp->parent ){
				//現在のページの親カテゴリーの情報を取得して$parentsの先頭に追加
				$tmp = get_category( $tmp->parent );
				array_unshift($parents , $tmp);
			}
			//パンくずの変数に格納されている情報の数だけ繰り返しカテゴリーページへのリンクとカテゴリー名を表示
			foreach( $parents as $parent ){ ?>
				<span property="itemListElement" typeof="ListItem">
					<a href="<?php echo get_category_link( $parent->term_id ); ?>" property="item" typeof="WebPage">
						<i class="fas fa-folder"></i><span property="name"><?php echo $parent->name; ?></span>
					</a>
					<meta property="position" content="<?php echo $content_count++ ?>">
				</span>
				<span> &raquo; </span>
			<?php } ?>
				<span property="itemListElement" typeof="ListItem">
					<span><i class="fas fa-folder"></i><span property="name"><?php echo $cat->name; ?></span></span>
					<meta property="position" content="<?php echo $content_count++ ?>">
				</span>
		<?php }else if(is_month()){ ?>
			<span property="itemListElement" typeof="ListItem">
				<span property="name"><?php echo get_query_var('year'); ?>年<?php echo get_query_var('monthnum'); ?>月</span>
				<meta property="position" content="<?php echo $content_count++ ?>">
			</span>
		<?php }else if(is_page()){ ?>
			<span property="itemListElement" typeof="ListItem">
				<span property="name"><?php the_title() ?></span>
				<meta property="position" content="<?php echo $content_count++ ?>">
			</span>
		<?php }else if(is_single()){ ?>
			<?php
			$postcat = get_the_category();
			if(count($postcat) > 0){
				$catid = $postcat[0]->cat_ID;
				$allcats = array($catid);
				while(!$catid==0) {
					$mycat = get_category($catid);
					$catid = $mycat->parent;
					array_push($allcats, $catid);
				}
				array_pop($allcats);
				$allcats = array_reverse($allcats);
				
				?>
				<?php foreach($allcats as $catid): ?>
					<span property="itemListElement" typeof="ListItem">
						<a href="<?php echo get_category_link($catid); ?>" property="item" typeof="WebPage">
							<i class="fas fa-folder"></i><span property="name"><?php echo get_cat_name($catid); ?></span>
						</a>
						<meta property="position" content="<?php echo $content_count++ ?>">
					</span>
					<span> &raquo; </span>
				<?php endforeach; ?>
			<?php } ?>
			<span property="itemListElement" typeof="ListItem">
				<span property="name"><?php the_title() ?></span>
				<meta property="position" content="<?php echo $content_count++ ?>">
			</span>
		<?php } ?>
	</div><!-- .bread -->
<?php } ?>