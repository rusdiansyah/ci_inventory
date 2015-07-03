<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profit extends CI_Controller {

	/**
	 * @author : Deddy Rusdiansyah,S.Kom
	 * @web : http://deddyrusdiansyah.blogspot.com
	 * @keterangan : Controller untuk halaman profil
	 **/
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Profit";
			
			$d['content'] = $this->load->view('profit/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function lihat()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			
			$d['judul']="Profit";
			
			$tgl1 = $this->app_model->tgl_sql($this->input->post('tgl1'));
			$tgl2 = $this->app_model->tgl_sql($this->input->post('tgl2'));
			
			$t = "SELECT sum(a.jmljual * a.hargajual) as jml_jual,
				sum(a.jmljual * c.harga_beli) as jml_beli
				FROM d_jual as a
				JOIN h_jual as b
				JOIN barang as c
				ON a.kodejual=b.kodejual AND a.kode_barang=c.kode_barang
				WHERE b.tgljual BETWEEN '$tgl1' AND '$tgl2'
				LIMIT 1";
			$data = $this->app_model->manualQuery($t);
			$r = $data->num_rows();
			if($r>0){
				foreach($data->result() as $h){
					$total_jual = $h->jml_jual;
					$total_beli = $h->jml_beli;
					$total = $total_jual-$total_beli;
				}
			}else{
				$total_jual = 0;
				$total_beli = 0;
				$total = $total_jual-$total_beli;
			}
			
			$d['total_beli'] = $total_beli;
			$d['total_jual'] = $total_jual;
			
			$d['total'] = $total;
			
			$this->load->view('profit/view',$d);
			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function lihat_detail()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$tgl1 = $this->app_model->tgl_sql($this->input->post('tgl1'));
			$tgl2 = $this->app_model->tgl_sql($this->input->post('tgl2'));

			$where = " WHERE a.tgljual BETWEEN '$tgl1' AND '$tgl2'";
	
			
			$text = "SELECT a.kodejual,a.tgljual,
					b.kode_barang,b.jmljual,b.hargajual,
					c.nama_barang,c.satuan,c.harga_beli
					FROM h_jual as a
					JOIN d_jual as b
					JOIN barang as c
					ON a.kodejual=b.kodejual AND b.kode_barang=c.kode_barang
					$where 
					ORDER BY a.kodejual ASC ";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('profit/view_detail',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */