<?php

return array(
        'required'         => ':labelは必須です',
        'min_length'       => ':labelは:param:1文字以上で入力してください',
        'max_length'       => ':labelは:param:1文字以内で入力してください',
        'exact_length'     => ':labelは:param:1文字で入力してください',
        'match_value'      => ':labelは『:param:1』と一致していません',
        'match_pattern'    => ':labelはパターン『:param:1』と一致しません',
        'match_field'      => ':labelは『:param:1』と一致していません',
        'valid_email'      => ':labelの形式が正しくありません。',
        'valid_emails'     => ':labelに不正なメールアドレスが含まれてます',
        'valid_url'        => ':labelは不正なURLです',
        'valid_ip'         => ':labelは不正なIPアドレスです',
        'numeric_min'      => ':labelは:param:1以上で入力してください',
        'numeric_max'      => ':labelは:param:1以内で入力してください',
        'valid_string'     => ':labelは『:rule』で入力する必要があります',
        'checkbox_require' => ':labelは1つ以上選択する必要があります',
        'required_with' => ':labelは入力必須項目です。',
        'valid_date' => ':labelの形式が正しくありません。',
    
        # 自作
        'num' => ':labelは数字で入力してください',
        'alphanum' => ':labelは英数字で入力してください',
        'unique'   => ':labelが既に使われています',
        'is_fullwidth_katakana'   => ':labelは全角カタカナで入力してください',

        'is_tel'   => ':labelを正しく入力してください',
        'is_zip'   => ':labelを正しく入力してください',
        'is_unique_array_value'   => ':labelの値が重複しています',
        'require_without'   => ':labelは必須です',
        'exists'   => ':labelが存在しません',
);