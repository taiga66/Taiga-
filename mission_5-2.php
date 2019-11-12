<html>
<head>
	<meta charset="utf-8">
	<title>mission5-1</title>
</head>

<body>
	<p><font size="6" >あなたの出身地を教えてください！</font></p>

	<?php   //データベース接続
		$dsn = 'データベース名';
		$user = 'ユーザー名';
		$password = 'パスワード';
		$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

		//テーブル作成
		$sql = "CREATE TABLE IF NOT EXISTS kinggnu"
			." ("
			. "id INT AUTO_INCREMENT PRIMARY KEY,"
			. "name char(32),"
			. "comment TEXT,"
			. "password VARCHAR(20),"
			. "date VARCHAR(40)"
			.");";
		$stmt = $pdo->query($sql);

		//入力フォーム 
	if    (empty($_POST['data'])==false && empty($_POST['data2'])==false  && empty($_POST['edit2']) && empty($_POST['password'])==false){  
		$sql = $pdo -> prepare("INSERT INTO kinggnu(name,comment,password,date)VALUES(:name,:comment,:password,:date)");
		$sql -> bindParam(':name',$name,PDO::PARAM_STR);
		$sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
		$sql -> bindParam(':password',$password,PDO::PARAM_STR);
		$sql -> bindParam(':date',$date,PDO::PARAM_STR);
		$name = $_POST['data'];
		$comment = $_POST['data2'];
		$password = $_POST['password'];
		$date = date('Y/m/d H:i:s');
		$sql -> execute();
	}

		//削除フォーム
	if   (empty($_POST['delete'])==false && empty($_POST['password2'])==false){
		$sql = 'SELECT * FROM kinggnu';//データ選択
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			if   ($row['password'] == $_POST['password2']){   //削除実行
				$id = $_POST['delete'];
				$sql = 'delete from kinggnu where id=:id';
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				$stmt->execute();
			}
		}
	}

		//編集フォーム
		//編集番号指定
	if   (empty($_POST["edit"])==false){
		$sql = 'SELECT * FROM kinggnu';//データ選択
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			if   ($row['id'] == $_POST["edit"] && $row['password'] == $_POST['password3']){ 
				$number = $row['id'];
				$newname = $row['name'];
				$newcoment = $row['comment'];
				$newpassword = $row['password'];
				echo "編集対象:" , $number," ",$newname," ",$newcoment;
			}
		}
	}
		//編集実行
	if    (empty($_POST['edit2'])==false){ 
		$sql = 'SELECT * FROM kinggnu';//データ選択
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			if   ($row['id'] == $_POST['edit2']){   
				$id = $_POST['edit2']; 
				$name = $_POST['data'];
				$comment = $_POST['data2'];
				$date = date('Y/m/d H:i:s');
				$sql = 'update kinggnu set name=:name,comment=:comment,date=:date where id=:id';
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':name', $name, PDO::PARAM_STR);
				$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
				$stmt->bindParam(':date',$date,PDO::PARAM_STR);
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				$stmt->execute();
			}
		}
	}
	?>	

 <form  action="mission_5-1.php"  method="POST">
       <font size="5" color="#0000ff">入力フォーム</font>
       <input type="hidden" name="edit2" value="<?php if (empty($number)){}else {echo $number;} ?>" ></br>
   名前　　　
       <input type="text" name="data" value="<?php if (empty($newname)){}else {echo $newname;} ?>" ></br>
   都道府県名
       <input type="text" name="data2" value="<?php if (empty($newcoment)){}else {echo $newcoment;} ?>" ></br>
   パスワード
       <input type="password" name="password" value="<?php if (empty($newpassword)){}else {echo $newpassword;} ?>"></br>
       <input type="submit" value="送信"></br>


       <font size="5" color="#0000ff">削除フォーム</font></br>
   削除対象番号
       <input type="text" name="delete" ></br>
   パスワード　
       <input type="password" name="password2" ></br>
       <input type="submit" value="削除"></br>


       <font size="5" color="#0000ff">編集フォーム</font></br>
   編集対象番号
       <input type="text" name="edit" ></br>
   パスワード　
       <input type="password" name="password3" ></br>
       <input type="submit" value="編集"></br>
 </form>
       <font size="5">みんなの出身地</font></br>
	<?php   //データベース接続
		$dsn = 'データベース名';
		$user = 'ユーザー名';
		$password = 'パスワード';
		$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
		
		//データ表示
		$sql = 'SELECT * FROM kinggnu'; //データ選択
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){   //表示
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].',';
			echo $row['date'].'<br>';
			echo "<hr>";
			}
	?>

</body>
</html>