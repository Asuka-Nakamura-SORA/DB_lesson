<?php
  // DB接続
  $dsn = 'mysql:host=localhost;dbname=bbs;charset=utf8';
  $user = 'root';
  $password = 'root';
  $db = new PDO($dsn, $user, $password);

  // URLからidの値を取得
  $postId = $_GET['id'];

  $sql = "SELECT * FROM messages WHERE id = " . $postId;
  $stmt = $db->prepare($sql);
  $stmt->execute();

  //投稿データを保存する箱
  $postbox = [];
  
  //レコード取得
  $row = $stmt->fetch();
  $postbox[] = [
    'id' => $row['id'],
    'title' => $row['title'],
    'body' => $row['body']
  ];

  if(isset($_POST['body'])) {
    $body = $_POST['body'];

    //条件をチェックする
    if(empty($_POST['body'])){
        echo $alert = "<script type='text/javascript'>alert('コメントを記入してください。');</script>";

    }elseif(strlen($_POST['body']) > 50){
        echo $alert = "<script type='text/javascript'>alert('コメントは50文字以下で記入してください');</script>";
        
    }else{
      $stmt = $db->prepare("INSERT INTO comments (message_id, body, date) VALUES (:message_id, :body, now())");
      $stmt->bindParam(':message_id', $postId, PDO::PARAM_STR);
      $stmt->bindParam(':body', $body, PDO::PARAM_STR);
      $stmt->execute();
      header("Location:show.php?id=$postId");
      exit();
    }
  }

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>show</title>
</head>
<body>

<p>タイトル</p>
<?php echo $row['title']?>
<p>内容</p>
<?php echo $row['body']?>
<p>投稿日時：<?php echo $row['date']?></p>
<p><a href="write.php">一覧に戻る</a></p>

<div class="comment_confirmation">
  <p class="modal_title" >この投稿にコメントしますか？</p>
  <form method="post" action="show.php?id=<?php echo $postId; ?>">
    <textarea class="textarea" name="body"></textarea>
    <div class="post_btn">
      <button class="btn btn-outline-danger" type="submit" name="comment" value="comment">コメント</button>
    </div>
  </form>
  <?php
    //コメント表示
    $sql = "SELECT id,body FROM comments WHERE message_id = :postId";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
    $stmt->execute();
   
    //投稿データを保存する箱
    $commentbox = [];
    //レコード取得
    while($row = $stmt->fetch()):
      $commentbox[] = [
        'body' => $row['body']
      ];
  ?>
    <p>コメント：<?php echo nl2br($row['body'])?><a href="delete.php?id=<?php echo $_GET['id'] ?>">削除</a>
    <?php
    endwhile;
  ?>
</div>
</body>
</html>
