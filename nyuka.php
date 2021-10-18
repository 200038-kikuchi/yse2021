<?php
/* 
【機能】
書籍の入荷数を指定する。確定ボタンを押すことで確認画面へ入荷個数を引き継いで遷移す
る。なお、在庫数は各書籍100冊を最大在庫数とする。
【エラー一覧（エラー表示：発生条件）】
このフィールドを入力して下さい(吹き出し)：入荷個数が未入力
最大在庫数を超える数は入力できません：現在の在庫数と入荷の個数を足した値が最大在庫数を超えている
数値以外が入力されています：入力された値に数字以外の文字が含まれている
*/

/*
 * ①session_status()の結果が「PHP_SESSION_NONE」と一致するか判定する。
 * 一致した場合はif文の中に入る。
 */
if (session_status()==PHP_SESSION_NONE) {
	session_start();
}
if (!$_SESSION["login"]){
	$_SESSION["error2"]="ログインしてください";
	header("Location:login.php");
}

$db_name="zaiko2021_yse";
$db_host="localhost";
$db_port="3306";
$db_user="zaiko2021_yse";
$db_password="2021zaiko";
$dsn = "mysql:dbname={$db_name};host={$db_host};charset=utf8;port={$db_port}";
try{
	$pdo = new PDO($dsn,$user,$pass);
}catch(PDOException $e){
	echo "接続エラー";
}

if(empty($_POST["books"])){
	$_SESSION["success"] ="入荷する商品が選択されていません";
	header("Location:zaiko_ichiran.php");
}

function getId($id,$con){
	$sql = "SELECT * FROM books WHERE id ={$id}";
	$stmt = $con->queli($sql);
	$stmt->execute(["id" => $id]);
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>入荷</title>
	<link rel="stylesheet" href="css/ichiran.css" type="text/css" />
</head>
<body>
	<div id="header">
		<h1>入荷</h1>
	</div>
	<div id="menu">
		<nav>
			<ul>
				<li><a href="zaiko_ichiran.php?page=1">書籍一覧</a></li>
			</ul>
		</nav>
	</div>

	<form action="nyuka_kakunin.php" method="post">
		<div id="pagebody">
			<div id="error">
			<?php
			if(isset($_SESSION["error"])){
				echo '<p>'.$_SESSION["error"].'</p>';
				$_SESSION["error"]="";

			}
			?>
			</div>
			<div id="center">
				<table>
					<thead>
						<tr>
							<th id="id">ID</th>
							<th id="book_name">書籍名</th>
							<th id="author">著者名</th>
							<th id="salesDate">発売日</th>
							<th id="itemPrice">金額(円)</th>
							<th id="stock">在庫数</th>
							<th id="in">入荷数</th>
						</tr>
					</thead>
					<?php 
    				foreach($_POST["books"] as $id){

						$book = getId($id,$pdo);
					?>
					<input type="hidden" value="<?php echo	$book["id"];?>" name="books[]">
					<tr>
						<td><?php echo	$book["id"];?></td>
						<td><?php echo	$book["title"];?></td>
						<td><?php echo	$book["author"];?></td>
						<td><?php echo	$book["salesDate"];?></td>
						<td><?php echo	$book["price"];?></td>
						<td><?php echo	$book["stock"];?></td>
						<td><input type='text' name='stock[]' size='5' maxlength='11' required></td>
					</tr>
					<?php
					 }
					?>
				</table>
				<button type="submit" id="kakutei" formmethod="POST" name="decision" value="1">確定</button>
			</div>
		</div>
	</form>
	<div id="footer">
		<footer>株式会社アクロイト</footer>
	</div>
</body>
</html>