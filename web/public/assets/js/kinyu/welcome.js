var $url = location.href;
var $result = $url.replace( "/welcome" , "" );
var urlcode = '<a class="skipp-link" href="%result">このページをスキップ</a>'.replace("%result", $result);