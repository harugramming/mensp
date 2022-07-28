<?php error_reporting(0);
/****  script css読み込み  ****/
function load_script_css(){
	wp_enqueue_script( "main_script", get_template_directory_uri()."/script.js", array("jquery"), "", false);
	wp_enqueue_script( "iscroll", "https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js", array("jquery"), "", false);
	wp_enqueue_script( "drawer", "https://cdnjs.cloudflare.com/ajax/libs/drawer/3.1.0/js/drawer.min.js", array("jquery"), "", false);

	wp_enqueue_style( "style", get_stylesheet_uri(), false);
	wp_enqueue_style( "drawer_css", get_template_directory_uri()."/drawer_custom.css", array("style") );
}
add_action('wp_enqueue_scripts', 'load_script_css');


/**** ウィジェット ****/
if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => 'サイドバー（最上部）',
		'id' => 'sidebar_0',
		'before_widget' => "<div class='box'>",
		'after_widget' => "</div>",
		'before_title' => "<h2>",
		'after_title' => "</h2>"
	));
	register_sidebar(array(
		'name' => 'サイドバー（メインメニュー直下）',
		'id' => 'sidebar_1',
		'before_widget' => "<div class='box'>",
		'after_widget' => "</div>",
		'before_title' => "<h2>",
		'after_title' => "</h2>"
	));
	register_sidebar(array(
		'name' => 'サイドバー（プロフィール欄直下）',
		'id' => 'sidebar_2',
		'before_widget' => "<div class='box'>",
		'after_widget' => "</div>",
		'before_title' => "<h2>",
		'after_title' => "</h2>"
	));
	register_sidebar(array(
		'name' => 'サイドバー（最下部）',
		'id' => 'sidebar_3',
		'before_widget' => "<div class='box'>",
		'after_widget' => "</div>",
		'before_title' => "<h2>",
		'after_title' => "</h2>"
	));
	register_sidebar(array(
		'name' => '記事直下',
		'id' => 'under_content',
		'before_widget' => "<div class='box'>",
		'after_widget' => "</div>",
		'before_title' => "<h2 class='accent_header'>",
		'after_title' => "</h2>"
	));
	register_sidebar(array(
		'name' => 'フッターエリア',
		'id' => 'footer_area',
		'before_widget' => "<div class='footer_widget'>",
		'after_widget' => "</div>",
		'before_title' => "<h2><span class='lsf'>dropdown </span>",
		'after_title' => "</h2>"
	));
}


/****  ページタイトルを取得  ****/
if(!function_exists("get_the_page_title")){
	function get_the_page_title(){
		return wp_title('|', false, 'right').get_bloginfo('name');
	}
}

/****  descriptionを取得  ****/
if(!function_exists("get_the_description")){
	function get_the_description(){
		$description = "";
		if(is_front_page()){
			$description = get_bloginfo('description');
		}else if(is_singular()){
			if(have_posts()){
				global $post;
				if(is_attachment()){
					$description = get_the_title();
				}else{
					$description = $post -> post_excerpt;
					if($description===""){
						$description = mb_substr(str_replace("\"", "'", strip_tags($post-> post_content)),0,100).'...';
					}
				}
			}
		}else if(is_category()){
			$description = category_description();
		}else if(is_tag()){
			$description = get_bloginfo("name")."の".single_cat_title("", false)."に関する記事一覧";
		}else if(is_date()){
			$description = get_bloginfo("name")."の".year_month().day()."に書かれた記事一覧";
		}else{
			$description = get_bloginfo("name");
		}
		return $description;
	}
}

/****  イメージurl取得  ****/
if(!function_exists("get_image_url")){
	function get_image_url(){
		$image_url = "";
		if(is_singular()){
			$image_id = get_post_thumbnail_id();
			$image_array = wp_get_attachment_image_src($image_id, true);
			if($image_array[0]!=""){
				$image_url = $image_array[0];
			}
		}
		if(!$image_url){
			if(get_option("logo_setting")){$image_url = get_option("logo_setting");}
		}
		if(!$image_url){
			if(get_header_image()){$image_url = get_header_image();}
		}
		if(!$image_url){
			if(get_option("prof_image")){$image_url = get_option("prof_image");}
		}
		if(!$image_url){
			$image_url = get_template_directory_uri()."/images/no_image.png";
		}
		return $image_url;
	}
}

if(!function_exists("get_site_image_url")){
	function get_site_image_url(){
		$image_url = "";
		if(!$image_url){
			if(get_option("logo_setting")){$image_url = get_option("logo_setting");}
		}
		if(!$image_url){
			if(get_header_image()){$image_url = get_header_image();}
		}
		if(!$image_url){
			if(get_option("prof_image")){$image_url = get_option("prof_image");}
		}
		if(!$image_url){
			$image_url = get_template_directory_uri()."/images/no_image.png";
		}
		return $image_url;
	}
}

/****  ビジュアルエディター有効化  ****/
add_editor_style();

/****  MENU有効化  ****/
register_nav_menus( array(
	"main_menu" => "メインメニュー（サイドバー最上部）"
) );


/****  サムネイル  ****/
add_theme_support('post-thumbnails');

/****  カスタムヘッダー  ****/
$defaults = array(
	'header-text' => false
);
add_theme_support( 'custom-header', $defaults );

