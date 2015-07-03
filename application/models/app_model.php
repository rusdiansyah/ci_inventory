<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_Model extends CI_Model {

	/**
	 * @author : Deddy Rusdiansyah
	 * @web : http://deddyrusdiansyah.blogspot.com
	 * @keterangan : Model untuk menangani semua query database aplikasi
	 **/
	
	
	
	public function getAllData($table)
	{
		return $this->db->get($table);
	}
	
	public function getAllDataLimited($table,$limit,$offset)
	{
		return $this->db->get($table, $limit, $offset);
	}
	
	public function getSelectedDataLimited($table,$data,$limit,$offset)
	{
		return $this->db->get_where($table, $data, $limit, $offset);
	}
		
	//select table
	public function getSelectedData($table,$data)
	{
		return $this->db->get_where($table, $data);
	}
	
	//update table
	function updateData($table,$data,$field_key)
	{
		$this->db->update($table,$data,$field_key);
	}
	function deleteData($table,$data)
	{
		$this->db->delete($table,$data);
	}
	
	function insertData($table,$data)
	{
		$this->db->insert($table,$data);
	}
	
	//Query manual
	function manualQuery($q)
	{
		return $this->db->query($q);
	}
	
	public function NamaSupp($id){
		$t = "SELECT * FROM supplier WHERE kode_supplier='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->nama_supplier;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
	public function CariLevel($id){
		$t = "SELECT * FROM level WHERE id_level='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->level;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
	public function ItemBeli($id){
		$t = "SELECT kodebeli FROM d_beli WHERE kodebeli='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlBeli($id){
		$t = "SELECT sum(jmlbeli * hargabeli) as jml FROM d_beli WHERE kodebeli='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function ItemJual($id){
		$t = "SELECT kodejual FROM d_jual WHERE kodejual='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlJual($id){
		$t = "SELECT sum(jmljual * hargajual) as jml FROM d_jual WHERE kodejual='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariStokAwal($kode){
		$t = "SELECT kode_barang,stok_awal FROM barang WHERE kode_barang='$kode'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->stok_awal;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariJmlBeli($kode){
		$t = "SELECT kode_barang,sum(jmlbeli) as jml FROM d_beli WHERE kode_barang='$kode' GROUP BY kode_barang";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariJmlJual($kode){
		$t = "SELECT kode_barang,sum(jmljual) as jml FROM d_jual WHERE kode_barang='$kode' GROUP BY kode_barang";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function GrafikBeli($bln,$thn){
		$t = "SELECT month(a.tglbeli) as bln, year(a.tglbeli) as th, count(*) as jml 
			FROM h_beli as a
			JOIN d_beli as b
			ON a.kodebeli=b.kodebeli 
			WHERE month(a.tglbeli)='$bln' AND year(a.tglbeli)='$thn'
			GROUP BY month(a.tglbeli),year(a.tglbeli)";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function GrafikJual($bln,$thn){
		$t = "SELECT month(a.tgljual) as bln, year(a.tgljual) as th, count(*) as jml 
			FROM h_jual as a
			JOIN d_jual as b
			ON a.kodejual=b.kodejual 
			WHERE month(a.tgljual)='$bln' AND year(a.tgljual)='$thn'
			GROUP BY month(a.tgljual),year(a.tgljual)";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariStokAkhir($kode){
		$awal = $this->app_model->CariStokAwal($kode);
		$beli = $this->app_model->CariJmlBeli($kode);
		$jual = $this->app_model->CariJmlJual($kode);
		$hasil = ($awal+$beli)-$jual;
		return $hasil;
	}
	
	public function CariNamaPengguna(){
		$id = $this->session->userdata('username');
		$t = "SELECT * FROM admins WHERE username='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->nama_lengkap;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
	public function CariFotoPengguna(){
		$id = $this->session->userdata('username');
		$t = "SELECT * FROM admins WHERE username='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->foto;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
	public function TotalBeli($tgl1,$tgl2){
		$t = "SELECT sum(a.jmlbeli * a.hargabeli) as jml 
			FROM d_beli as a
			JOIN h_beli as b
			ON a.kodebeli=a.kodebeli 
			WHERE b.tglbeli BETWEEN '$tgl1' AND '$tgl2'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function TotalJual($tgl1,$tgl2){
		$t = "SELECT sum(a.jmljual * a.hargajual) as jml 
				FROM d_jual as a
				JOIN h_jual as b
				ON a.kodejual=b.kodejual 
				WHERE b.tgljual BETWEEN '$tgl1' AND '$tgl2'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function MaxKodeBeli(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(kodebeli) as no FROM h_beli";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,2,5))+1;
				$hasil = 'BL'.sprintf("%05s", $tmp);
			}
		}else{
			$hasil = 'BL'.'00001';
		}
		return $hasil;
	}
	
	public function MaxKodeJual(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(kodejual) as no FROM h_jual";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,2,5))+1;
				$hasil = 'JL'.sprintf("%05s", $tmp);
			}
		}else{
			$hasil = 'JL'.'00001';
		}
		return $hasil;
	}
	
		
	//Konversi tanggal
	public function tgl_sql($date){
		$exp = explode('-',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
		}
		return $date;
	}
	public function tgl_str($date){
		$exp = explode('-',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
		}
		return $date;
	}
	
	public function ambilTgl($tgl){
		$exp = explode('-',$tgl);
		$tgl = $exp[2];
		return $tgl;
	}
	
	public function ambilBln($tgl){
		$exp = explode('-',$tgl);
		$tgl = $exp[1];
		$bln = $this->app_model->getBulan($tgl);
		$hasil = substr($bln,0,3);
		return $hasil;
	}
	
	public function tgl_indo($tgl){
			$jam = substr($tgl,11,10);
			$tgl = substr($tgl,0,10);
			$tanggal = substr($tgl,8,2);
			$bulan = $this->app_model->getBulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun.' '.$jam;		 
	}	

	public function getBulan($bln){
		switch ($bln){
			case 1: 
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	} 
	
	public function hari_ini($hari){
		date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
		$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
		//$hari = date("w");
		$hari_ini = $seminggu[$hari];
		return $hari_ini;
	}
	
	//query login
	public function getLoginData($usr,$psw)
	{
		$u = mysql_real_escape_string($usr);
		$p = md5(mysql_real_escape_string($psw));
		$q_cek_login = $this->db->get_where('admins', array('username' => $u, 'password' => $p));
		if(count($q_cek_login->result())>0)
		{
			foreach($q_cek_login->result() as $qck)
			{
					foreach($q_cek_login->result() as $qad)
					{
						$sess_data['logged_in'] = 'aingLoginYeuh';
						$sess_data['username'] = $qad->username;
						$sess_data['nama_lengkap'] = $qad->nama_lengkap;
						$sess_data['foto'] = $qad->foto;
						$sess_data['level'] = $qad->level;
						$this->session->set_userdata($sess_data);
					}
					header('location:'.base_url().'index.php/home');
			}
		}
		else
		{
			$this->session->set_flashdata('result_login', '<br>Username atau Password yang anda masukkan salah.');
			header('location:'.base_url().'index.php/login');
		}
	}
}
	
/* End of file app_model.php */
/* Location: ./application/models/app_model.php */