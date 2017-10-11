<!-- 
NewArriving.php
Created by: Hodaka Kubo
Email: 22121415@student.uwa.edu.au
Date: 2017-10-11
-->

<?php
	$con = mysql_connect('localhost',"UserID","Password");
	if(!$con){
		die('Connection failed: ' . mysqli_connect_error());
	}
	mysql_select_db("Database name",$con);
	
	/* replace ' to empty space in order not to occur errors in sql.*/
	$_POST['code'] == str_replace('\'','',$_POST['code']);
	$_POST['name'] == str_replace('\'','',$_POST['name']);
	$_POST['price'] == str_replace('\'','',$_POST['price']);
	$_POST['quantity'] == str_replace('\'','',$_POST['quantity']);
	$_POST['description'] == str_replace('\'','',$_POST['description']);
	/* cut the empty space.*/
	$_POST['code'] = trim($_POST['code']);
	$_POST['name'] = trim($_POST['name']);
	$_POST['price'] = trim($_POST['price']);
	$_POST['quantity'] = trim($_POST['quantity']);
	$_POST['description'] = trim($_POST['description']);
	/*convert 「''」 to 「NULL」 (isset('')==true, isset(null)==false)*/
	if($_POST['code'] == ''){$_POST['code'] = null;}
	if($_POST['name'] == ''){$_POST['name'] = null;}
	if($_POST['price'] == ''){$_POST['price'] = null;}
	if($_POST['quantity'] == ''){$_POST['quantity'] = null;}
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$activate = true;
	}else{
		$activate = false;
	}

	if(appropriatelyFilled()){
		$insert = "insert into Products (Code, Name, Price, Quantity, description) values ('$_POST[code]','$_POST[name]','$_POST[price]','$_POST[quantity]','$_POST[description]');";
		if (!mysql_query($insert,$con)) {
			die('Error: ' . mysql_error());
		}
	}
	$resultPro = mysql_query("select * from Products");
	
	function appropriatelyFilled(){
		$judge = $_SERVER['REQUEST_METHOD']=='POST' 
					&& isset($_POST['code']) 
					&& isset($_POST['name']) 
					&& isset($_POST['price']) 
					&& isset($_POST['quantity'])
					&& is_numeric($_POST['code'])
					&& is_numeric($_POST['price'])
					&& is_numeric($_POST['quantity'])
					&& ($_POST['quantity'] > 0)
					&& ($_POST['price'] > 0)
					&& (strlen($_POST['description']) < 101);
		return $judge;
	}
	
	function failedText(){
		$ans = '';
		if(!isset($_POST['code'])){$ans = $ans . 'Code is not given.</br>';}
		elseif(!is_numeric($_POST['code'])){$ans = $ans . 'Code is not appropriate.</br>';}
		
		if(!isset($_POST['name'])){$ans = $ans . 'Name is not given.</br>';}
		
		if(!isset($_POST['price'])){$ans = $ans . 'Price is not given.</br>';}
		elseif(!is_numeric($_POST['price']) || ($_POST['price'] <= 0)){$ans = $ans . 'Price is not appropriate.</br>';}
		
		if(!isset($_POST['quantity'])){$ans = $ans . 'Quantity is not given.</br>';}
		elseif(!is_numeric($_POST['quantity']) || ($_POST['quantity'] <= 0)){$ans = $ans . 'Quantity is not appropriate.</br>';}
		
		return $ans;
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>New Arriving</title>
<style>
	body {
	  font-family: Verdana, sans-serif;
	  font-size: 16px;
	  background: #e0e0e0;
	}
	h1{
		text-align: center;
	}
	h1.stocks{
		text-align: center;
		margin: 30px 0 20px;
	}
	form{
		background: #fff;
		padding: 20px;
		border-radius: 10px;
		margin: 0 auto 20px ;
		width: 400px;
	}
	#message{
		text-align: center;
		margin: 14px auto;
	}
	a.successed{color: lime;}
	a.failed{color: red;}
	
	input[type="text"]{
		border: solid 1px #ccc;
		border-radius: 5px;
		text-align: right;
		height: 30px;
		width:140px;
		margin: 5px 0;
		padding: 5px 7px;
		font-size: 16px;
	}

	p{
		margin: 0;
	}
	textarea {
		width: 350px;
		height: 100px;
		padding: 14px;
		box-sizing: border-box;
		font-size: 16px;
		border: solid 1px #ccc;
		border-radius: 5px;
		line-height: 1.3;
		margin: 10px 30px 0px;
	}
	textarea:focus {
		outline: none;
	}
	.warning {
		color: red;
		font-size: 20px;
		font-weight: bold;
	}
	.submit{
		text-align:center;
		margin-top:20px;
	}
	#btn {
		display: inline-block;
		width: 150px;
		margin: 0 auto;
		background: #00aaff;
		padding: 5px;
		font-size:16px;
		color: #fff;
		border-radius: 5px;
		text-align: center;
		cursor: pointer;
		box-shadow: 0 4px 0 #0088cc;
		border: none;
		opacity: 1;
	}
	#btn.notactive{opacity: 0.5;}
	
	table.products{
		width:800px;
		margin: 10px auto;
		border: 1px solid #ccc;
		border-radius: 10px;
		background: #fff;
		padding: 20px;
		border-spacing:0 0;
	}
	table.products tr{height: 40px;}
	table.products tr:nth-child(even){background-color: rgba(38, 255, 5, 0.76);}
	table.products td{padding:3px 5px;}
	table.products td.id{text-align: right;}
	table.products td.code{text-align: right;}
	table.products td.name{text-align: right;}
	table.products td.price{text-align: right;}
	table.products td.quantity{text-align: right;}
	table.products td.description{padding-left: 20px;}
	table.products th,table.products td{border-bottom: 1px solid #ddd;}
</style>
</head>
<body>
	<div class='container'>
		<h1>Register New Arrivals</h1>
		<div id='form'>
			<form action="" method="post">
				<div id='message'>
					<?php if(appropriatelyFilled()):?>
						<a class='successed'>Successfully added to the list!</a>
					<?php elseif($activate):?>
						<a class='failed'>Failed to add the list.</br>
							<?php echo failedText();?>
						</a>
					<?php endif;?>
				</div>
				<table class='form'>
					<tr>
						<td style='width:130px;height:20px;'>Code:</td>
						<td>&nbsp;&nbsp;<input type="text" name="code" id="code" placeholder="0000"></td></tr>
					<tr>
						<td style='width:130px;height:20px;'>Name:</td>
						<td>&nbsp;&nbsp;<input type="text" name="name" id="name" placeholder="Product1"></td>
					</tr>
					<tr>
						<td style='width:130px;height:20px;'>Price:</td>
						<td>$<input type="text" name="price" id="price" placeholder="130"></td>
					</tr>
					<tr>
						<td style='width:130px;height:20px;'>Quantity:</td>
						<td>&nbsp;&nbsp;<input type="text" name="quantity" id="quantity" placeholder="1"></td>
					</tr>
					<tr>
						<td style='width:130px;padding-top:10px;'>Description:</td>
					</tr>
					<tr>
						<td colspan='2'>
						<textarea type="text" name="description" id="description" placeholder="Description of this product"></textarea>
						</td>
					</tr>
					<tr><td colspan='2'><p style='text-align: right;'><span id="label"></span> characters left</p></td></tr>
				</table>
				<div class="submit"><input type="submit" name="post" id="btn" class=""></div>
			</form>
		</div>
		<h1 class='stocks'>Current Stocks</h1>
		<div id='table'>
			<table class='products'>
				<tr>
					<th>ID</th>
					<th>Code</th>
					<th>Name</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Description</th>
				</tr>
				<?php while($row = mysql_fetch_array($resultPro)){
					echo "<tr>";
					echo "<td class='id'>" . $row['id'] . "</th>";
					echo "<td class='code'>" . $row['Code'] . "</th>";
					echo "<td class='name'>" . $row['Name'] . "</th>";
					echo "<td class='price'>" . $row['Price'] . "</th>";
					echo "<td class='quantity'>" . $row['Quantity'] . "</th>";
					echo "<td class='description'>" . $row['Description'] . "</th>";
					echo "</tr>";
					}
				?>
			</table>
		</div>
	</div>
</body>
<script>
(function(){
	'use strict';
	var label   = document.getElementById('label');
	var description = document.getElementById('description');
	var btn = document.getElementById('btn');
	
	var LIMIT = 100;
	var WARNING = 20;

	label.innerHTML = LIMIT;

	description.addEventListener('keyup', function() {
		var remaining = LIMIT - this.value.length;
		label.innerHTML = remaining;
		label.className = remaining < WARNING ? 'warning' : '';
	});

	
})();
</script>
</html>