/****  カスタム背景  ****/
$args = array(
	'default-color' => '#ffffff'
);
add_theme_support( 'custom-background', $args );

/****  フィードリンク  ****/
add_theme_support( 'automatic-feed-links' );

/****  アドセンス表示設定  ****/
add_action('admin_menu', 'add_custom_box');
function add_custom_box(){
	add_meta_box( 'ad_view_setting_in_post','アドセンス表示設定', 'view_custom_box', 'post', 'side' );
	add_meta_box( 'ad_view_setting_in_page','アドセンス表示設定', 'view_custom_box', 'page', 'side' );
}
function view_custom_box(){
	global $post;

	$is_checked = get_post_meta(get_the_ID(),'is_no_adsense',true);

	echo '<label><input type="checkbox" name="is_no_adsense"';
	if($is_checked){echo " checked";}
	echo '>アドセンスを非表示にする</label>';

}
add_action('save_post', 'save_custom_data');
function save_custom_data(){
	$is_no_adsense = $_POST["is_no_adsense"];
	$id = get_the_ID();
	$meta_key = "is_no_adsense";

	add_post_meta($id, $meta_key, $is_no_adsense, true);
	update_post_meta($id, $meta_key, $is_no_adsense);
}


/****  記事中にアドセンス表示  ****/
function add_ads_before_1st_h2($the_content) {
	$is_no_adsense = get_post_meta(get_the_ID(),'is_no_adsense',true);
	if (is_singular() && !$is_no_adsense) {
		$h2 = "/<h2.*?>/i";
		if (preg_match($h2, $the_content, $h2s)) {
			if(get_option("ad_responsive")){
				$ad_responsive = "<div class='ad' style='margin-bottom:30px'><p>スポンサーリンク</p>".get_option("ad_responsive")."</div>";
				if(is_ad_second_h2() && wp_is_mobile()){
					$the_content = preg_replace($h2, $ad_responsive.$h2s[0], $the_content, 2);
				}else{
					$the_content = preg_replace($h2, $ad_responsive.$h2s[0], $the_content, 1);
				}
			}
		}

	}
	return $the_content;
}
add_filter('the_content','add_ads_before_1st_h2');


/**** コメント表示 ****/
function mydesign($comment, $args, $depth){
$GLOBALS['comment'] = $comment;
?>
<li class="compost" id="comment-<?php comment_ID() ?>">
	<div class="combody">
		<?php comment_text(); ?>
	</div><!-- .combody -->
	<p class="cominfo">
		by <?php comment_author_link(); ?>　<?php comment_date(); ?>  <?php comment_time(); ?>
	</p>
</li>
<?php
}


/****  ページネーション  ****/
function pagination($pages = '', $range = 2){
     $showitems = ($range * 2)+1;
     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == ''){
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages){
             $pages = 1;
         }
     }

     if(1 != $pages){
         echo "<div class='pagenavi'>";

         if($paged > 2 && $paged > $range+1 && $showitems < $pages){
         	echo "<a href='".get_pagenum_link(1)."'>1</a>";
         }

         for ($i=1; $i <= $pages; $i++){
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages-2 &&  $paged+$range-2 < $pages && $showitems < $pages){
         	echo "<a href='".get_pagenum_link($pages)."'>".$pages."</a>";
         }

         echo "</div>";
     }
}


/****  category_description()の<p>を削除  ****/
remove_filter('term_description', 'wpautop');


/****  月と年を入れ替える  ****/
function year_month(){
	$date = single_month_title('',false);
	$point = strpos($date,'月');
	return mb_substr($date,$point+1).'年'.mb_substr($date,0,$point+1);
}


/****  日を出力  ****/
function day(){
	if(is_date() && !is_month()){
		$date = preg_split("/ /", wp_title('|', false, 'right'));
		$date = $date[0];
		return $date."日";
	}
}


/****  かんたんSSL化設定  ****/
function http_to_https($the_content){
	if(is_ssl_inner_http()){
		$domain = $_SERVER["HTTP_HOST"];

		$src_http_single = "src=\'http://".$domain;
		$src_http_double = "src=\"http://".$domain;
		$src_https_single = "src=\'https://".$domain;
		$src_https_double = "src=\"https://".$domain;

		$href_http_single = "href=\'http://".$domain;
		$href_http_double = "href=\"http://".$domain;
		$href_https_single = "href=\'https://".$domain;
		$href_https_double = "href=\"https://".$domain;

		$http = array($src_http_single, $src_http_double, $href_http_single, $href_http_double);
		$https = array($src_https_single, $src_https_double, $href_https_single, $href_https_double);
		$the_content = str_replace($http, $https, $the_content);
	}
	return $the_content;
}
add_filter('the_content', 'http_to_https');


/**** テーマカスタマイザー設定 ****/
define("ACCENT_COLOR_DEFAULT", "#414852");
define("HEADER_COLOR_DEFAULT", "#5f9d64");
define("HEADER_TEXT_COLOR_DEFAULT", "#ffffff");
define("SIDE_COLOR_DEFAULT", "#ededed");
define("SIDE_TEXT_COLOR_DEFAULT", "#333333");
define("LINK_HOVER_COLOR_DEFAULT", "#dd9933");

