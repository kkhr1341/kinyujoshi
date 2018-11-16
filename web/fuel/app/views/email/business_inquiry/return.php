<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- If you delete this tag, the sky will fall on your head -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>きんゆう女子。</title>

<!-- <link rel="stylesheet" type="text/css" href="https://irodori.fund/assets/css/irodori/email.css" /> -->

</head>
 
<body bgcolor="#FFFFFF">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#fff">
  <tr>
    <td></td>
    <td class="header container">
        <div class="content">
          <table bgcolor="#fff">
          <tr>
            <td><img src="/images/kinyu-logo.png" style="width: 200px;"></td>
          </tr>
        </table>
        </div>
    </td>
    <td></td>
  </tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap">
  <tr>
    <td></td>
    <td class="container" bgcolor="#FFFFFF">
      <div class="content">
      <table>
        <tr>
          <td>
            <h3>きんゆう女子。にお問い合わせがありました。</h3>
            <p>以下、お問い合わせ内容です。</p>

            <div class="form-mail-p">
              <p>◼お問い合わせ種別</p>
              <?php echo $category_name; ?><br>
            </div>
            <div class="form-mail-p">
              <p>◼会社名</p>
              <?php echo $company; ?><br>
            </div>
            <div class="form-mail-p">
              <p>◼部署名</p>
              <?php echo $department; ?><br>
            </div>
            <div class="form-mail-p">
              <p>◼お名前</p>
              <?php echo $name; ?><br>
            </div>
            <div class="form-mail-p">
              <p>◼︎電話番号</p>
              <?php echo $tel; ?><br>
            </div>
            <div class="form-mail-p">
              <p>◼︎メールアドレス</p>
              <?php echo $email; ?><br>
            </div>
            <div class="form-mail-p">
              <p>◼︎きんゆう女子。を知ったきっかけ</p>
              <?php echo $transmission; ?><br>
            </div>
            <div class="form-mail-p">
              <p>◼︎アポイントご希望の日時</p>
              <?php echo $appointment_date1; ?><br>
              <?php echo $appointment_date2; ?><br>
              <?php echo $appointment_date3; ?><br>
            </div>
            <div class="form-mail-p">
              <p>◼︎お問い合わせ内容</p>
              <?php echo nl2br($message); ?><br>
            </div>

            <style>
              .form-mail-p {
                margin-bottom: 30px!important;
              }
            </style>

          </td>
        </tr>
      </table>
      </div>
                  
    </td>
    <td></td>
  </tr>
</table><!-- /BODY -->


<!-- FOOTER -->
<table class="footer-wrap">
  <tr>
    <td></td>
    <td class="container">
      
        <!-- content -->
        <div class="content">
        <table>
        <tr>
          <td align="center">
            <p>
              <a href="https://kinyu-joshi.jp/">きんゆう女子。</a> |
              <a href="https://kinyu-joshi.jp/company">運営会社</a>
            </p>
          </td>
        </tr>
      </table>
        </div><!-- /content -->
        
    </td>
    <td></td>
  </tr>
</table><!-- /FOOTER -->


</body>
</html>