<!doctype html>
<html lang= "ja"> 
<head>
<title>くそむず掲示板</title>
</head>
<body>
<meta charset= "utf-8">
  <form action ="#"  method= "post">

<?php


$dsn = 'データベース';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$sql = "CREATE TABLE IF NOT EXISTS tbtest"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."pass TEXT"
.");";
$stmt = $pdo->query($sql);

?>

<p>
<input type = "hidden" name = "bango" value = '<?php 
if(!empty($_POST["update"]) and !empty($_POST["pass"])){
$id = $_POST["update"];
$pass = $_POST["pass"];
$sql = "SELECT * FROM tbtest";
$stmt = $pdo->query($sql);
$results = $stmt->fetchALL();
foreach($results as $row){
if($id == $row["id"] and $pass = $row["pass"]){
echo $row["id"];
}
}
}
?>'>
</p>
<p>名前:   
<input type= "text" name = "name"  value = '<?php 
if(!empty($_POST["update"]) and !empty($_POST["pass"])){
$id = $_POST["update"];
$pass = $_POST["pass"];
$sql = "SELECT * FROM tbtest";
$stmt = $pdo->query($sql);
$results = $stmt->fetchALL();
foreach($results as $row){
if($id == $row["id"] and $pass == $row["pass"]){
echo $row["name"];
}
}
}
?>'>
</p>
<p>
コメント:
<input type = "text" name = "comment" value = '<?php 
if(!empty($_POST["update"]) and !empty($_POST["pass"])){
$id = $_POST["update"];
$pass = $_POST["pass"];
$sql = "SELECT * FROM tbtest";
$stmt = $pdo->query($sql);
$results = $stmt->fetchALL();
foreach($results as $row){
if($id == $row["id"] and $pass == $row["pass"]){
echo $row["comment"];
}
}
}
?>'>
</p>
<p>
パスワード:
<input type = "text" name ="pao" >
</p>
<p>
<input type = "submit" value = "送信">
</p>
<p>
削除番号:
<input type = "text" name = "delete">
</p>
<p>
パスワード:
<input type = "text" name ="pas" >
</p>
<p>
<input type = "submit" value = "削除">
</p>
<p>
編集番号:
<input type = "text" name = "update">
</p>
<p>
パスワード:
<input type = "text" name ="pass" >
</p>
<p>
<input type = "submit" value = "編集">
</p>
<br>


</body>
</html>


<?php

//投稿機能　条件分岐
if(!empty($_POST["name"]) and !empty($_POST["comment"]) and !empty($_POST["pao"]) and empty($_POST["bango"]) ){
//受け取った値の入力
$sql = $pdo->prepare("INSERT into tbtest(name,comment,pass) VALUES(:name,:comment,:pass) ");
$sql -> bindParam(':name',$name,PDO::PARAM_STR);
$sql-> bindParam(':comment',$comment,PDO::PARAM_STR);
$sql-> bindParam(':pass',$pass,PDO::PARAM_STR);
$name = $_POST["name"];
$comment = $_POST["comment"];
$pass = $_POST["pao"];
$sql->execute();


}

//削除機能　条件分岐
if(!empty($_POST["delete"]) and !empty($_POST["pas"])){
$id = $_POST["delete"];
$pass = $_POST["pas"];

$sql = "SELECT * FROM tbtest";
$stmt = $pdo->query($sql);
$results = $stmt->fetchALL();
foreach($results as $row){
if($pass == $row["pass"]){

//受け取った値と同じ番号の投稿を削除

$sql = "delete from tbtest where id= :id";
$stmt = $pdo->prepare($sql);
$stmt ->bindParam(":id", $id,PDO::PARAM_INT);
$stmt->execute();
}
}
}

//編集機能　条件分岐
if(!empty($_POST["name"]) and !empty($_POST["comment"]) and !empty($_POST["bango"]) and !empty($_POST["pass"])){

$name =  $_POST["name"];
$comment = $_POST["comment"];
$pass = $_POST["pass"];
$id = $_POST["bango"];
$sql = "update tbtest set name = :name , comment = :comment , pass = :pass  where id = :id ";
$stmt= $pdo->prepare($sql);
$stmt-> bindParam(":name", $name, PDO::PARAM_STR);
$stmt-> bindParam(":comment", $comment, PDO::PARAM_STR);
$stmt-> bindParam(":id", $id, PDO::PARAM_INT);
$stmt-> bindParam(":pass", $pass, PDO::PARAM_STR);
$stmt ->execute();
}
//受け取った値の表示
$sql = "SELECT * FROM tbtest";
$stmt = $pdo->query($sql);
$results = $stmt->fetchALL();
foreach($results as $row){
echo $row["id"].',';
echo $row["name"].',';
echo $row["comment"].',';
echo $row["pass"].'<br>';

echo "<hr>";
}


?>