add_action( 'customize_register', 'my_customize_register' );
function my_customize_register($wp_customize) {

/*テキストエリア入力欄*/
if(class_exists('WP_Customize_Control')){
	class WP_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public function render_content() { ?>
<label>
<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
</label>

<?php		}
	}
}

/*ラジオボタン*/
function sanitize_choices( $input, $setting ) {
	global $wp_customize;
	$control = $wp_customize->get_control( $setting->id );
	if ( array_key_exists( $input, $control->choices ) ) {
		return $input;
	} else {
		return $setting->default;
	}
}

/*サイト基本情報*/
	/* 開始年（footer表示用） */
	$wp_customize->add_setting(
			'start_year',
			array(
				'type' => 'option'
			)
	);
	$wp_customize->add_control(
			'start_year',
			array(
				'section' => 'title_tagline',
				'settings' => 'start_year',
				'label' => 'サイト開始年（フッター表示用）',
				'type' => 'text'
			)
	);

	/* キャッチフレーズ表示 */
	$wp_customize->add_setting(
			'is_desc',
			array(
				'default' => 'checked'
			)
	);
	$wp_customize->add_control(
			'is_desc',
			array(
				'section' => 'title_tagline',
				'settings' => 'is_desc',
				'label' => 'ブログタイトル下にキャッチフレーズを表示する',
				'type' => 'checkbox'
			)
	);

/* 色 */
	/*ヘッダー背景色*/
	$wp_customize->add_setting(
			'header_color',
			array(
				'default' => HEADER_COLOR_DEFAULT
			)
	);
	$wp_customize->add_control(
			new WP_Customize_Color_Control(
    				$wp_customize,
				'header_color',
				array(
					'section' => 'colors',
					'settings' => 'header_color',
					'label' =>'ヘッダー背景色'
				)
			)
	);

	/*ヘッダー文字色*/
	$wp_customize->add_setting(
			'title_color',
			array(
				'default' => HEADER_TEXT_COLOR_DEFAULT
			)
	);
	$wp_customize->add_control(
			new WP_Customize_Color_Control(
    				$wp_customize,
				'title_color',
				array(
					'section' => 'colors',
					'settings' => 'title_color',
					'label' =>'ブログタイトル及びキャッチフレーズの文字色'
				)
			)
	);

	/*サイドバー背景色*/
	$wp_customize->add_setting(
			'side_color',
			array(
				'default' => SIDE_COLOR_DEFAULT
			)
	);
	$wp_customize->add_control(
			new WP_Customize_Color_Control(
    				$wp_customize,
				'side_color',
				array(
					'section' => 'colors',
					'settings' => 'side_color',
					'label' =>'サイドバー背景色'
				)
			)
	);

	/*サイドバー文字色*/
	$wp_customize->add_setting(
			'side_text_color',
			array(
				'default' => SIDE_TEXT_COLOR_DEFAULT
			)
	);
	$wp_customize->add_control(
			new WP_Customize_Color_Control(
    				$wp_customize,
				'side_text_color',
				array(
					'section' => 'colors',
					'settings' => 'side_text_color',
					'label' =>'サイドバー上のテキストの文字色'
				)
			)
	);

	/*アクセントカラー*/
	$wp_customize->add_setting(
			'accent_color',
			array(
				'default' => ACCENT_COLOR_DEFAULT
			)
	);
	$wp_customize->add_control(
			new WP_Customize_Color_Control(
    				$wp_customize,
				'accent_color',
				array(
					'section' => 'colors',
					'settings' => 'accent_color',
					'label' =>'アクセントカラー'
				)
			)
	);

	/*リンクhoverカラー*/
	$wp_customize->add_setting(
			'link_hover_color',
			array(
				'default' => LINK_HOVER_COLOR_DEFAULT
			)
	);
	$wp_customize->add_control(
			new WP_Customize_Color_Control(
    				$wp_customize,
				'link_hover_color',
				array(
					'section' => 'colors',
					'settings' => 'link_hover_color',
					'label' =>'リンクhoverカラー'
				)
			)
	);

/*indexスタイル設定*/
$wp_customize->add_section(
	'index_setting',
	array(
		'title' => 'Indexスタイル設定',
		'priority' => 99
	)
);
	/*アイキャッチ非表示*/
		$wp_customize->add_setting(
			'no_thumbnail',
			array(
				'default' => ''
			)
		);
		$wp_customize->add_control(
			'no_thumbnail',
			array(
				'section' => 'index_setting',
				'settings' => 'no_thumbnail',
				'label' => 'indexページのアイキャッチを非表示にする',
				'type' => 'checkbox'
			)
		);

	/*スタイル選択*/
	$wp_customize->add_setting(
		'style_select',
		array(
			'default' => 'type1',
			'sanitize_callback' => 'sanitize_choices'
		)
	);
	$wp_customize->add_control(
		'style_select',
		array(
			'section' => 'index_setting',
			'settings' => 'style_select',
			'label' => 'Indexページのスタイルを選択する',
			'type' => 'radio',
			'choices' => array(
				'type1' => 'リスト型',
				'type2' => 'カード型'
			)
		)
	);


