<?php
return array(
  'version' => 
  array(
    'app' => 
    array(
      'default' => 
      array(
        0 => '001_create_users',
        1 => '002_create_mybbs',
        2 => '003_create_addresses',
        3 => '005_create_applications',
        4 => '006_create_blogs',
        5 => '007_create_categories',
        6 => '008_create_comment',
        7 => '009_create_companies',
        8 => '010_create_courses',
        9 => '011_create_customers',
        10 => '012_create_document_company',
        11 => '013_create_events',
        12 => '014_create_files',
        13 => '015_create_inquiries',
        14 => '016_create_kuchikomi',
        15 => '017_create_member_regist',
        16 => '018_create_needs',
        17 => '019_create_pages',
        18 => '020_create_payments',
        19 => '021_create_privacies',
        20 => '022_create_profiles',
        21 => '023_create_projects',
        22 => '024_create_sections',
        23 => '025_create_tsubuyaki',
        24 => '027_create_users_clients',
        25 => '028_create_users_providers',
        26 => '029_create_users_scopes',
        27 => '030_create_users_sessions',
        28 => '031_create_users_sessionscopes',
        29 => '032_add_creditch_to_events',
        30 => '033_create_news',
        31 => '034_add_name_to_profiles',
        32 => '035_add_name_kana_to_profiles',
        33 => '036_create_application_credit_payments',
        34 => '037_add_name_to_applications',
        35 => '038_add_email_to_applications',
        36 => '039_add_amount_to_applications',
        37 => '040_add_payment_method_to_applications',
        38 => '041_add_incur_cancellation_fee_date_to_events',
        39 => '042_add_place_url_to_events',
        40 => '043_rename_field_token_to_charge_id_in_application_credit_payments',
        41 => '044_create_user_credit_cards',
        42 => '045_create_users_reminders',
        43 => '046_add_catchcopy_to_profiles',
        44 => '047_add_introduction_to_profiles',
        45 => '048_create_index_username_in_users',
        46 => '049_create_index_code_in_applications',
        47 => '050_create_index_application_code_in_application_credit_payments',
        48 => '051_create_index_code_in_events',
        49 => '052_create_index_code_in_member_regist',
        50 => '054_create_index_code_in_profiles',
        51 => '055_create_index_email_in_users',
        52 => '056_add_id_name_to_member_regist',
        53 => '057_add_industry_to_member_regist',
        54 => '058_add_industry_other_to_member_regist',
        55 => '059_delete_email_from_profiles',
        56 => '060_create_regist_reminders',
        57 => '061_create_application_cancels',
        58 => '062_add_email_to_regist_reminders',
        59 => '063_change_title_to_null_in_inquiries',
        60 => '064_create_application_credit_payment_sales',
        61 => '065_create_application_credit_payment_cancels',
        62 => '066_add_cancel_to_application_credit_payments',
        63 => '067_add_sale_to_application_credit_payments',
        64 => '068_add_secret_to_events',
        65 => '069_create_event_remind_mail_templates',
        66 => '070_create_event_remind_mails',
        67 => '071_create_event_remind_mail_default_templates',
        68 => '074_create_event_mails',
        69 => '075_create_event_other_dates',
        70 => '076_add_secret_to_blogs',
        71 => '077_add_display_to_events',
        72 => '078_add_display_event_date_to_events',
        73 => '079_create_event_display_top_pages',
        74 => '080_add_display_past_to_events',
        75 => '081_add_specific_link_to_events',
        76 => '082_create_withdrawal_reasons',
        77 => '083_create_user_withdrawal',
        78 => '084_create_user_withdrawal_reasons',
        79 => '085_create_user_withdrawal_reason_texts',
        80 => '086_create_participated_applications',
        81 => '087_create_change_email_histories',
        82 => '088_add_send_to_event_mails',
        83 => '089_add_authentication_to_blogs',
        84 => '090_create_prefectures',
        85 => '091_add_prefecture_to_profiles',
        86 => '092_create_passports',
        87 => '093_create_diagnostic_chart_routes',
        88 => '093_create_index_code_in_blogs',
        89 => '094_create_blog_stocks',
        90 => '094_create_diagnostic_chart_route_paths',
        91 => '095_create_diagnostic_chart_types',
        92 => '096_create_diagnostic_chart_route_types',
        93 => '097_create_diagnostic_chart_type_users',
        94 => '098_create_diagnostic_chart_route_users',
        95 => '099_add_type_image_to_diagnostic_chart_types',
        96 => '100_add_authentication_to_events',
        97 => '101_create_diagnostic_chart_type_hash_tags',
        98 => '102_create_diagnostic_chart_type_action_lists',
        99 => '103_add_authentication_to_news',
        100 => '104_create_event_coupons',
        101 => '105_add_discount_to_applications',
        102 => '106_create_application_coupons',
        103 => '107_create_business_inquiries',
        104 => '108_create_business_inquiry_appointment_dates',
        105 => '109_create_business_inquiry_categories',
        106 => '110_create_business_inquiry_appointment_dates',
        107 => '111_create_business_inquiry_categories',
        108 => '112_create_user_want_to_learns',
        109 => '113_create_user_regist_triggers',
        110 => '114_create_user_want_to_meets',
        111 => '115_add_where_from_site_to_member_regist',
        112 => '116_add_future_to_member_regist',
        113 => '117_add_want_to_something_to_member_regist',
        114 => '118_add_message_to_applications',
        115 => '119_add_url_to_member_regist',
        116 => '120_create_insight_questions',
        117 => '121_create_insight_question_labels',
        118 => '122_create_insight_question_answers',
        119 => '125_add_memo_to_events',
        120 => '126_create_inquiry_reply_mails',
        121 => '127_create_authors',
        122 => '128_add_author_code_to_blogs',
        123 => '129_add_position_to_authors',
        124 => '130_add_pr_to_blogs',
        125 => '131_add_pr_to_events',
        126 => '132_create_blog_comments',
        127 => '133_create_page_views',
        128 => '134_create_views_blog_views',
        129 => '135_add_specific_application_link_to_events',
        130 => '136_create_sessions',
        131 => '137_add_username_to_authors',
        132 => '138_create_user_blogs',
        133 => '139_create_blog_user_blogs',
        134 => '140_drop_event_remind_mail_default_templates',
        135 => '141_add_status_to_event_remind_mail_templates',
        136 => '142_create_event_thanks_mail_templates',
        137 => '143_create_event_thanks_mails',
        138 => '144_delete_cancel_from_applications',
        139 => '145_create_consultations',
        140 => '146_create_consultation_reply_mails',
        141 => '147_delete_cancel_from_application_credit_payments',
        142 => '148_delete_sale_from_application_credit_payments',
        143 => '151_add_sns_links_to_authors',
        144 => '152_add_profiles_to_publish',
      ),
    ),
    'module' => 
    array(
    ),
    'package' => 
    array(
    ),
  ),
  'folder' => 'migrations/',
  'table' => 'migration',
  'flush_cache' => false,
);
