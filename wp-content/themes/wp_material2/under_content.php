<div class="under_content">

<!-- ページ送り -->
<?php get_template_part("page_links") ?>

<!-- 記事直下ウィジェット -->
<?php dynamic_sidebar("under_content") ?>

<!-- ダブルレクタングル -->
<?php get_template_part("ad_w_rectangle") ?>

<!-- シェアボタン -->
<h2 class="accent_header">この記事をシェアする</h2>
<?php get_template_part("share") ?>

<!-- コメント欄 -->
<?php comments_template(); ?>

<!-- 関連記事 -->
<?php get_template_part("kanren") ?>

<!-- 記事下プロフィール欄 -->
<?php get_template_part("profile_under_content") ?>

</div><!-- .under_content -->