/*SNSアカウント設定*/
$wp_customize->add_section(
		'sns_setting',
		array(
			'title' => 'SNSアカウント設定',
			'priority' => 100
		)
);

	/*Twitterフォローボタン設置*/
	$wp_customize->add_setting(
			'is_twitter_follow',
			array(
				'default' => 'checked'
			)
	);
	$wp_customize->add_control(
			'is_twitter_follow',
			array(
				'section' => 'sns_setting',
				'settings' => 'is_twitter_follow',
				'label' => 'Twitterフォローボタンを設置する',
				'type' => 'checkbox'
			)
	);

	/*Facebookフォローボタン設置*/
	$wp_customize->add_setting(
			'is_fb_follow',
			array(
				'default' => 'checked'
			)
	);
	$wp_customize->add_control(
			'is_fb_follow',
			array(
				'section' => 'sns_setting',
				'settings' => 'is_fb_follow',
				'label' => 'Facebookフォローボタンを設置する',
				'type' => 'checkbox'
			)
	);

	/*Google+フォローボタン設置*/
	$wp_customize->add_setting(
			'is_g_follow',
			array(
				'default' => 'checked'
			)
	);
	$wp_customize->add_control(
			'is_g_follow',
			array(
				'section' => 'sns_setting',
				'settings' => 'is_g_follow',
				'label' => 'Google+フォローボタンを設置する',
				'type' => 'checkbox'
			)
	);

	/*feedlyフォローボタン設置*/
	$wp_customize->add_setting(
			'is_feedly_follow',
			array(
				'default' => 'checked'
			)
	);
	$wp_customize->add_control(
			'is_feedly_follow',
			array(
				'section' => 'sns_setting',
				'settings' => 'is_feedly_follow',
				'label' => 'feedlyのフォローボタンを設置する',
				'type' => 'checkbox'
			)
	);

	/*Line@フォローボタン設置*/
	$wp_customize->add_setting(
			'is_line_follow',
			array(
				'default' => 'checked'
			)
	);
	$wp_customize->add_control(
			'is_line_follow',
			array(
				'section' => 'sns_setting',
				'settings' => 'is_line_follow',
				'label' => 'Line@のフォローボタンを設置する',
				'type' => 'checkbox'
			)
	);

	/*Twiiterアカウント登録*/
	$wp_customize->add_setting(
			'twitter_account',
			array(
				'type' => 'option',
			)
	);
	$wp_customize->add_control(
			'twitter_account',
			array(
				'section' => 'sns_setting',
				'settings' => 'twitter_account',
				'label' => 'Twiiterアカウント（@は不要）',
				'type' => 'text'
			)
	);

	/*@メンションを含める*/
	$wp_customize->add_setting(
			'mention',
			array(
				'type' => 'option',
			)
	);
	$wp_customize->add_control(
			'mention',
			array(
				'section' => 'sns_setting',
				'settings' => 'mention',
				'label' => 'Tweetにメンションを含める',
				'type' => 'checkbox'
			)
	);

	/*Facebookページ登録*/
	$wp_customize->add_setting(
			'facebook_url',
			array(
				'type' => 'option',
			)
	);
	$wp_customize->add_control(
			'facebook_url',
			array(
				'section' => 'sns_setting',
				'settings' => 'facebook_url',
				'label' => 'FacebookページURL',
				'type' => 'text'
			)
	);

	/*appID登録*/
	$wp_customize->add_setting(
			'app_id',
			array(
				'type' => 'option',
			)
	);
	$wp_customize->add_control(
			'app_id',
			array(
				'section' => 'sns_setting',
				'settings' => 'app_id',
				'label' => 'App ID',
				'type' => 'text'
			)
	);

	/*Google+ページ登録*/
	$wp_customize->add_setting(
			'google_plus_account',
			array(
				'type' => 'option',
			)
	);
	$wp_customize->add_control(
			'google_plus_account',
			array(
				'section' => 'sns_setting',
				'settings' => 'google_plus_account',
				'label' => 'google+ページのID',
				'type' => 'text',
				'description' => 'google+のIDとは、google+のプロフィールページのURLに含まれる20桁ほどの数字の羅列です'
			)
	);

	/*Line@アカウント登録*/
	$wp_customize->add_setting(
			'line_id',
			array(
				'type' => 'option',
			)
	);
	$wp_customize->add_control(
			'line_id',
			array(
				'section' => 'sns_setting',
				'settings' => 'line_id',
				'label' => 'Line@ID　（@は不要）',
				'type' => 'text'
			)
	);


