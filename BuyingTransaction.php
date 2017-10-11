<!-- 
BuyingTransaction.php
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
	$_POST['quantity'] = str_replace('\'','',$_POST['quantity']);
	$_POST['firstname'] = str_replace('\'','',$_POST['firstname']);
	$_POST['lastname'] = str_replace('\'','',$_POST['lastname']);
	$_POST['phone'] = str_replace('\'','',$_POST['phone']);
	$_POST['address'] = str_replace('\'','',$_POST['address']);
	/* cut the empty space.*/
	$_POST['quantity'] = trim($_POST['quantity']);
	$_POST['firstname'] = trim($_POST['firstname']);
	$_POST['lastname'] = trim($_POST['lastname']);
	$_POST['phone'] = trim($_POST['phone']);
	$_POST['address'] = trim($_POST['address']);
	/*convert '' to NULL because (isset('')==true, isset(null)==false)*/
	if($_POST['quantity'] == ''){$_POST['quantity'] = null;}
	if($_POST['firstname'] == ''){$_POST['firstname'] = null;}
	if($_POST['lastname'] == ''){$_POST['lastname'] = null;}
	if($_POST['phone'] == ''){$_POST['phone'] = null;}
	if($_POST['address'] == ''){$_POST['address'] = null;}
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$activate = true;
	}else{
		$activate = false;
	}
	
	if(judgeCorrect()){
		$price = culculatePrice();
		
		$insert = "insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity, Price) values 
					('$_POST[firstname]','$_POST[lastname]','$_POST[phone]','$_POST[address]','$_POST[id]','$_POST[quantity]','$price');";
		if (!mysql_query($insert,$con)) {die('Error: ' . mysql_error());}
		
		$update = "update Products set Quantity = Quantity - ". $_POST['quantity'] ." where id = ". $_POST['id'] .";";
		if (!mysql_query($update)) {die('Error: ' . mysql_error());}
		
		$delete = "delete from Products where Quantity = 0;";
		if (!mysql_query($delete)) {die('Error: ' . mysql_error());}
	}
	
	/* This function calculates the price once the submit button is clicked.*/
	function culculatePrice(){
		$array = [];
		$resultPro = mysql_query("select * from Products");
		while($row = mysql_fetch_array($resultPro)){
			$array[$row['id']] = $row['Price'];
		}
		$ans = $_POST[quantity] * $array[$_POST[id]];
		return $ans;
	}
	
	/* This function checks whether the given information is correct or not.*/
	/* $array is the map of ID and Quantity of all products in the database. */
	function judgeCorrect(){
		$array = [];
		$resultPro = mysql_query("select * from Products");
		while($row = mysql_fetch_array($resultPro)){
			$array[$row['id']] = $row['Quantity'];
		}
		$judge = $_SERVER['REQUEST_METHOD']=='POST'
					&& isset($_POST['firstname']) 
					&& isset($_POST['lastname']) 
					&& isset($_POST['phone']) 
					&& isset($_POST['address']) 
					&& isset($_POST['quantity'])
					&& is_numeric($_POST['phone'])
					&& (strlen($_POST['phone']) <= 10)
					&& ($_POST['quantity'] > 0)
					&& ($_POST['id'] != '0' && $_POST['id'] != null) 
					&& ($_POST['quantity'] <= $array[$_POST['id']]);
		return $judge;
	}
	
	/* successText() returns a string of message */
	function successText(){
		return "Name: ".$_POST['firstname']." ".$_POST['lastname']."</br>ProductID: "
			.$_POST['id']."</br>Quantity: ".$_POST['quantity']."</br>Price: $".culculatePrice();
	}
	
	/* failedText() returns a string of message */
	function failedText(){
		$ans = 'Failed to add the list.</br>';
		if(!isset($_POST['firstname'])){$ans = $ans . 'Firstname is not given.</br>';}
		if(!isset($_POST['lastname'])){$ans = $ans . 'Lastname is not given.</br>';}
		
		if(!isset($_POST['phone'])){$ans = $ans . 'Phone number is not given.</br>';}
		elseif(!is_numeric($_POST['phone'])){$ans = $ans . 'Phone number is not appropriate.</br>';}
		elseif(strlen($_POST['phone']) >= 10){$ans = $ans . 'Phone number is at most 10 digits.</br>';}
		
		if(!isset($_POST['address'])){$ans = $ans . 'Address is not given.</br>';}
		if($_POST['id'] == '0' || $_POST['id'] == null){$ans = $ans . 'Select ID.';}
		
		if(!isset($_POST['quantity'])){$ans = $ans . 'Quantity is not given.</br>';}
		else if(($_POST['quantity'] <= $array[$_POST['id']]) || ($_POST['quantity'] <= 0)){$ans = $ans . 'Quantity is not appropriate.';}
		
		return $ans;
	}
	
	$resultPro = mysql_query("select * from Products");
	$resultOrd = mysql_query("select * from Orders");

