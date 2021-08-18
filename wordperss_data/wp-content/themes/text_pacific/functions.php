<?php

// カスタムヘッダー
add_theme_support(
  'custom-header',
  array(
    'width' => 950,
    'height' => 295,
    'header-text' => false,
    'default-image' => '%s/images/top/main_image.png',
  )
);


// カスタムメニュー
register_nav_menus(
  array(
    'place_global' => 'グローバル',
    'place_utility' => 'ユーティリティ',
  )   
);


// アイキャッチ画像を利用できるようにします。
add_theme_support('post-thumbnails');

// アイキャッチ画像サイズ設定
set_post_thumbnail_size(90, 90 ,true);

// サイドバー用画像サイズ設定
add_image_size('small_thumbnail', 61, 61, true);

// アーカイブ用画像サイズ設定
add_image_size('large_thumbnail', 120, 120, true);

// サブページヘッダー用画像サイズ設定
add_image_size('category_image', 658, 113, true);

// モールイメージ用画像サイズ設定
add_image_size('pickup_thumbnail', 302, 123, true);


// Child Pages ShortcodeのCSSのURLを変更します。
function change_child_pages_shortcode_css() {
  $url = get_template_directory_uri() . '/css/child-pages-shortcode/style.css';
  return $url;
}
add_filter('child-pages-shortcode-stylesheet', 'change_child_pages_shortcode_css');


// ウィジェット
register_sidebar(array(
  'name' => 'サイドバーウィジェットエリア（上）',
  'id' => 'primary-widget-area',
  'description' => 'サイドバー上部のウィジェットエリア',
  'before_widget' => '<aside id="%1$s" class="widget-container %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h1 class="widget-title">',
  'after_title' => '</h1>',
));

register_sidebar(array(
  'name' => 'サイドバーウィジェットエリア（下）',
  'id' => 'secondary-widget-area',
  'description' => 'サイドバー下部のウィジェットエリア',
  'before_widget' => '<aside id="%1$s" class="widget-container %2$s">',
  'after_widget' => '</aside>',
  'before_title' => '<h1 class="widget-title">',
  'after_title' => '</h1>',
));


// 抜粋文が自動的に生成される場合に最後に付与される文字列を変更します。
function cms_excerpt_more() {
  return ' ...';
}
add_filter('excerpt_more', 'cms_excerpt_more');


// 抜粋文が自動的に生成される場合にデフォルトの文字数を変更します。
function cms_excerpt_length() {
  return 120;
}
add_filter('excerpt_mblength', 'cms_excerpt_length');


// 固定ページで抜粋を入力できるようにする。
add_post_type_support('page', 'excerpt');


// 30文字表示抜粋（自動生成時）表示テンプレートタグの定義
function the_short_excerpt() {
  add_filter('excerpt_mblength', 'short_excerpt_length', 11);
  the_excerpt();
  remove_filter('excerpt_mblength', 'short_excerpt_length', 11);
}

function short_excerpt_length() {
  return 30; 
}

// 50文字表示抜粋表示テンプレートタグの定義
function the_pickup_excerpt() {
  add_filter('get_the_excerpt', 'get_pickup_excerpt', 0);
  add_filter('excerpt_mblength', 'pickup_excerpt_length', 11);
  the_excerpt();
  remove_filter('get_the_excerpt', 'get_pickup_excerpt', 0);
  remove_filter('excerpt_mblength', 'pickup_excerpt_length', 11);
}

// トップページのピックアップ（モール紹介）部分の抜粋文を切り詰める。
function get_pickup_excerpt($excerpt) {
  if ($excerpt) {
    $excerpt = strip_tags($excerpt);
    $excerpt_len = mb_strlen($excerpt);
    if ($excerpt_len > 50) {
      $excerpt = mb_substr($excerpt, 0, 50) . ' ...';
    }    
  }    
  return $excerpt;
}

function pickup_excerpt_length() {
  return 50;
}


// カテゴリー画像の表示
// 1.アイキャッチ画像が設定されている場合は、アイキャッチ画像を使用
// 2.アイキャッチ画像が設定されていない固定ページで、最上位の固定ページにアイキャッチ画像が設定されている場合は、そのアイキャッチ画像を使用
// それ以外の場合は、デフォルトの画像を表示
function the_category_image() {
  global $post;
  $image = ""; 

  if (is_singular() && has_post_thumbnail()) {
    $image = get_the_post_thumbnail(null, 'category_image', array('id' => 'category_image'));
  } elseif (is_page() && has_post_thumbnail(array_pop(get_post_ancestors($post)))) {
    $image = get_the_post_thumbnail(array_pop(get_post_ancestors($post)), 'category_image', array('id' => 'category_image'));
  }

  if ($image == "") {
    $src = get_template_directory_uri() . '/images/category/default.jpg';
    $image = '<img src="' . $src . '" class="attachment-category_image wp-post-image" alt="" id="category_image" />';
  }   
  echo $image;
}


// コラムカテゴリーのみコメントできるようにする。
function comments_allow_only_column($open, $post_id) {
  if (!in_category('column')) { 
    $open = false;
  }     
  return $open;
}
add_filter('comments_open', 'comments_allow_only_column', 10, 2);


// OGPのための各種設定
// アイキャッチ画像のURL取得
function get_thumbnail_image_url() {
  $img_id = get_post_thumbnail_id();
  $img_url = wp_get_attachment_image_src($img_id, 'large', true);
  return $img_url[0];
}


// ogp用description取得
function get_ogp_excerpted_content($content) {
  $content = strip_tags($content);
  $content = mb_substr($content, 0, 120, 'UTF-8');
  $content = preg_replace('/\s\s+/', '', $content);
  $content = preg_replace('/[\r\n]/', '', $content);
  $content = esc_attr($content) . ' ...';
  return $content;
}


// モール開発実績各ページのshortcode
function posts_shortcode ($args) {
  $template = dirname(__FILE__) . '/posts.php';
  if (!file_exists($template)) {
    return;
  }
  $def = array(
    'post_type' => 'shops',
    'taxonomy' => 'mall',
    'term' => '',
    'orderby' => 'asc',
    'posts_per_page' => -1,
  );
  $args = shortcode_atts($def, $args);
  $posts = get_posts($args);
  ob_start();
  foreach ($posts as $post) { 
    $post_custom = get_post_custom($post->ID);
    include($template);
  }   
  $output = ob_get_clean();
  return $output;
}
add_shortcode('posts', 'posts_shortcode');
