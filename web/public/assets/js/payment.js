/**
 * 新規カードで申し込み
 * @param card        Object カード情報
 * @param event_code  String イベントコード
 * @param name        String お名前
 * @param email       String メールアドレス
 * @param coupon_code String イベントクーポンコード
 * @param message     String 問い合わせ内容
 * @returns {Promise}
 */
function chargeByNewCard(card, event_code, name, email, coupon_code, message) {
    var paymentErrorMessage = '決済ができませんでした...。カード情報を再度ご確認いただけますと幸いです。';
    return new Promise(function(resolve, reject) {
        Payjp.createToken(card, function (s, response) {
            if (response.error) {
                if (response.error.code == 'invalid_expiry_year') {
                    reject({message: '有効期限の"年"は、4桁でのご入力をお願いいたします。'});
                } else {
                    reject({message: paymentErrorMessage});
                }
            } else {
                var token = response.id;
                var url = "/api/applications/create";
                var params = {
                    event_code: event_code,
                    name: name,
                    email: email,
                    token: token,
                    cardselect: 0,
                    coupon_code: coupon_code,
                    message: message
                };
                // $.postが独自カスタマイズされているためコールバック関数orエラーハンドリングが特殊なかたちに。。。
                return ajax.post(
                    url,
                    params,
                    function(data) {
	                    resolve(data);
                    },
                    function(data) {
                        reject(data);
                    }
                )
                    // .done(function(data) {
                    //     if(data.api_status === 'error') {
                    //         reject(paymentErrorMessage);
                    //     }
                    // })
                    // .fail(function(error) {
                    //     reject(paymentErrorMessage);
                    // })
            }
        })
    })
}

/**
 * 登録カードで申し込み
 * @param event_code  String イベントコード
 * @param cardselect  String 登録カードID
 * @param name        String お名前
 * @param email       String メールアドレス
 * @param coupon_code String イベントクーポンコード
 * @param message     String 問い合わせ内容
 * @returns {Promise}
 */
function chargeByRegisterCard(event_code, cardselect, name, email, coupon_code, message) {
    // var paymentErrorMessage = '決済ができませんでした...。カード情報を再度ご確認いただけますと幸いです。';
    return new Promise(function(resolve, reject) {
        var url = "/api/applications/create";
        var params = {
            event_code: event_code,
            cardselect: cardselect,
            name: name,
            email: email,
            coupon_code: coupon_code,
            message: message
        };
        return ajax.post(
            url,
            params,
            function(data) {
                resolve(data);
            },
            function(data) {
                reject(data);
            }
        );
    })
}