?>
<!DOCTYPE html>
<html>
<head>
<title>BuyingTransaction</title>
<style>

	body {
		font-family: Verdana, sans-serif;
		font-size: 16px;
		background: #eee;
	}
	.container{
		width: 800px;
		margin: 20px auto;
	}
	
	h1{
		text-align: center;
		margin: 30px 0 20px;
	}
	div.instruction{
		width: 500px;
		margin: 30px auto;
	}
	div.message{
		text-align: center;
		font-size: 16px;
	}
	div.message.succeeded{color: lime;}
	div.message.failed{color: red;}
	form{
		background: #fff;
		padding: 20px;
		border-radius: 10px;
		margin: 0 auto 20px ;
	}
	[type="text"]{
		border: solid 1px #ccc;
		border-radius: 5px;
		text-align: right;
		height: 30px;
		width:140px;
		margin: 5px 0;
		padding: 5px 7px;
		font-size: 16px;
	}
	
	table.main{
		margin: 10px auto;
		border: 1px solid #ccc;
		border-radius: 10px;
		background: #fff;
		padding: 20px;
		border-spacing:0 0;
		font-size: 14px;
	}
	table.main tr{height: 30px;}
	table.main tr:nth-child(even){background-color: rgba(38, 255, 5, 1);}
	table.main td{padding:2px 5px;}
	table.main th,table.products td{border-bottom: 1px solid #ddd;}
	table.main.products{width:1000px;}
	table.whatToBuy{
		width: 500px;
		margin: 20px auto;
	}
	
	#format{
		width: 400px;
		margin: 20px auto;
	}
	td.right{text-align: right; padding: 0 10px;}
	td.center{text-align: center; padding: 0 10px;}
	td.left{text-align: left; padding: 0 10px;}
	#btn {
		display: inline-block;
		width: 150px;
		height: 40px;
		margin: 10px auto;
		background: #00aaff;
		padding: 5px;
		font-size:20px;
		font-weight: 400;
		color: #fff;
		border-radius: 5px;
		text-align: center;
		cursor: pointer;
		box-shadow: 0 4px 0 #0088cc;
		border: none;
	}

	p.label{
		font-size: 24px;
		font-weight: 500;
		width: 200px;
		margin:30px auto 30px 0px;
	}

