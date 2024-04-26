<?php
 //DSNとユーザー名.パスワードを指定
  $dsn = 'mysql:host=localhost;dbname=bbs;charset=utf8';
  $user = 'root';
  $password = 'root';
  $db = new PDO($dsn, $user, $password);

  if(isset($_POST['title'], $_POST['body'])) {

    $title = $_POST['title'];
    $body = $_POST['body'];

    //条件をチェックする
    if(empty($_POST['title']) and empty($_POST['body'])){
        echo $alert = "<script type='text/javascript'>alert('タイトルと内容を記入してください。');</script>";

    }elseif(empty($_POST['title'])){
        echo $alert = "<script type='text/javascript'>alert('タイトルを記入してください。');</script>";

    }elseif(empty($_POST['body'])){
        echo $alert = "<script type='text/javascript'>alert('内容を記入してください。');</script>";

    }elseif(strlen($_POST['title']) > 30){
        echo $alert = "<script type='text/javascript'>alert('タイトルは30文字以下で記入してください');</script>";
        
    }else{
  
    //プリペアドステートメント
    $stmt = $db->prepare("INSERT INTO messages (title, body, date) VALUES (:title, :body, now())");
  
    //変数埋め込み
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':body', $body, PDO::PARAM_STR);
    
    //実行
    $stmt->execute();
  

  header('Location: write.php');
    exit();
  }
  }
?>

<html>
  <meta charset="UTF-8" />
  <title>掲示板</title>
  <body>
    <h1>ニューーーーーーーす！！！！！</h1>
    <form action="write.php" method="post">
      <p>タイトル</p>
      <p><input type="text" name="title"></p>
      <p>内容</p>
      <p><textarea name="body" cols="50" rows="5"></textarea></p>
      <p><input type="submit" value="投稿"></p>
    </form>
  </body>
</html>

<?php
  $dsn = 'mysql:host=localhost;dbname=bbs;charset=utf8';
  $user = 'root';
  $password = 'root';

  $db = new PDO($dsn, $user, $password);
  $stmt = $db->prepare("SELECT*FROM messages ORDER BY date DESC");
  $stmt->execute();

  //投稿データを保存する箱
  $postbox = [];

  //レコード取得
  while ($row = $stmt->fetch()):
    $postbox[] = [
      'id' => $row['id'],
      'title' => $row['title'],
      'body' => $row['body']
    ];
?>

  <p>タイトル：<?php echo $row['title'] ?></p>
  <p>内容：<?php echo nl2br($row['body'], false) ?></p>
  <p><?php echo $row['date'] ?></p>
  
  <p><a href="show.php?id=<?php echo $row['id'] ?>">記事全文・コメントを読む<BR><BR></a><br /></p>
    
<?php
  endwhile;
?>