jQuery.postJSON = function(url, data, callback) {
	jQuery.post(url, data, callback, "json");
};


function thumb(string) {
	var strings = explode('/', string);
	strings[sizeof(strings)-1] = 'thumb_'+strings[sizeof(strings)-1];
	string = implode('/', strings);
	return string;
} 

/**
 * convert zenkaku to hankaku
 */
function convertToHankaku(id) {
	$(id).change(function(){
		var txt  = $(this).val();
		var han = mb_convert_kana(txt, 'rnmskh');
		$(this).val(han);
	});
}

/**
 * convert hiragana to katakana
 */
function convertToKana(id) {
	$(id).change(function(){
		var txt  = $(this).val();
		var han = mb_convert_kana(txt, 'C');
		$(this).val(han);
	});
}

/**
 * convert hankaku to zenkaku
 */
function convertToZenkaku(id) {
	$(id).change(function(){
		var txt  = $(this).val();
		var han = mb_convert_kana(txt, 'K');
		$(this).val(han);
	});
}
/**
 * date format
 */
function dateFormat(id, type) {
	$(id).change(function(){
		var txt  = $(this).val();
		if (type == 'Y') {
			txt = sprintf('%04d', intval(txt));
		}
		else {
			txt = sprintf('%02d', intval(txt));
		}
		$(this).val(txt);
	});
}

/**
 * validate_intval
 */
function validate_intval(val) {
	if (typeof val == 'undefined') {
		return true;
	}
	val = val.toString();
	if(!val.match(/[^0-9]+/)){
		return true;
	}
	else {
		return false;
	}
}

function ValidateKana(str) {
	if (typeof str == 'undefined') {
		return true;
	}
	return str.match(/^[ァ-ヶー]*$/);
}

/*
 * validate email
 */
function ValidateEmail(mail) {
	if (typeof mail == 'undefined') {
		return true;
	}
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(mail);
}
/*
 * validate url
 */
function ValidateURL(url) {
	if (typeof url == 'undefined') {
		return true;
	}
	var pattern = /http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
	if (url.match(pattern)){
		return true;
	}
	return false;
}
/**
 * 全角2文字、半角1文字で計算する
 * @returns
 */
function get_str_length(text) {
	var byte = 0;
	for (i = 0; i < text.length; i++) {
		n = escape(text.charAt(i));
		if (n.length < 4) {
			byte++;
		}
		else {
			byte+=2;
		}
	}	
	return byte;
}

/**
 * PHPの mb_convert_kana() っぽいもの
 * mMオプションで記号 /[!#-&(-/:-@[\]^_{|}]/ を変換
 * PHPにおける a または A オプションは rnm または RNM オプションとほぼ等価
 * (バッククオーテーションを変換しない点がPHPと異なる)
 * PHPとは違い、hc または kC の組み合わせのオプションにおいて、c または C オプションを無視しない
 * PHPと同様に動かしたいときは上記の組み合わせのオプションを指定しない or このスクリプトをテキトーに弄る
 *
 * @param string str
 * @param string option デフォルトは KV
 *    r : 「全角」英字を「半角」に変換
 *    R : 「半角」英字を「全角」に変換
 *    n : 「全角」数字を「半角」に変換
 *    N : 「半角」数字を「全角」に変換
 *    m : 「全角」記号を「半角」に変換
 *    M : 「半角」記号を「全角」に変換
 *    s : 「全角」スペースを「半角」
 *    S : 「半角」スペースを「全角」
 *    k : 「全角カタカナ」を「半角カタカナ」に変換
 *    K : 「半角カタカナ」を「全角カタカナ」に変換
 *    h : 「全角ひらがな」を「半角カタカナ」に変換
 *    H : 「半角カタカナ」を「全角ひらがな」に変換
 *    c : 「全角カタカナ」を「全角ひらがな」に変換
 *    C : 「全角ひらがな」を「全角カタカナ」に変換
 *    V : 濁点付きの文字を一文字に変換。"K", "H" と共に使用
 
 *    o : [2011/8/25追加] ”“’‘｀￥ を ""''`\に変換
 *    O : [2011/8/25追加] "'`\ を ”’｀￥ に変換
 */
