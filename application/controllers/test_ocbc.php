<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_ocbc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->load->view('form');
	}

	public function test()
	{
		// simulasi hardcode
		$pokok = 80000000;
		$tenor = 36;
		$rate = (20/12/100); //0.0166666666667 ok
		$angsuran_bunga = $pokok * $rate; // ok
		$angsuran_pokok = $pokok*($rate/(pow($rate+1,36-0)-1)); //1639753.33545 //ok
		$angsuran_total = $angsuran_bunga + $angsuran_pokok; //2973086.66878
	}

	public function process()
	{
		$pokok 	= $this->input->post('plafond');
		$tenor 	= $this->input->post('jangka_waktu');
		$persen_bunga = $this->input->post('persen_bunga');
		$rate 	= ($persen_bunga/12/100);
		$time 	= strtotime($this->input->post('tanggal_realisasi'));
		$perubahan_harga = $this->input->post('jumlah_perubahan_harga');

		// $pokok = 80000000;
		// $tenor = 36;
		// $rate = (20/12/100); //0.0166666666667 ok
		$angsuran_pokok = 0;
		// $time = strtotime("05-04-2016");
		// $perubahan_harga = 2;

		echo "Tanggal Realisasi : " . date("M d Y", $time);
		echo br();
		echo "Plafond : " . $pokok;
		echo br();
		echo "Jangka Waktu : ". $tenor;
		echo br();
		echo "Jumlah Perubahan Harga : " . $perubahan_harga;
		echo "<hr>";
		$counter_perubahan_bunga = 1;
		$this->open_table();
		for ($i=1; $i <= $tenor; $i++) {
			echo "<tr>";
				echo "<td>".$i."</td>";
				echo "<td>".date("M d Y", strtotime("+$i month", $time))."</td>";

				if($i > 12 && $i <= 24){
					$counter_perubahan_bunga = $counter_perubahan_bunga + 1 ;
					// $rate = ((20+$perubahan_harga)/12/100); //0.0166666666667 ok
					$rate = (($persen_bunga+$perubahan_harga)/12/100); //0.0166666666667 ok
				}else if($i > 24 && $i <= 36 && $counter_perubahan_bunga < $perubahan_harga){
					// $rate = ((20+($perubahan_harga*2))/12/100); //0.0166666666667 ok
					$rate = (($persen_bunga+($perubahan_harga*2))/12/100); //0.0166666666667 ok
				}
				$angsuran_pokok = $pokok*($rate/(pow($rate+1,36-($i-1))-1)); //1639753.33545 //ok
				echo "<td>".($pokok - $angsuran_pokok)."</td>";
				echo "<td>".$angsuran_pokok."</td>";
				$angsuran_bunga = $pokok * $rate; // ok
				echo "<td>".$angsuran_bunga."</td>";
				echo "<td>".($angsuran_bunga + $angsuran_pokok)."</td>";
				echo "<td>".($rate*100*12)."</td>";
				$pokok = ($pokok - $angsuran_pokok);
			echo "</tr>";
		}
		$this->close_table();
	}

	public function backup_process()
	{
		$pokok = 80000000;
		$tenor = 36;
		$rate = (20/12/100); //0.0166666666667 ok
		$angsuran_pokok = 0;
		$time = strtotime("05-04-2016");
		$perubahan_harga = 2;

		echo "Tanggal Realisasi : " . date("M d Y", $time);
		echo br();
		echo "Plafond : " . $pokok;
		echo br();
		echo "Jangka Waktu : ". $tenor;
		echo br();
		echo "Jumlah Perubahan Harga : " . $perubahan_harga;
		echo "<hr>";
		$this->open_table();
		for ($i=1; $i <= $tenor; $i++) {
			echo "<tr>";
				echo "<td>".$i."</td>";
				echo "<td>".date("M d Y", strtotime("+$i month", $time))."</td>";
				$angsuran_pokok = $pokok*($rate/(pow($rate+1,36-($i-1))-1)); //1639753.33545 //ok
				echo "<td>".($pokok - $angsuran_pokok)."</td>";
				echo "<td>".$angsuran_pokok."</td>";
				$angsuran_bunga = $pokok * $rate; // ok
				echo "<td>".$angsuran_bunga."</td>";
				echo "<td>".($angsuran_bunga + $angsuran_pokok)."</td>";
				echo "<td>".($rate*100*12)."</td>";
				$pokok = ($pokok - $angsuran_pokok);
			echo "</tr>";
		}
		$this->close_table();
	}

	public function open_table()
	{
		echo "<table border=1>
			<thead>
				<tr> 
					<th>Bulan</th>
					<th>Tanggal</th>
					<th>Saldo Pokok</th>
					<th>Angsuran Pokok</th>
					<th>Angsuran Bunga</th>
					<th>Angsuran Total</th>
					<th>% Bunga</th>
				</tr>
			</thead>
			<tbody>";
	}

	public function close_table()
	{
		echo "</tbody>
		</table>";
	}

}

/* End of file test_ocbc.php */
/* Location: ./application/controllers/test_ocbc.php */