/*プロフィール欄*/
$wp_customize->add_section(
	'profile_setting',
	array(
		'title' => 'プロフィール欄設定',
		'priority' => 101
	)
);

	/*サイドバーにプロフィール設置？*/
	$wp_customize->add_setting(
			'is_prof',
			array(
				'type' => 'option'
			)
	);
	$wp_customize->add_control(
			'is_prof',
			array(
				'section' => 'profile_setting',
				'settings' => 'is_prof',
				'label' => 'サイドバーにプロフィール欄を設置する',
				'type' => 'checkbox'
			)
	);

	/*記事下にプロフィール設置？*/
	$wp_customize->add_setting(
			'is_prof_under_content',
			array(
				'type' => 'option'
			)
	);
	$wp_customize->add_control(
			'is_prof_under_content',
			array(
				'section' => 'profile_setting',
				'settings' => 'is_prof_under_content',
				'label' => '記事下にプロフィール欄を設置する',
				'type' => 'checkbox'
			)
	);

	/*プロフィール欄タイトル*/
	$wp_customize->add_setting(
			'prof_title',
			array(
				'type' => 'option',
			)
	);
	$wp_customize->add_control(
			'prof_title',
			array(
				'section' => 'profile_setting',
				'settings' => 'prof_title',
				'label' => 'プロフィール欄のタイトル',
				'type' => 'text'
			)
	);

	/*名前*/
	$wp_customize->add_setting(
			'prof_name',
			array(
				'type' => 'option',
			)
	);
	$wp_customize->add_control(
			'prof_name',
			array(
				'section' => 'profile_setting',
				'settings' => 'prof_name',
				'label' => '名前',
				'type' => 'text'
			)
	);

	/*自画像*/
	$wp_customize->add_setting(
			'prof_image',
			array(
				'type' => 'option'
			)
	);
	$wp_customize->add_control( new WP_Customize_Image_Control(
        		$wp_customize,
        		'prof_image',
        		array(
				'section'   => 'profile_setting',
				'settings'  => 'prof_image',
				'label'     => 'アイコン'
			)
	));

	/*自己紹介*/
	$wp_customize->add_setting(
			'prof_text',
			array(
				'type' => 'option',
			)
	);
	if(class_exists('WP_Customize_Textarea_Control')){
		$wp_customize->add_control(new WP_Customize_Textarea_Control(
			$wp_customize,
			'prof_text',
			array(
				'section' => 'profile_setting',
				'settings' => 'prof_text',
				'label' => '簡単な自己紹介文'
			)
		));
	}

	/*リンク*/
	$wp_customize->add_setting(
			'prof_url',
			array(
				'type' => 'option',
			)
	);
	$wp_customize->add_control(
			'prof_url',
			array(
				'section' => 'profile_setting',
				'settings' => 'prof_url',
				'label' => 'プロフィールページのurl',
				'type' => 'text',
				'description' => 'プロフィールページがあれば、そのURLを入力してください'
			)
	);

	/*Twitter フォローボタン設置*/
	$wp_customize->add_setting(
			'prof_twitter',
			array(
				'type' => 'option'
			)
	);
	$wp_customize->add_control(
			'prof_twitter',
			array(
				'section' => 'profile_setting',
				'settings' => 'prof_twitter',
				'label' => 'プロフィール欄にTwitterフォローボタンを設置する',
				'type' => 'checkbox'
			)
	);

	/*Google+フォローボタン設置*/
	$wp_customize->add_setting(
			'prof_g_plus',
			array(
				'type' => 'option'
			)
	);
	$wp_customize->add_control(
			'prof_g_plus',
			array(
				'section' => 'profile_setting',
				'settings' => 'prof_g_plus',
				'label' => 'プロフィール欄にGoogle+フォローボタンを設置する',
				'type' => 'checkbox'
			)
	);

	/*Facebookページ設置*/
	$wp_customize->add_setting(
			'prof_fb',
			array(
				'type' => 'option'
			)
	);
	$wp_customize->add_control(
			'prof_fb',
			array(
				'section' => 'profile_setting',
				'settings' => 'prof_fb',
				'label' => 'プロフィール欄にFacebook LikeBox（Page Plugin）を設置する',
				'type' => 'checkbox'
			)
	);

	/*Facebookページ タイムライン*/
	$wp_customize->add_setting(
			'prof_fb_timeline',
			array(
				'type' => 'option'
			)
	);
	$wp_customize->add_control(
			'prof_fb_timeline',
			array(
				'section' => 'profile_setting',
				'settings' => 'prof_fb_timeline',
				'label' => 'Facebook LikeBoxにタイムラインを表示する',
				'type' => 'checkbox'
			)
	);

	/*Google+フォローボタン*/
	$wp_customize->add_setting(
			'prof_g_plus',
			array(
				'type' => 'option'
			)
	);
	$wp_customize->add_control(
			'prof_g_plus',
			array(
				'section' => 'profile_setting',
				'settings' => 'prof_g_plus',
				'label' => 'プロフィール欄にGoogle+フォローボタンを設置する',
				'type' => 'checkbox'
			)
	);


/*ロゴ・ファビコン・apple登録*/
$wp_customize->add_section(
	'image_setting', array(
		'title' => 'ロゴ、ファビコン設定',
		'priority' => 102
	)
);

	/*ロゴ登録*/
	$wp_customize->add_setting(
			'logo_setting',
			array(
				'type' => 'option'
			)
	);
	$wp_customize->add_control( new WP_Customize_Image_Control(
        		$wp_customize,
        		'logo_setting',
        		array(
				'section'   => 'image_setting',
				'settings'  => 'logo_setting',
				'label'     => 'ロゴ画像',
				'description' => 'サイトには表示されませんがSNSで拡散される際にアイキャッチとして使用されます'
			)
	));

	/*favicon*/
	$wp_customize->add_setting(
			'favicon_setting',
			array(
				'type' => 'option'
			)
	);
	$wp_customize->add_control( new WP_Customize_Image_Control(
        		$wp_customize,
        		'favicon_setting',
        		array(
				'section'   => 'image_setting',
				'settings'  => 'favicon_setting',
				'label'     => 'ファビコン（.ico）'
			)
	));

	/*apple　touchアイコン*/
	$wp_customize->add_setting(
			'apple_setting',
			array(
				'type' => 'option'
			)
	);
	$wp_customize->add_control( new WP_Customize_Image_Control(
        		$wp_customize,
        		'apple_setting',
        		array(
				'section'   => 'image_setting',
				'settings'  => 'apple_setting',
				'label'     => 'アップルタッチアイコン（.png）'
			)
	));