</style>
</head>
<body>
	<div class='container'>
		<div class='purchase'>
			<h1>BuyingTransaction</h1>
			<form action="" method="post">
				<?php if(judgeCorrect()):?>
					<div class='message succeeded'>
						Your order has successfully added to the table.</br></br>
						<?php echo successText();?>
					</div>
				<?php elseif(!judgeCorrect() && $activate):?>
					<div class='message failed'>
						
						<?php echo failedText();?>
					</div>
				<?php endif;?>
				<div class='instruction'>
					<h3>Instruction</h3>
					<a>Select the ID of the product you purchase in the table below and fill in your name, 
						phone number and home address and click the submit button.</a>
				</div>
				<table class='main products.'>
					<tr>
						<th>ID</th>
						<th>Code</th>
						<th>Name</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Description</th>
					</tr>
					<?php 
						while($row = mysql_fetch_array($resultPro)){
						echo "<tr>";
						echo "<td class='right'>" . $row['id'] . "</td>";
						echo "<td class='right'>" . $row['Code'] . "</td>";
						echo "<td class='center'>" . $row['Name'] . "</td>";
						echo "<td class='right'>" ."$". $row['Price'] . "</td>";
						echo "<td class='right'>" . $row['Quantity'] . "</td>";
						echo "<td>" . $row['Description'] . "</td>";
						echo "</tr>";
						}
					?>
				</table>
				<table class='whatToBuy'>
					<tr>
						<td class='right'>ID:<select name='id' id="selection">
							<option value='0'></option>
							<?php 
								$resultPro = mysql_query("select * from Products");
								while($row = mysql_fetch_array($resultPro)){
									echo "<option value='".$row['id']."'>" . $row['id'] . "</option>";
								}
							?>
						</select></td>
						<td class='left'>Quantity:<input type='text' name='quantity' id="quantity"></td>
					</tr>
				</table>
				<table id='format'>
					<tr>
						<td class='right'>Firstname:</td>
						<td class='left'><input type="text" name="firstname" placeholder="John"></td>
					</tr>
					<tr>
						<td class='right'>Lastname:</td>
						<td class='left'><input type="text" name="lastname" placeholder="Smith"></td>
					</tr>
					<tr>
						<td class='right'>Phone:</td>
						<td class='left'><input type="text" name="phone" placeholder="0401234567"></td>
					</tr>	
						<td class='right'>Address:</td>
						<td class='left'><input type="text" name="address" style='width: 300px;' 
													placeholder=" 35 Stirling Highway Perth WA 6009"></td>
					</tr>
					</tr>	
						<td class='right'>Price:</td>
						<td class='right'><p class='label'>$<span id="label">0</span></p></td>
					</tr>
					<tr>
						<td colspan='2' class='center'><input type="submit" name="post" id='btn'></td>
					</tr>

				</table>
			</form>
		</div>
	</div>
	
<!--	
	<h2 style='text-align:center;'>Order List</h2>
	<div class='orders'>
		<table class='main orders'>
			<tr>
				<th>ID</th>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Phone</th>
				<th>Address</th>
				<th>ProductID</th>
				<th>Quantity</th>
				<th>Price</th>
			</tr>
		<?php /*while($row = mysql_fetch_array($resultOrd)){
				echo "<tr>";
				echo "<td>" . $row['id'] . "</td>";
				echo "<td>" . $row['Firstname'] . "</td>";
				echo "<td>" . $row['Lastname'] . "</td>";
				echo "<td>" . $row['Phone'] . "</td>";
				echo "<td>" . $row['Address'] . "</td>";
				echo "<td class='right'>" . $row['ProductID'] . "</td>";
				echo "<td class='right'>" . $row['Quantity'] . "</td>";
				echo "<td class='right'>" . "$". $row['Price'] . "</td>";
				echo "</tr>";
				}
			*/?>
		</table>
	</div>
-->
	
	
</body>
<script>
(function(){
	var selection = document.getElementById('selection');
	var quantity = document.getElementById('quantity');
	var label = document.getElementById('label');
	
	/* map[] contains pairs of ID and Quantity of products in the database; */
	var map = new Map();
	
	/* map[] contains pairs of ID and Price of products in the database; */
	var map2 = new Map();
	
	<?php 
		$resultPro = mysql_query("select * from Products");
		while($row = mysql_fetch_array($resultPro)){
			$i = $row['id'];
			echo "map.set('".$i."','".$row['Quantity']."');"; 
			echo "map2.set('".$i."','".$row['Price']."');"; 
		}
	?>
	
	/* If action() is activated, then Price is calculated and showed in the page.*/
	function action(){
		var num = selection.value;
		num = num.toString();
		var amount = map.get(num);
		var price = map2.get(num);
		if(!isNaN(quantity.value) &&  parseInt(quantity.value) <= amount){
			label.innerHTML = quantity.value * price;
		}
		else{
			label.innerHTML = 0;
		}
	}
	
	/* If ID is selected by click or key-board, then action() activates.*/
	quantity.addEventListener('keyup',function(){action();});
	selection.addEventListener('click',function(){action();});
	selection.addEventListener('keyup',function(){action();});	

})();
</script>
</html>