<?php

$url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

$query = parse_url($url);
$_params = [];
if( isset($query['query']) ) {
  parse_str($query['query'], $_params);
}

if( isset($user_code) && isset($auth_code) ) {
  $_params['u'] = $user_code;
  $_params['k'] = $auth_code;
}

$url = "https://" . $_SERVER["HTTP_HOST"] . $query['path'] . '?' . http_build_query($_params);
$title = isset($title) ? $title: '';

// URLにリンクを貼る
//echo '<a href="' . $url . '">' . htmlspecialchars($url) . '</a>';

//Facebook
$fbhref = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $url );
$twhref = 'https://twitter.com/intent/tweet?url=' . rawurlencode( $url ) . '&via=kinyu_joshi';
if ($title) {
  $twhref .= '&text=' . rawurldecode($title);
}
// $linehref = 'http://line.me/R/msg/text/?' . rawurlencode( $url );

//Facebookを出力
// echo '<div class="mct_jumboShare">';
// echo '<div class="mct_jumboShare_container">';
// echo '<div class="mct_jumboShare_buttons">';
// echo '<a href="' . $fbhref . '" target="_blank" class="jumboShare_btn facebook"><sapn class="jumboShare_btn_text">Facebookでシェア</span></a>';
// echo '<a href="' . $twhref . '" target="_blank" class="jumboShare_btn twitter"><sapn class="jumboShare_btn_text">Twitterでシェア</span></a>';
// echo '<a href="' . $linehref . '" target="_blank" class="jumboShare_btn line"><sapn class="jumboShare_btn_text">LINEでシェア</span></a>';
// echo '</div>';
// echo '</div>';
// echo '</div>';

echo '<li><a <a href="' . $fbhref . '" target="_blank" class="facebook"><img class="social-logo" src="/images/social/facebook_white01.png"></a></li>';
echo '<li><a href="' . $twhref . '" target="_blank" class="twitter"><img class="social-logo" src="/images/social/twitter_white01.png"></a></li>';
