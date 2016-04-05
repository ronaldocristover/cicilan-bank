<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Input Data Pembayaran</title>
</head>
<body>
	<form action="<?php echo base_url('test_ocbc/process_pembayaran') ?>" method="post">
		<table>
		  <tr>
		    <td>No. Rekening</td>
		    <td><input type="text" name="no_rekening"></td> 
		  </tr>
		  <tr>
		    <td>Tanggal Pembayaran</td>
		    <td><input type="date" name="tanggal_pembayaran"></td> 
		  </tr>
		  <tr>
		  	<td>Besar Pembayaran</td>
		  	<td><input type="text" name="besar_pembayaran" value="0"></td>
		  </tr>
		  <tr>
		  	<td>Keterangan</td>
		  	<td><input type="text" name="keterangan" value=""></td>
		  </tr>
		  <tr>
		  	<td></td>
		  	<td><input type="submit" name="Submit"></td>
		  </tr>
		</table>
	</form>
</body>
</html>