var mb_convert_kana = function( str, option )
{
	if( option === '' || option === undefined || option === null )
	{
		// デフォルトのオプション
		option = 'KV';
	}

	// 1文字用の正規表現
	var re = '[';

	// 2文字(濁点との組み合わせ)用の正規表現
	var re_v = '(?:';

	// 変換用の配列
	var list = {};

	// list に配列をマージする
	var m = function( o )
	{
		for( var k in o )
		{
			list[k] = o[k];
		}
	}

	if( option.indexOf('r') !== -1 && str.search(/[ａ-ｚＡ-Ｚ]/) !== -1 )
	{
		m( {'ａ':'a','ｂ':'b','ｃ':'c','ｄ':'d','ｅ':'e','ｆ':'f','ｇ':'g','ｈ':'h','ｉ':'i','ｊ':'j','ｋ':'k','ｌ':'l','ｍ':'m','ｎ':'n','ｏ':'o','ｐ':'p','ｑ':'q','ｒ':'r','ｓ':'s','ｔ':'t','ｕ':'u','ｖ':'v','ｗ':'w','ｘ':'x','ｙ':'y','ｚ':'z','Ａ':'A','Ｂ':'B','Ｃ':'C','Ｄ':'D','Ｅ':'E','Ｆ':'F','Ｇ':'G','Ｈ':'H','Ｉ':'I','Ｊ':'J','Ｋ':'K','Ｌ':'L','Ｍ':'M','Ｎ':'N','Ｏ':'O','Ｐ':'P','Ｑ':'Q','Ｒ':'R','Ｓ':'S','Ｔ':'T','Ｕ':'U','Ｖ':'V','Ｗ':'W','Ｘ':'X','Ｙ':'Y','Ｚ':'Z'} );
		re += 'ａ-ｚＡ-Ｚ';
	}

	if( option.indexOf('R') !== -1 && str.search(/[a-zA-Z]/) !== -1 )
	{
		m( {'a':'ａ','b':'ｂ','c':'ｃ','d':'ｄ','e':'ｅ','f':'ｆ','g':'ｇ','h':'ｈ','i':'ｉ','j':'ｊ','k':'ｋ','l':'ｌ','m':'ｍ','n':'ｎ','o':'ｏ','p':'ｐ','q':'ｑ','r':'ｒ','s':'ｓ','t':'ｔ','u':'ｕ','v':'ｖ','w':'ｗ','x':'ｘ','y':'ｙ','z':'ｚ','A':'Ａ','B':'Ｂ','C':'Ｃ','D':'Ｄ','E':'Ｅ','F':'Ｆ','G':'Ｇ','H':'Ｈ','I':'Ｉ','J':'Ｊ','K':'Ｋ','L':'Ｌ','M':'Ｍ','N':'Ｎ','O':'Ｏ','P':'Ｐ','Q':'Ｑ','R':'Ｒ','S':'Ｓ','T':'Ｔ','U':'Ｕ','V':'Ｖ','W':'Ｗ','X':'Ｘ','Y':'Ｙ','Z':'Ｚ'} );
		re += 'a-zA-Z';
	}

	if( option.indexOf('n') !== -1 && str.search(/[０-９]/) !== -1 )
	{
		m( {'０':'0','１':'1','２':'2','３':'3','４':'4','５':'5','６':'6','７':'7','８':'8','９':'9'} );
		re += '０-９';
	}

	if( option.indexOf('N') !== -1 && str.search(/\d/) !== -1 )
	{
		m( {'0':'０','1':'１','2':'２','3':'３','4':'４','5':'５','6':'６','7':'７','8':'８','9':'９'} );
		re += '\\d';
	}

	if( option.indexOf('s') !== -1 && str.indexOf('　') !== -1 )
	{
		m( {'　':' '} );
		re += '　';
	}

	if( option.indexOf('S') !== -1 && str.indexOf(' ') !== -1 )
	{
		m( {' ':'　'} );
		re += ' ';
	}

	if( option.indexOf('m') !== -1 && str.search(/[！＃＄％＆（）＊＋，－．／：；＜＝＞？＠［］＾＿｛｜｝]/) !== -1 )
	{
		m( {'！':'!','＃':'#','＄':'$','％':'%','＆':'&','（':'(','）':')','＊':'*','＋':'+','，':',','－':'-','．':'.','／':'/','：':':','；':';','＜':'<','＝':'=','＞':'>','？':'?','＠':'@','［':'[','］':']','＾':'^','＿':'_','｛':'{','｜':'|','｝':'}'} );
		re += '！＃＄％＆（）＊＋，－．／：；＜＝＞？＠［］＾＿｛｜｝';
	}

	if( option.indexOf('M') !== -1 && str.search(/[!#-&(-/:-@[\]^_{|}]/) !== -1 )
	{
		m( {'!':'！','#':'＃','$':'＄','%':'％','&':'＆','(':'（',')':'）','*':'＊','+':'＋',',':'，','-':'－','.':'．','/':'／',':':'：',';':'；','<':'＜','=':'＝','>':'＞','?':'？','@':'＠','[':'［',']':'］','^':'＾','_':'＿','{':'｛','|':'｜','}':'｝'} );
		re += '!#-&(-/:-@[\\]^_{|}';
	}

	if( option.indexOf('o') !== -1 && str.search(/[”“’‘｀￥]/) !== -1 )
	{
		m( {'”':'"','“':'"','’':"'",'‘':"'",'｀':'`','￥':'\\'} );
		re += '”“’‘｀￥';
	}

	if( option.indexOf('O') !== -1 && str.search(/["'`\\]/) !== -1 )
	{
		m( {'"':'”',"'":'’','`':'｀','\\':'￥'} );
		re += '"\\\'`\\\\';
	}

	if( option.indexOf('k') !== -1 && str.search(/[、。「」゛゜ァ-ヴ・ー]/) !== -1 )
	{
		m( {
			'ガ':'ｶﾞ','ギ':'ｷﾞ','グ':'ｸﾞ','ゲ':'ｹﾞ','ゴ':'ｺﾞ','ザ':'ｻﾞ','ジ':'ｼﾞ','ズ':'ｽﾞ','ゼ':'ｾﾞ','ゾ':'ｿﾞ','ダ':'ﾀﾞ','ヂ':'ﾁﾞ','ヅ':'ﾂﾞ','デ':'ﾃﾞ','ド':'ﾄﾞ','バ':'ﾊﾞ','パ':'ﾊﾟ','ビ':'ﾋﾞ','ピ':'ﾋﾟ','ブ':'ﾌﾞ','プ':'ﾌﾟ','ベ':'ﾍﾞ','ペ':'ﾍﾟ','ボ':'ﾎﾞ','ポ':'ﾎﾟ','ヴ':'ｳﾞ',
			'。':'｡','「':'｢','」':'｣','、':'､','・':'･','ヲ':'ｦ','ァ':'ｧ','ィ':'ｨ','ゥ':'ｩ','ェ':'ｪ','ォ':'ｫ','ャ':'ｬ','ュ':'ｭ','ョ':'ｮ','ッ':'ｯ','ー':'ｰ','ア':'ｱ','イ':'ｲ','ウ':'ｳ','エ':'ｴ','オ':'ｵ','カ':'ｶ','キ':'ｷ','ク':'ｸ','ケ':'ｹ','コ':'ｺ','サ':'ｻ','シ':'ｼ','ス':'ｽ','セ':'ｾ','ソ':'ｿ','タ':'ﾀ','チ':'ﾁ','ツ':'ﾂ','テ':'ﾃ','ト':'ﾄ','ナ':'ﾅ','ニ':'ﾆ','ヌ':'ﾇ','ネ':'ﾈ','ノ':'ﾉ','ハ':'ﾊ','ヒ':'ﾋ','フ':'ﾌ','ヘ':'ﾍ','ホ':'ﾎ','マ':'ﾏ','ミ':'ﾐ','ム':'ﾑ','メ':'ﾒ','モ':'ﾓ','ヤ':'ﾔ','ユ':'ﾕ','ヨ':'ﾖ','ラ':'ﾗ','リ':'ﾘ','ル':'ﾙ','レ':'ﾚ','ロ':'ﾛ','ワ':'ﾜ','ン':'ﾝ','゜':'ﾟ','゛':'ﾞ','ヮ':'ﾜ','ヰ':'ｲ','ヱ':'ｴ'} );
		re += '、。「」゛゜ァ-ヴ・ー';
	}

	if( option.indexOf('V') !== -1 && str.search(/(?:[ｳｶ-ﾄﾊ-ﾎ]ﾞ|[ﾊ-ﾎ]ﾟ)/) !== -1 && option.indexOf('K') !== -1 )
	{
		m( {'ｶﾞ':'ガ','ｷﾞ':'ギ','ｸﾞ':'グ','ｹﾞ':'ゲ','ｺﾞ':'ゴ','ｻﾞ':'ザ','ｼﾞ':'ジ','ｽﾞ':'ズ','ｾﾞ':'ゼ','ｿﾞ':'ゾ','ﾀﾞ':'ダ','ﾁﾞ':'ヂ','ﾂﾞ':'ヅ','ﾃﾞ':'デ','ﾄﾞ':'ド','ﾊﾞ':'バ','ﾊﾟ':'パ','ﾋﾞ':'ビ','ﾋﾟ':'ピ','ﾌﾞ':'ブ','ﾌﾟ':'プ','ﾍﾞ':'ベ','ﾍﾟ':'ペ','ﾎﾞ':'ボ','ﾎﾟ':'ポ','ｳﾞ':'ヴ'} );
		re_v += '[ｳｶ-ﾄﾊ-ﾎ]ﾞ|[ﾊ-ﾎ]ﾟ|';
	}

	if( option.indexOf('K') !== -1 && str.search(/[｡-ﾟ]/) !== -1 )
	{
		m( {'｡':'。','｢':'「','｣':'」','､':'、','･':'・','ｦ':'ヲ','ｧ':'ァ','ｨ':'ィ','ｩ':'ゥ','ｪ':'ェ','ｫ':'ォ','ｬ':'ャ','ｭ':'ュ','ｮ':'ョ','ｯ':'ッ','ｰ':'ー','ｱ':'ア','ｲ':'イ','ｳ':'ウ','ｴ':'エ','ｵ':'オ','ｶ':'カ','ｷ':'キ','ｸ':'ク','ｹ':'ケ','ｺ':'コ','ｻ':'サ','ｼ':'シ','ｽ':'ス','ｾ':'セ','ｿ':'ソ','ﾀ':'タ','ﾁ':'チ','ﾂ':'ツ','ﾃ':'テ','ﾄ':'ト','ﾅ':'ナ','ﾆ':'ニ','ﾇ':'ヌ','ﾈ':'ネ','ﾉ':'ノ','ﾊ':'ハ','ﾋ':'ヒ','ﾌ':'フ','ﾍ':'ヘ','ﾎ':'ホ','ﾏ':'マ','ﾐ':'ミ','ﾑ':'ム','ﾒ':'メ','ﾓ':'モ','ﾔ':'ヤ','ﾕ':'ユ','ﾖ':'ヨ','ﾗ':'ラ','ﾘ':'リ','ﾙ':'ル','ﾚ':'レ','ﾛ':'ロ','ﾜ':'ワ','ﾝ':'ン','ﾟ':'゜','ﾞ':'゛'} );
		re += '｡-ﾟ';
	}

	if( option.indexOf('h') !== -1 && str.search(/[、。「」゛゜ぁ-ん・ー]/) !== -1 )
	{
		m( {
			'が':'ｶﾞ','ぎ':'ｷﾞ','ぐ':'ｸﾞ','げ':'ｹﾞ','ご':'ｺﾞ','ざ':'ｻﾞ','じ':'ｼﾞ','ず':'ｽﾞ','ぜ':'ｾﾞ','ぞ':'ｿﾞ','だ':'ﾀﾞ','ぢ':'ﾁﾞ','づ':'ﾂﾞ','で':'ﾃﾞ','ど':'ﾄﾞ','ば':'ﾊﾞ','ぱ':'ﾊﾟ','び':'ﾋﾞ','ぴ':'ﾋﾟ','ぶ':'ﾌﾞ','ぷ':'ﾌﾟ','べ':'ﾍﾞ','ぺ':'ﾍﾟ','ぼ':'ﾎﾞ','ぽ':'ﾎﾟ',
			'。':'｡','「':'｢','」':'｣','、':'､','・':'･','を':'ｦ','ぁ':'ｧ','ぃ':'ｨ','ぅ':'ｩ','ぇ':'ｪ','ぉ':'ｫ','ゃ':'ｬ','ゅ':'ｭ','ょ':'ｮ','っ':'ｯ','ー':'ｰ','あ':'ｱ','い':'ｲ','う':'ｳ','え':'ｴ','お':'ｵ','か':'ｶ','き':'ｷ','く':'ｸ','け':'ｹ','こ':'ｺ','さ':'ｻ','し':'ｼ','す':'ｽ','せ':'ｾ','そ':'ｿ','た':'ﾀ','ち':'ﾁ','つ':'ﾂ','て':'ﾃ','と':'ﾄ','な':'ﾅ','に':'ﾆ','ぬ':'ﾇ','ね':'ﾈ','の':'ﾉ','は':'ﾊ','ひ':'ﾋ','ふ':'ﾌ','へ':'ﾍ','ほ':'ﾎ','ま':'ﾏ','み':'ﾐ','む':'ﾑ','め':'ﾒ','も':'ﾓ','や':'ﾔ','ゆ':'ﾕ','よ':'ﾖ','ら':'ﾗ','り':'ﾘ','る':'ﾙ','れ':'ﾚ','ろ':'ﾛ','わ':'ﾜ','ん':'ﾝ','゜':'ﾟ','゛':'ﾞ','ゎ':'ﾜ','ゐ':'ｲ','ゑ':'ｴ'} );
		re += '、。「」゛゜ぁ-ん・ー';
	}

	if( option.indexOf('H') !== -1 && option.indexOf('K') === -1 && option.indexOf('V') !== -1 && str.search(/(?:[ｶ-ﾄﾊ-ﾎ]ﾞ|[ﾊ-ﾎ]ﾟ)/) !== -1 )
	{
		m( {'ｶﾞ':'が','ｷﾞ':'ぎ','ｸﾞ':'ぐ','ｹﾞ':'げ','ｺﾞ':'ご','ｻﾞ':'ざ','ｼﾞ':'じ','ｽﾞ':'ず','ｾﾞ':'ぜ','ｿﾞ':'ぞ','ﾀﾞ':'だ','ﾁﾞ':'ぢ','ﾂﾞ':'づ','ﾃﾞ':'で','ﾄﾞ':'ど','ﾊﾞ':'ば','ﾊﾟ':'ぱ','ﾋﾞ':'び','ﾋﾟ':'ぴ','ﾌﾞ':'ぶ','ﾌﾟ':'ぷ','ﾍﾞ':'べ','ﾍﾟ':'ぺ','ﾎﾞ':'ぼ','ﾎﾟ':'ぽ'} );
		re_v += '[ｶ-ﾄﾊ-ﾎ]ﾞ|[ﾊ-ﾎ]ﾟ|';
	}

	if( option.indexOf('H') !== -1 && option.indexOf('K') === -1 && str.search(/[｡-ﾟ]/) !== -1 )
	{
		m( {'｡':'。','｢':'「','｣':'」','､':'、','･':'・','ｦ':'を','ｧ':'ぁ','ｨ':'ぃ','ｩ':'ぅ','ｪ':'ぇ','ｫ':'ぉ','ｬ':'ゃ','ｭ':'ゅ','ｮ':'ょ','ｯ':'っ','ｰ':'ー','ｱ':'あ','ｲ':'い','ｳ':'う','ｴ':'え','ｵ':'お','ｶ':'か','ｷ':'き','ｸ':'く','ｹ':'け','ｺ':'こ','ｻ':'さ','ｼ':'し','ｽ':'す','ｾ':'せ','ｿ':'そ','ﾀ':'た','ﾁ':'ち','ﾂ':'つ','ﾃ':'て','ﾄ':'と','ﾅ':'な','ﾆ':'に','ﾇ':'ぬ','ﾈ':'ね','ﾉ':'の','ﾊ':'は','ﾋ':'ひ','ﾌ':'ふ','ﾍ':'へ','ﾎ':'ほ','ﾏ':'ま','ﾐ':'み','ﾑ':'む','ﾒ':'め','ﾓ':'も','ﾔ':'や','ﾕ':'ゆ','ﾖ':'よ','ﾗ':'ら','ﾘ':'り','ﾙ':'る','ﾚ':'れ','ﾛ':'ろ','ﾜ':'わ','ﾝ':'ん','ﾟ':'゜','ﾞ':'゛'} );
		re += '｡-ﾟ';
	}

	if( option.indexOf('c') !== -1 && option.indexOf('k') === -1 && str.search(/[ァ-ン]/) !== -1 )
	{
	
		m( {
			'ガ':'が','ギ':'ぎ','グ':'ぐ','ゲ':'げ','ゴ':'ご','ザ':'ざ','ジ':'じ','ズ':'ず','ゼ':'ぜ','ゾ':'ぞ','ダ':'だ','ヂ':'ぢ','ヅ':'づ','デ':'で','ド':'ど','バ':'ば','パ':'ぱ','ビ':'び','ピ':'ぴ','ブ':'ぶ','プ':'ぷ','ベ':'べ','ペ':'ぺ','ボ':'ぼ','ポ':'ぽ',
			'ヲ':'を','ァ':'ぁ','ィ':'ぃ','ゥ':'ぅ','ェ':'ぇ','ォ':'ぉ','ャ':'ゃ','ュ':'ゅ','ョ':'ょ','ッ':'っ','ア':'あ','イ':'い','ウ':'う','エ':'え','オ':'お','カ':'か','キ':'き','ク':'く','ケ':'け','コ':'こ','サ':'さ','シ':'し','ス':'す','セ':'せ','ソ':'そ','タ':'た','チ':'ち','ツ':'つ','テ':'て','ト':'と','ナ':'な','ニ':'に','ヌ':'ぬ','ネ':'ね','ノ':'の','ハ':'は','ヒ':'ひ','フ':'ふ','ヘ':'へ','ホ':'ほ','マ':'ま','ミ':'み','ム':'む','メ':'め','モ':'も','ヤ':'や','ユ':'ゆ','ヨ':'よ','ラ':'ら','リ':'り','ル':'る','レ':'れ','ロ':'ろ','ワ':'わ','ン':'ん','ヮ':'ゎ','ヰ':'ゐ','ヱ':'ゑ'} );
		re += 'ァ-ン';
	}

	if( option.indexOf('C') !== -1 && option.indexOf('h') === -1 && str.search(/[ぁ-ん]/) !== -1 )
	{
	
		m( {
			'が':'ガ','ぎ':'ギ','ぐ':'グ','げ':'ゲ','ご':'ゴ','ざ':'ザ','じ':'ジ','ず':'ズ','ぜ':'ゼ','ぞ':'ゾ','だ':'ダ','ぢ':'ヂ','づ':'ヅ','で':'デ','ど':'ド','ば':'バ','ぱ':'パ','び':'ビ','ぴ':'ピ','ぶ':'ブ','ぷ':'プ','べ':'ベ','ぺ':'ペ','ぼ':'ボ','ぽ':'ポ','を':'ヲ',
			'ぁ':'ァ','ぃ':'ィ','ぅ':'ゥ','ぇ':'ェ','ぉ':'ォ','ゃ':'ャ','ゅ':'ュ','ょ':'ョ','っ':'ッ','あ':'ア','い':'イ','う':'ウ','え':'エ','お':'オ','か':'カ','き':'キ','く':'ク','け':'ケ','こ':'コ','さ':'サ','し':'シ','す':'ス','せ':'セ','そ':'ソ','た':'タ','ち':'チ','つ':'ツ','て':'テ','と':'ト','な':'ナ','に':'ニ','ぬ':'ヌ','ね':'ネ','の':'ノ','は':'ハ','ひ':'ヒ','ふ':'フ','へ':'ヘ','ほ':'ホ','ま':'マ','み':'ミ','む':'ム','め':'メ','も':'モ','や':'ヤ','ゆ':'ユ','よ':'ヨ','ら':'ラ','り':'リ','る':'ル','れ':'レ','ろ':'ロ','わ':'ワ','ん':'ン','ゎ':'ヮ','ゐ':'ヰ','ゑ':'ヱ'} );
		re += 'ぁ-ん';
	}

	if( re === '[' )
	{
		return str;
	}

	re += ']';
	if( re_v === '(?:' )
	{
		re_all = new RegExp( re, 'g' );
	}
	else
	{
		re_v += '))';
		re_v = re_v.replace('|)', '');
		var re_all = '(?:';
		re_all += re_v;
		re_all += '|';
		re_all += re;
		re_all += ')';
		re_all = new RegExp( re_all, 'g' );
	}

	return str.replace( re_all, function(m){
		return list[m];
	} );
};

function popup(url, width, heigth) {
	var form = document.createElement('form'); 
	window.open("", "popup","width=200, height=200");
	
	form.action = "http://headlines.yahoo.co.jp/hl" ; 
	form.target = "popup" ; 
	form.method = "POST" ; 
	form.submit() ;
}

function conf(message, callback, cancel_callback) {
	if (window.confirm(message)) {
		callback();
		return;
	}
	if (typeof cancel_callback == 'function') {
		cancel_callback();
	}
}

/**
 * menu drop down
 */

function set_badge() {

	if (intval(total_alert_num) > 0) {
		favicon.badge(intval(total_alert_num));
		$('#login_user_frame').badger(total_alert_num);
	}
	if (intval(unread_request_num) > 0) {
		$('.menu_requests').badger(unread_request_num);
	}
	if (intval(unread_message_num) > 0) {
		$('.menu_messages').badger(unread_message_num);
	}
	if (intval(unread_information_num) > 0) {
		$('.menu_informations').badger(unread_information_num);
	}
	
}

$(function(){
	
	$('#login_user_frame').click(function(){
		//console.debug($(this).offset());
		$('body').unbind();
		$('#user_menu').fadeIn('fast').css({left:$(this).offset().left, top:60}).width(200);
		//$('#user_menu').removeClass('hidden').css({left:$(this).offset().left, top:45});
		
		setTimeout(function(){
			var res = $('body').click(function(){
				$('#user_menu').fadeOut('fast');
				$('body').unbind();
			});
			//console.debug(res);
		},
		100);
	});

});



/**
 * error check
 */
function clear_error() {
	$('.error').removeClass('error');
	$('.error_message').remove();
}
function error(object_name, error_message) {
	if (typeof object_name == 'object') {

		object_name.addClass('error');
		var message_frame = $("<div class='error_message'></div>");
		$(message_frame).text(error_message);
		object_name.parent().append(message_frame);
	}
	else if ($('#'+object_name).attr("id") != object_name) {
		var i = 1;
		$('*[name='+object_name+']').each(function(){
			$('*[name='+object_name+']').addClass('error');
			if ($('*[name='+object_name+']').length == i) {
				var message_frame = $("<div class='error_message'></div>");
				$(message_frame).text(error_message);
				$(this).parent().append(message_frame);
			}
			i++;
		});
	}
	else {
		$('#'+object_name).addClass('error');
		var message_frame = $("<div class='error_message'></div>");
		$(message_frame).html(error_message);
		$('#'+object_name).parent().append(message_frame);
	}
}
function error_exists() {
	if ($('.error').length == 0) {
		return false;
	}
	// 1つ目にフォーカスを移す
	$('.error')[0].focus();
	return true;
}
function open_add_picture_modal(obj, listsex, no) {
	var $this = $(obj);
	var item_code = listsex.attr('item_code');
	
	var outer = $('<div />');
	var drop_area = $('<div />').addClass('dropable');
	var input_file = $('<input />').attr('type', 'file').attr('name', 'upload_image').attr('data-post', '/api/upload_image/'+item_code+'/'+no).attr('data-crop', 'true').attr('data-height', '500');
	input_file.addClass('hidden');
	drop_area.append(input_file);
	
	
	var modal_callback = function(){};
	var open_callback = function(){
		$('.dropable').droparea({
			post : '/api/upload/'+item_code+'/'+no,
			init : function(r) {
			},
			start: function() {
			},
			complete : function(r){
				var img = $('<img />').attr('src', r.url);
				$('.instructions').append(img);
				$('.dropable').click(function(){
					return false;
				});
				$(img).Jcrop({
					aspectRatio: 1
				});
			}
		});
	};
	$().bmodal({
		contents : drop_area,
		btn_ok : true,
		btn_cancel : true,
		callback : modal_callback,
		open_callback : open_callback
	}).show();

}

$(function(){

	$('#header_menu').click(function(){
	
		if ($('#sidr').offset().left == 0) {
			// 隠す
			$('#sidr').animate({
					left: '-250px'
				}, 400, null, function(){
					
				});
			$('#header_menu').animate({
					left: '0px'
				}, 400, null, function(){
					
				});
		}
		else {
			// 表示する
			$('#sidr').animate({
					left: '0px'
				}, 400, null, function(){
					
				});
			$('#header_menu').animate({
					left: '258px'
				}, 400, null, function(){
					
				});
		}
	});
	var wheight = window.innerHeight ? window.innerHeight : $(window).height();
	$('#sidr').height(wheight);
	$(window).resize(function() {
		var wwheight = window.innerHeight ? window.innerHeight : $(window).height();
		$('#sidr').height(wwheight);
	});
});