/*記事数の設定*/
$wp_customize->add_section(
	'post_count',array(
		'title' => '表示記事数の設定',
		'priority' => 103
	)
);

	/*カテゴリーごとに表示する記事数*/
	$wp_customize->add_setting(
			'count_cat_post',
			array(
				'default' => '3'
			)
	);
	$wp_customize->add_control(
			'count_cat_post',
			array(
				'section' => 'post_count',
				'settings' => 'count_cat_post',
				'label' => 'カテゴリーリストに表示する記事数',
				'type' => 'select',
				'choices' => array(
					1 => '1件',
					2 => '2件',
					3 => '3件',
					4 => '4件',
					5 => '5件',
					6 => '6件',
					7 => '7件',
					8 => '8件',
					9 => '9件'
				)
			)
	);

	/*関連記事の記事数*/
	$wp_customize->add_setting(
			'count_kanren',
			array(
				'default' => '6'
			)
	);
	$wp_customize->add_control(
			'count_kanren',
			array(
				'section' => 'post_count',
				'settings' => 'count_kanren',
				'label' => '関連記事として表示される記事数',
				'type' => 'select',
				'choices' => array(
					0 => '表示しない',
					3 => '3件',
					4 => '4件',
					5 => '5件',
					6 => '6件',
					7 => '7件',
					8 => '8件',
					9 => '9件',
					10 => '10件'
				)
			)
	);


/*記事タイトル下の設定*/
$wp_customize->add_section(
	'top_of_content_setting',
	array(
		'title' => '記事タイトル下の設定',
		'priority' => 104
	)
);
	/*更新日*/
	$wp_customize->add_setting(
			'is_show_rewrite_date',
			array(
				'default' => 'checked'
			)
	);
	$wp_customize->add_control(
			'is_show_rewrite_date',
			array(
				'section' => 'top_of_content_setting',
				'settings' => 'is_show_rewrite_date',
				'label' => '記事の更新日を表示する',
				'type' => 'checkbox'
			)
	);
	/*記事上部のアイキャッチ*/
	$wp_customize->add_setting(
			'is_eyecatch',
			array(
				'default' => 'checked'
			)
	);
	$wp_customize->add_control(
			'is_eyecatch',
			array(
				'section' => 'top_of_content_setting',
				'settings' => 'is_eyecatch',
				'label' => '記事タイトル下にアイキャッチ画像を表示する',
				'type' => 'checkbox'
			)
	);

	/*記事タイトル下にシェアボタン設置*/
	$wp_customize->add_setting(
		'is_share_top_of_content',
		array('default' => 'checked')
	);
	$wp_customize->add_control(
		'is_share_top_of_content',
			array(
				'section' => 'top_of_content_setting',
				'settings' => 'is_share_top_of_content',
				'label' => '記事タイトルの下にシェアボタンを設置する',
				'type' => 'checkbox'
			)
	);


/*UI設定*/
$wp_customize->add_section(
	'ui_setting', array(
		'title' => 'UI設定',
		'priority' => 105
	)
);
	/*Topへ戻るボタン*/
	$wp_customize->add_setting(
			'is_set_to_top',
			array(
				'default' => 'checked'
			)
	);
	$wp_customize->add_control(
			'is_set_to_top',
			array(
				'section' => 'ui_setting',
				'settings' => 'is_set_to_top',
				'label' => 'Topへ戻る（スクロール）ボタンを表示する',
				'type' => 'checkbox'
			)
	);


	/*Homeボタン*/
	$wp_customize->add_setting(
			'is_set_to_home_',
			array(
				'default' => 'checked'
			)
	);
	$wp_customize->add_control(
			'is_set_to_home_',
			array(
				'section' => 'ui_setting',
				'settings' => 'is_set_to_home_',
				'label' => 'Homeへ戻る（リンク）ボタンを表示する',
				'type' => 'checkbox'
			)
	);


