<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="<?php echo base_url('test_ocbc/process') ?>" method="post">
		<table>
		  <tr>
		    <td>No. Rekening</td>
		    <td><input type="text" name="no_rekening"></td> 
		  </tr>
		  <tr>
		  	<td>Nama</td>
		  	<td><input type="text" name="nama"></td>
		  </tr>
		  <tr>
		  	<td>Tgl Realisasi</td>
		  	<td><input type="text" name="tanggal_realisasi" value="05-04-2016"></td>
		  </tr>
		  <tr>
		  	<td>Plafond</td>
		  	<td><input type="text" name="plafond" value="80000000"></td>
		  </tr>
		  <tr>
		  	<td>Jangka Waktu</td>
		  	<td><input type="text" name="jangka_waktu" value="36"></td>
		  </tr>
		  <tr>
		  	<td>Jml. Perubahan harga</td>
		  	<td><input type="text" name="jumlah_perubahan_harga" value="2"></td>
		  </tr>
		  <tr>
		  	<td>Angsuran Ke</td>
		  	<td><input type="text" name="angsuran_ke"></td>
		  </tr>
		  <tr>
		  	<td>Persen Bunga</td>
		  	<td><input type="text" name="persen_bunga" value="20"></td>
		  </tr>
		  <tr>
		  	<td></td>
		  	<td><input type="submit" name="Submit"></td>
		  </tr>
		</table>
	</form>
</body>
</html>