<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Simulasi Cicilan</title>
</head>
<body>
	<form action="<?php echo base_url('test_ocbc/proses_cetak_kartu') ?>" method="post">
		<table>
		  <tr>
		    <td>No. Rekening</td>
		    <td><input type="text" name="no_rekening"></td> 
		  </tr>
		  <tr>
		  	<td>Tanggal 1</td>
		  	<td><input type="date" name="tanggal1"></td>
		  </tr>
		  <tr>
		  	<td>Tanggal 2</td>
		  	<td><input type="date" name="tanggal2"></td>
		  </tr>
		  <tr>
		  	<td></td>
		  	<td><input type="submit" name="Submit"></td>
		  </tr>
		</table>
	</form>
</body>
</html>