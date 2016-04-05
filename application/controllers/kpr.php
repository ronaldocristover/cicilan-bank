<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kpr extends CI_Controller {

	public function index()
	{
		$this->bunga_efektif();
	}
	public function bunga_efektif()
	{
		$nilai_cicilan = '600000000';
		$tenor = '120';

		
		$cicilan_pokok = $nilai_cicilan / $tenor ;

		for ($i=1; $i <= $tenor; $i++) {
			echo "Bulan ke ". $i . '<br>';
			echo "Saldo Pokok : " . number_format($nilai_cicilan - $cicilan_pokok) . '<br>';
			echo "Cicilan Pokok : " . number_format($cicilan_pokok) . '<br>';
			$bunga = $nilai_cicilan * (10/100) /12 ;
			echo "Bunga : " . number_format($nilai_cicilan * (10/100) /12) . '<br>';
			echo "Cicilan : " . number_format($cicilan_pokok + $bunga);
			echo "<br><hr>";
			$nilai_cicilan = $nilai_cicilan - $cicilan_pokok;
		}
	}

	public function bunga_flat()
	{
		$nilai_cicilan = '600000000';
		$tenor = '120';
		$persen_bunga = (5.37 / 100) ;
		
		$bunga = $nilai_cicilan * $persen_bunga / 12 ;

		$cicilan_pokok = $nilai_cicilan / $tenor ;

		for ($i=1; $i <= $tenor; $i++) {
			echo "Bulan ke ". $i . '<br>	';
			echo "Saldo Pokok : " . number_format($nilai_cicilan - $cicilan_pokok) . '<br>';
			echo "Cicilan Pokok : " . number_format($cicilan_pokok) . '<br>';
			echo "Bunga : " . number_format($bunga) . '<br>';
			echo "Cicilan : " . number_format($bunga  + $cicilan_pokok);
			echo "<br><hr>";
			$nilai_cicilan = $nilai_cicilan - $cicilan_pokok;
		}
	}

}

/* End of file kpr.php */
/* Location: ./application/controllers/kpr.php */