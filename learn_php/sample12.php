<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
<p>test</p>
<?php
  //タイムアウト時間を決める
  set_time_limit(0);

  $csv  = array();
  $file = 'test.csv';
  $fp   = fopen($file, "r");
 
  while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
    $csv[] = $data;
  }
  fclose($fp);
  //接続設定
//  $dsn = 'mysql:host=ymd;dbname=test;charset=utf8';
  $dsn = 'mysql:host=mysql520.db.sakura.ne.jp;dbname=mqttbroker_mqttbroker_sampledb;charset=utf8';

//  $user = 'test';
  $user = 'mqttbroker';
  $password = 'yamada29716';

  //SQL定義
  //$CREATE_TABLE = "CREATE TABLE jpn(zipcode text,todofuken text,shicho text,choson text,cyoume text,date text);";
  $sql_set = "INSERT INTO jpn(zipcode,todofuken,shicho,choson,cyoume,date) VALUES (:zipcode,:todofuken,:shicho,:choson,:cyoume, now())";
  
  print("<p>RaspberryPi DBへ接続します。</br>");
  try {
 
  // PDOインスタンスを生成
  $dbh = new PDO($dsn, $user, $password);
  print("接続成功");
// エラー（例外）が発生した時の処理を記述
  } catch (PDOException $e) {
 
  // エラーメッセージを表示させる
  echo '<p>データベースにアクセスできません！</p>' . $e->getMessage();
 
  // 強制終了
  exit;
 
  }
  //ここからSQLを流し込む
  $stmt = $dbh->prepare($sql_set);

  for($i=1;$i<148944;$i++){
    $params[$i] = array(':zipcode'=>$csv[$i][0],':todofuken' =>$csv[$i][1],':shicho'=>$csv[$i][2],':choson'=>$csv[$i][3],':cyoume'=>$csv[$i][4]);
	$stmt->execute($params[$i]);
  }
  $dbh = null;
  //print_r($csv)
?>
<a href="sample10.php">次へ</a>
</body>

</html>