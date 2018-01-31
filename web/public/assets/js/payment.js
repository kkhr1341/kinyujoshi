/**
 * 新規カードで申し込み
 * @param card       Object カード情報
 * @param event_code String イベントコード
 * @param name       String お名前
 * @param email      String メールアドレス
 * @returns {Promise}
 */
function chargeByNewCard(card, event_code, name, email) {
    return new Promise(function(resolve, reject) {
        Payjp.createToken(card, function (s, response) {
            if (response.error) {
                reject(response.error.message);
            } else {
                var token = response.id;
                var url = "/api/applications/create";
                var params = {
                    event_code: event_code,
                    name: name,
                    email: email,
                    token: token,
                    cardselect: 0
                };
                // $.postが独自カスタマイズされているためコールバック関数orエラーハンドリングが特殊なかたちに。。。
                return ajax.post(url, params, function(data) {
	                resolve(data);
                    })
                    .done(function(data) {
                        if(data.api_status === 'error') {
                            reject(data.message);
                        }
                    })
                    .fail(function(error) {
                        reject(error);
                    })
            }
        })
    })
}

/**
 * 登録カードで申し込み
 * @param event_code String イベントコード
 * @param cardselect String 登録カードID
 * @param name       String お名前
 * @param email      String メールアドレス
 * @returns {Promise}
 */
function chargeByRegisterCard(event_code, cardselect, name, email) {
    return new Promise(function(resolve, reject) {
        var url = "/api/applications/create";
        var params = {
            event_code: event_code,
            cardselect: cardselect,
            name: name,
            email: email
        };
        return ajax.post(url, params, function(data) {
                resolve(data);
            })
            .done(function(data) {
                if(data.api_status === 'error') {
	            reject(data.message);
	        }
	    })
            .fail(function(error) {
                reject(error);
	    })
    })
}
