<?php
define('DB_HOST',       getenv('DB_HOST'));
define('DB_NAME',       getenv('DB_NAME'));
define('DB_USER',       getenv('DB_USER'));
define('DB_PASSWORD',   getenv('DB_PASSWORD'));

$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
<html>

<body>
  <div style="background-color:#FFAAFF">
    ルームに入室
    <form action="room.php" method="post">
      <select name="room">
        <option value="room1">ROOM1</option>
        <option value="room2">ROOM2</option>
        <option value="room3">ROOM3</option>
      </select>
      <input type="submit" value="移動"/>
    </form>
  </div>
  
  
  <div style="background-color:#FFAAFF">
    個人チャット
    <form action="private.php" method="post">
      自分の名前<input type="text" name="name"> <br>
      相手の名前<input type="text" name="target"> <br>
      <input type="submit" value="移動"/>
    </form>
  </div>

</body>
</html>