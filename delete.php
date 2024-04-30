
<?php

try {

    $user = "root";
    $password = "root";

    $dbh = new PDO("mysql:host=localhost; dbname=bbs; charset=utf8", "$user", "$password");

    $stmt = $dbh->prepare('DELETE FROM comments WHERE id = :id');

    $stmt->execute(array(':id' => $_GET["id"]));

    echo "削除しました。";

} catch (Exception $e) {
          echo 'エラーが発生しました。:' . $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>削除完了</title>
  </head>
  <body>          
  <p>
      <a href="show.php?id=<?php echo $_GET['id'] ?>">投稿詳細へ</a>
  </p> 
  </body>
</html>
