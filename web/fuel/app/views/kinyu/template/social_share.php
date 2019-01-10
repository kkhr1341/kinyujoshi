<?php

$url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

$title = isset($title) ? $title: '';

// URLにリンクを貼る
//echo '<a href="' . $url . '">' . htmlspecialchars($url) . '</a>';

//Facebook
$fbhref = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $url );
$twhref = 'https://twitter.com/intent/tweet?url=' . rawurlencode( $url ) . '&via=kinyu_joshi';
if ($title) {
    $twhref .= '&text=' . rawurldecode($title);
}
$linehref = 'http://line.me/R/msg/text/?' . rawurlencode( $url );
//twitter
//$twtext = "Syncer 知識と感動を同期(Sync)するブログ" ;
//$twencoded = rawurlencode( $twtext ) ;
//echo $twencoded ;


//$twhref = 'https://twitter.com/share?url=' . rawurlencode( $fburl )'&text=' . rawurlencode( $fburl );


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