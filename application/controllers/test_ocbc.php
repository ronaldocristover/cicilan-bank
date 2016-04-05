<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test_ocbc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->load->view('menu');
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

	public function jadwal_angsuran()
	{
		$this->load->view('form');
	}
	public function process()
	{

		$no_rekening = $this->input->post('no_rekening');
		$nama = $this->input->post('nama');
		$angsuran_ke = $this->input->post('angsuran_ke');
		$pokok 	= $this->input->post('plafond');
		$tenor 	= $this->input->post('jangka_waktu');
		$persen_bunga = $this->input->post('persen_bunga');
		$rate 	= ($persen_bunga/12/100);
		$time 	= strtotime($this->input->post('tanggal_realisasi'));
		$perubahan_harga = $this->input->post('jumlah_perubahan_harga');

		// input data ke data_rekening
		$this->db->insert('data_rekening', array(
				'no_rekening' => $no_rekening,
				'nama' => $nama, 
				'tanggal_realisasi' => date("Y-m-d", $time),
				'plafond' => $pokok,
				'jangka_waktu' => $tenor,
				'jml_perubahan_harga' => $perubahan_harga,
				'mulai_angsuran_ke' => $angsuran_ke,
				'persen_bunga' => $persen_bunga

			));
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

				$data = array(
						'bulan' => $i,
						'nama' => $nama,
						'no_rekening' => $no_rekening,
						'tanggal_angsuran' => date("Y-m-d", strtotime("+$i month", $time)),
						'saldo_pokok' => ($pokok - $angsuran_pokok),
						'angsuran_pokok' =>  $angsuran_pokok,
						'angsuran_bunga' => $angsuran_bunga,
						'angsuran_total' => ($angsuran_bunga + $angsuran_pokok),
						'bunga' => ($rate*100*12)
					);
				$this->db->insert('jadwal_angsuran', $data);
				$pokok = ($pokok - $angsuran_pokok);

			echo "</tr>";
		}
		$this->close_table();
	}

	public function input_pembayaran()
	{
		$this->load->view('form_pembayaran');
	}

	public function process_pembayaran()
	{
		$no_rekening = $this->input->post('no_rekening');
		$tanggal_pembayaran = date('Y-m-d', strtotime($this->input->post('tanggal_pembayaran')));
		$besar_pembayaran = $this->input->post('besar_pembayaran');
		$keterangan = $this->input->post('keterangan');

		$data = array(
				'tanggal_pembayaran' => $tanggal_pembayaran,
				'keterangan'  => $keterangan,
				'besar_pembayaran' => $besar_pembayaran
			);
		$this->db->insert('pembayaran', $data);

		if ($this->db->affected_rows() > 0) {
			echo "Sukses menambahkan data pembayaran";
		}

		$listing_data = $this->db->get('pembayaran')->result();

		echo "<table border=1>
			<thead>
				<tr> 
					<th>Tanggal Pembayaran</th>
					<th>Keterangan</th>
					<th>Besar Pembayaran</th>
				</tr>
			</thead>
			<tbody>";
		foreach ($listing_data as $key ) {
			echo "<tr>";
				echo "<td>".$key->tanggal_pembayaran."</td>";
				echo "<td>".$key->keterangan."</td>";
				echo "<td>".$key->besar_pembayaran."</td>";
			echo "</tr>";
		}
		$this->close_table();

		echo anchor(base_url('test_ocbc/input_pembayaran'), 'Kembali ke Input Data Pembayaran', 'color=red');
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

	public function cetak_kartu()
	{
		$this->load->view('form_cetak');
	}

	public function proses_cetak_kartu()
	{	
		$no_rekening = '111';
		$tanggal1 = '2016-04-05';
		$tanggal2 = '2016-07-05';
		$tenor = $this->db->get_where('data_rekening', array('no_rekening' => $no_rekening))->row();
		echo "<table border=1>
			<thead>
				<tr> 
					<th>Tanggal</th>
					<th>Keterangan Transaksi</th>
					<th>Debet</th>
					<th>Kredit</th>
					<th>Saldo</th>
				</tr>
			</thead>
			<tbody>";
		echo "<tr>
				<td>".$tenor->tanggal_realisasi."</td>
				<td>Realisasi Pinjaman</td>
				<td>".number_format($tenor->plafond)."</td>
				<td>0</td>
				<td>".number_format($tenor->plafond)."</td>
			  </tr>";

	  $sqlCustom = "(select ifnull(keterangan,0) as keterangan , tanggal_pembayaran, besar_pembayaran, no_rekening  from pembayaran p where p.no_rekening = '$no_rekening' and tanggal_pembayaran between '$tanggal1' and '$tanggal2')
		union
		(select ifnull(bulan,0) as keterangan ,tanggal_angsuran, angsuran_bunga, no_rekening from jadwal_angsuran j where j.no_rekening = '$no_rekening' and tanggal_angsuran between '$tanggal1' and '$tanggal2') order by tanggal_pembayaran asc";

		$customData = $this->db->query($sqlCustom)->result();
		$counter = $tenor->plafond;

		foreach ($customData as $key ) {
			echo "<tr>";
				echo "<td>".$key->tanggal_pembayaran."</td>";
				if ($key->keterangan == 0 || $key->keterangan == '0') {
					echo "<td>Angsuran</td>";
					echo "<td>0</td>";
					$kredit = $key->besar_pembayaran;
					echo "<td>".number_format($kredit)."</td>";
					$counter  = $counter - $kredit;
				}else{
					echo "<td>Pembebanan Bunga</td>";
					$debit = $key->besar_pembayaran;
					echo "<td>".number_format($debit)."</td>";
					echo "<td>0</td>";
					$counter  = $counter + $debit;
				}
				echo "<td>".number_format($counter)."</td>";
			echo "</tr>";
		}
		$this->close_table();
	}

}

/* End of file test_ocbc.php */
/* Location: ./application/controllers/test_ocbc.php */