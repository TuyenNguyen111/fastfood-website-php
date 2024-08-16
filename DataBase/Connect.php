<?php 
	try {
		$conn =new PDO("mysql:host=localhost;dbname=qlcuahang",'root','');
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$conn->query("set names utf8");
		
		
	}
							catch (PDOException $x)
							{
								echo '<button class="btn btn-danger" >Disconnected</button>';
							}
	?>