/*AdSense設定*/
$wp_customize->add_section(
	'ad_setting', array(
		'title' => 'アドセンス設定',
		'priority' => 106
	)
);

	/*indexページ最上部の広告*/
	$wp_customize->add_setting(
			'ad_top_of_index',
			array(
				'default' => 'checked'
			)
	);
	$wp_customize->add_control(
			'ad_top_of_index',
			array(
				'section' => 'ad_setting',
				'settings' => 'ad_top_of_index',
				'label' => 'indexページの最上部に広告を表示する',
				'type' => 'checkbox'
			)
	);

	/*スマホ用2個目のh2タグ前の広告*/
	$wp_customize->add_setting(
			'ad_second_h2',
			array(
				'default' => 'checked'
			)
	);
	$wp_customize->add_control(
			'is_set_to_home',
			array(
				'section' => 'ad_setting',
				'settings' => 'ad_second_h2',
				'label' => '記事ページの2つ目のh2タグ直上に広告を表示する（スマホ限定）',
				'type' => 'checkbox'
			)
	);

	/*ビッグバナー728*/
	$wp_customize->add_setting(
			'ad_728',
			array(
				'type' => 'option',
			)
	);
	if(class_exists('WP_Customize_Textarea_Control')){
		$wp_customize->add_control(new WP_Customize_Textarea_Control(
			$wp_customize,
			'ad_728',
			array(
				'section' => 'ad_setting',
				'settings' => 'ad_728',
				'label' => 'ビッグバナー(728×90)'
			)
		));
	}

	/*レクタングル大*/
	$wp_customize->add_setting(
			'ad_336',
			array(
				'type' => 'option',
			)
	);
	if(class_exists('WP_Customize_Textarea_Control')){
		$wp_customize->add_control(new WP_Customize_Textarea_Control(
			$wp_customize,
			'ad_336',
			array(
				'section' => 'ad_setting',
				'settings' => 'ad_336',
				'label' => 'レクタングル大(336×280)'
			)
		));
	}

	/*レスポンシブ*/
	$wp_customize->add_setting(
			'ad_responsive',
			array(
				'type' => 'option',
			)
	);
	if(class_exists('WP_Customize_Textarea_Control')){
		$wp_customize->add_control(new WP_Customize_Textarea_Control(
			$wp_customize,
			'ad_responsive',
			array(
				'section' => 'ad_setting',
				'settings' => 'ad_responsive',
				'label' => 'レスポンシブ'
			)
		));
	}


/*analytics*/
$wp_customize->add_section(
	'analy_setting', array(
		'title' => 'アナリィティクス設定',
		'priority' => 107
	)
);

	/*アナリィティクスのコード*/
	$wp_customize->add_setting(
			'analy_code',
			array(
				'type' => 'option',
			)
	);
	if(class_exists('WP_Customize_Textarea_Control')){
		$wp_customize->add_control(new WP_Customize_Textarea_Control(
			$wp_customize,
			'analy_code',
			array(
				'section' => 'analy_setting',
				'settings' => 'analy_code',
				'label' => 'アナリィティクスのコード'
			)
		));
	}

	/*ログイン時除外*/
	$wp_customize->add_setting(
			'reject_logged_in',
			array(
				'type' => 'option'
			)
	);
	$wp_customize->add_control(
			'reject_logged_in',
			array(
				'section' => 'analy_setting',
				'settings' => 'reject_logged_in',
				'label' => 'ログイン中のアクセスをカウントしない',
				'type' => 'checkbox'
			)
	);

//かんたんSSl化設定
$wp_customize->add_section(
	'ssl_setting',
	array(
		'title' => 'かんたんSSL化設定',
		'description' => 'サイトがhttpsで表示されるのを確認してから行って下さい。',
		'priority' => 108
	)
);
	/*imgをhttp→https*/
		$wp_customize->add_setting(
			'inner_http',
			array(
				'default' => ''
			)
		);
		$wp_customize->add_control(
			'inner_http',
			array(
				'section' => 'ssl_setting',
				'settings' => 'inner_http',
				'label' => '記事内の内部リンク及び画像ファイルURLをhttpからhttpsに一括変換する',
				'description' => '(外部サイトの画像URLは変換されません)',
				'type' => 'checkbox'
			)
		);

//ページ送り設定
$wp_customize->add_section(
	'page_link_setting',
	array(
		'title' => 'ページ送り設定',
		'description' => '記事の一番下に表示される「前の記事」「次の記事」へのリンクに関する設定',
		'priority' => 109
	)
);
	/*カテゴリーごと*/
		$wp_customize->add_setting(
			'for_category',
			array(
				'default' => ''
			)
		);
		$wp_customize->add_control(
			'for_category',
			array(
				'section' => 'page_link_setting',
				'settings' => 'for_category',
				'label' => '記事の前後へのリンクをカテゴリーごとにする',
				'description' => '内部リンクにより各カテゴリーページ（一覧ページ）のSEO効果が期待されます',
				'type' => 'checkbox'
			)
		);
}




/****  get_theme_mod関数  ****/
function is_desc(){
	return get_theme_mod("is_desc", true);
}
function is_aligncenter(){
	return get_theme_mod("is_aligncenter", false);
}
function get_header_color(){
	return get_theme_mod("header_color", HEADER_COLOR_DEFAULT);
}
function get_title_color(){
	return get_theme_mod("title_color", HEADER_TEXT_COLOR_DEFAULT);
}
function get_side_color(){
	return get_theme_mod("side_color", SIDE_COLOR_DEFAULT);
}
function get_side_text_color(){
	return get_theme_mod("side_text_color", SIDE_TEXT_COLOR_DEFAULT);
}
function get_accent_color(){
	return get_theme_mod("accent_color", ACCENT_COLOR_DEFAULT);
}
function get_link_hover_color(){
	return get_theme_mod("link_hover_color", LINK_HOVER_COLOR_DEFAULT);
}
function is_twitter_follow(){
	return get_theme_mod("is_twitter_follow", true);
}
function is_fb_follow(){
	return get_theme_mod("is_fb_follow", true);
}
function is_g_follow(){
	return get_theme_mod("is_g_follow", true);
}
function is_feedly_follow(){
	return get_theme_mod("is_feedly_follow", true);
}
function is_line_follow(){
	return get_theme_mod("is_line_follow", true);
}
function get_count_cat_post(){
	return get_theme_mod("count_cat_post", 3);
}
function is_share_top_of_content(){
	return get_theme_mod("is_share_top_of_content", true);
}
function get_count_kanren(){
	return get_theme_mod("count_kanren", 6);
}
function is_set_to_top(){
	return get_theme_mod("is_set_to_top", true);
}
function is_set_to_home(){
	return get_theme_mod("is_set_to_home_", true);
}
function is_show_rewrite_date(){
	return get_theme_mod("is_show_rewrite_date", true);
}
function is_eyecatch(){
	return get_theme_mod("is_eyecatch", true);
}
function is_ad_top_of_index(){
	return get_theme_mod("ad_top_of_index", true);
}
function is_ad_second_h2(){
	return get_theme_mod("ad_second_h2", true);
}
function is_not_display_thumbnail(){
	return get_theme_mod("no_thumbnail", false);
}
function get_index_style(){
	return get_theme_mod("style_select", "type1");
}
function is_ssl_inner_http(){
	return get_theme_mod("inner_http", false);
}
function is_for_category(){
	return get_theme_mod("for_category", false);
}


