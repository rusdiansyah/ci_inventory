<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_jual extends CI_Controller {

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

			
			$d['judul']="Laporan Penjualan Barang";
			
			$d['content'] = $this->load->view('lap_jual/form', $d, true);		
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
			$tgl1 = $this->app_model->tgl_sql($this->input->post('tgl1'));
			$tgl2 = $this->app_model->tgl_sql($this->input->post('tgl2'));
			$pilih = $this->input->post('pilih');
			
			if($pilih=='all'){
				$where = ' ';
			}elseif($pilih=='tgl'){
				$where = " WHERE a.tgljual BETWEEN '$tgl1' AND '$tgl2'";
			}else{
				$where = " WHERE b.kode_barang='$kode'";
			}
			
			$text = "SELECT a.kodejual,a.tgljual,
					b.kode_barang,b.jmljual,b.hargajual,
					c.nama_barang,c.satuan
					FROM h_jual as a
					JOIN d_jual as b
					JOIN barang as c
					ON a.kodejual=b.kodejual AND b.kode_barang=c.kode_barang
					$where 
					ORDER BY a.kodejual ASC ";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_jual/view',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			$d['judul']="Laporan Penjualan Barang";
			
			$pilih = $this->uri->segment(3);
			//$tgl = $this->app_model->tgl_sql($this->uri->segment(5));		
			//$kode = $this->uri->segment(4);
		
			if($pilih=='all'){
				$where = ' ';
				$d['filter'] = 'Semua Data';
			}elseif($pilih=='tgl'){
				$tgl1 = $this->app_model->tgl_sql($this->uri->segment(4));
				$tgl2 = $this->app_model->tgl_sql($this->uri->segment(5));		
				$where = " WHERE a.tgljual BETWEEN '$tgl1' AND '$tgl2'";
				$d['filter'] = 'Tanggal '.$this->app_model->tgl_indo($tgl1).' s.d '.$this->app_model->tgl_indo($tgl2);
			}else{
				$kode = $this->uri->segment(4);
				$where = " WHERE b.kode_barang='$kode'";
				$d['filter'] = 'Kode Barang '.$kode;
			}
			
			$text = "SELECT a.kodejual,a.tgljual,
					b.kode_barang,b.jmljual,b.hargajual,
					c.nama_barang,c.satuan
					FROM h_jual as a
					JOIN d_jual as b
					JOIN barang as c
					ON a.kodejual=b.kodejual AND b.kode_barang=c.kode_barang
					$where 
					ORDER BY a.kodejual ASC ";
			$d['text'] = $text;
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_jual/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak_excel()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			$d['judul']="Laporan Penjualan Barang";
			
			$pilih = $this->uri->segment(3);
			//$tgl = $this->app_model->tgl_sql($this->uri->segment(5));		
			//$kode = $this->uri->segment(4);
		
			if($pilih=='all'){
				$where = ' ';
				$d['filter'] = 'Semua Data';
			}elseif($pilih=='tgl'){
				$tgl1 = $this->app_model->tgl_sql($this->uri->segment(4));
				$tgl2 = $this->app_model->tgl_sql($this->uri->segment(5));		
				$where = " WHERE a.tgljual BETWEEN '$tgl1' AND '$tgl2'";
				$d['filter'] = 'Tanggal '.$this->app_model->tgl_indo($tgl1).' s.d '.$this->app_model->tgl_indo($tgl2);
			}else{
				$kode = $this->uri->segment(4);
				$where = " WHERE b.kode_barang='$kode'";
				$d['filter'] = 'Kode Barang '.$kode;
			}
			
			$text = "SELECT a.kodejual,a.tgljual,
					b.kode_barang,b.jmljual,b.hargajual,
					c.nama_barang,c.satuan
					FROM h_jual as a
					JOIN d_jual as b
					JOIN barang as c
					ON a.kodejual=b.kodejual AND b.kode_barang=c.kode_barang
					$where 
					ORDER BY a.kodejual ASC ";
			$d['text'] = $text;
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_jual/cetak_excel',$d);
		}else{
			header('location:'.base_url());
		}
	}

}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */