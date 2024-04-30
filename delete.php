<?php

  $user = "root";
  $password = "root";
  $dbh = new PDO("mysql:host=localhost; dbname=bbs; charset=utf8", "$user", "$password");

  $id = $_GET['id'];
  $stmt = $dbh->prepare("SELECT message_id FROM comments WHERE id = :id");
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();

    //レコード取得
  $row = $stmt->fetch();
  

  $stmt = $dbh->prepare("DELETE FROM comments WHERE id = :id");
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  echo "削除しました。";

  // $stmt = $dbh->prepare('DELETE FROM comments WHERE id = :id');
  // $stmt->execute(array(':id' => $_GET["id"]));
  // echo "削除しました。";



  // $stmt = $db->prepare("SELECT id,body FROM comments WHERE message_id = :postId");
  // $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
  // $stmt->execute();


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>削除完了</title>
  </head>
  <body>          
  <p>
      <a href="show.php?id=<?php echo $row['message_id']; ?>">投稿詳細へ</a>
  </p> 
  </body>
</html>