/****  wp_head出力  ****/
add_action( 'wp_head', 'customize_css');
function customize_css(){ ?>
	<style>
	.header_inner, .header_color{background: <?php echo get_header_color() ?>;}
	.site_title a, .site_desc, .header_color{color: <?php echo get_title_color() ?>;}
	.sidebar_color, .side:before{background: <?php echo get_side_color() ?>;}
	.drawer-hamburger{background: <?php echo get_side_color() ?> !important;}
	.sidebar_color, .side h2, .side p, .side a, .main_footer a{color: <?php echo get_side_text_color() ?>;}
	.drawer-hamburger-icon, .drawer-hamburger-icon:after, .drawer-hamburger-icon:before{background: <?php echo get_side_text_color() ?>;}
	.side h2{border-bottom: 1px solid <?php echo get_side_text_color() ?>;}
	.drawer-hamburger{color: <?php echo get_side_text_color() ?> !important;}
	.content_body h2{background: <?php echo get_accent_color() ?>;}
	.content_body h3{border-bottom: 3px solid <?php echo get_accent_color() ?>;}
	.content_body h4{border-left: 7px solid <?php echo get_accent_color() ?>;}
	.accent_color, #wp-calendar caption, .comment_open, .wpp-list li:before{background: <?php echo get_accent_color() ?>; color:#fff;}
	.accent_header, h2.under_content{color: <?php echo get_accent_color() ?>; border-top: 2px solid <?php echo get_accent_color() ?>; border-bottom: 2px solid <?php echo get_accent_color() ?>;}
	.hover_color:hover,
	.side a:hover,
	.bread a:hover,
	.main_footer a:hover,
	.footer a:hover,
	#wp-calendar a:hover{color: <?php echo get_link_hover_color() ?> !important;}
	.hover_back_color:hover,
	.cat_link a:hover,
	.pagenavi a:hover,
	.move_buttons p:hover,
	.comment_open:hover,
	.com-back a:hover,
	.com-next a:hover{background: <?php echo get_link_hover_color() ?>;}
<?php
$count_followButtons = 0;
if(is_twitter_follow()){ $count_followButtons += 1; }
if(is_fb_follow()){ $count_followButtons += 1; }
if(is_g_follow()){ $count_followButtons += 1; }
if(is_feedly_follow()){ $count_followButtons += 1; }
if(is_line_follow()){ $count_followButtons += 1; }
if($count_followButtons){
	$width_followButton = floor(100 / $count_followButtons);
?>
	.follow-icon{width: <?php echo $width_followButton; ?>%;}
<?php }

	if(get_index_style()=="type2"){ ?>
		.posts .post:nth-child(odd){clear:both; float:left;}
		.posts .post:nth-child(even){float:right;}
		.posts .post{clear:none; width:48%; max-width: 350px; margin-bottom: 50px;}
		.posts .thumb_box{width:auto; height:auto; max-height:200px; float:none; box-shadow:0 1px 3px #ddd;}
		.posts .thumb_box img{position:static; -webkit-transform:none; -ms-transform:none; transform:none; max-width:100%; height:auto; display:block; margin: 0 auto;}
		.posts .thumb_box p{font-size:18px; }
		.posts a{text-decoration:none;}
		.posts .post_info{width:auto; float:none; padding:18px 10px 10px 15px;}
		.posts .post_info .write_date, .posts .post_info .sns_count{font-size:14px; line-height:14px;}
		.posts .post_info .write_date{width:96px;}
		.posts .post_info h3{font-size:1.1em; line-height:34px;}

		@media screen and (max-width: 760px){
			.posts .post_info{padding-left:10px; padding-right:6px;}
		}

		@media screen and (max-width: 620px){
			.posts{width:350px; max-width:96%; min-width:300.797px; margin-left:auto; margin-right:auto;}
			.posts .post{float:none !important; width:100%;}
			.posts .post_info{padding-left:15px; padding-right:10px;}
			.posts .post_info h3{font-size:1.2em; margin:10px 0 6px;}
		}
	<?php } ?>

	</style>
<?php }
?>
