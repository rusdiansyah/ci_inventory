<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_barang extends CI_Controller {

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

			
			$d['judul']="Laporan Data Barang";
			
			
			$d['content'] = $this->load->view('lap_barang/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function lihat()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$kode = $this->input->post('kode');
			$pilih = $this->input->post('pilih');
			
			if($pilih=='all'){
				$where = ' ';
			}else{
				$where = " WHERE kode_barang='$kode'";
			}
			
			$text = "SELECT * FROM barang $where 
					ORDER BY kode_barang ASC ";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_barang/view',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$kode = $this->uri->segment(4);
			$pilih = $this->uri->segment(3);
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			if($pilih=='all'){
				$where = ' ';
				$d['filter']="Semua Data";
			}else{
				$where = " WHERE kode_barang='$kode'";
				$d['filter']="Kode Barang $kode";
			}

			$d['judul']="Laporan Data Barang";
			
			$text = "SELECT * FROM barang $where 
					ORDER BY kode_barang ASC ";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_barang/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak_excel()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$kode = $this->uri->segment(4);
			$pilih = $this->uri->segment(3);
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			if($pilih=='all'){
				$where = ' ';
				$d['filter']="Semua Data";
			}else{
				$where = " WHERE kode_barang='$kode'";
				$d['filter']="Kode Barang $kode";
			}

			$d['judul']="Laporan Data Barang";
			
			$text = "SELECT * FROM barang $where 
					ORDER BY kode_barang ASC ";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_barang/cetak_excel',$d);
		}else{
			header('location:'.base_url());
		}
	}

}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */