<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_beli extends CI_Controller {

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

			
			$d['judul']="Laporan Pembelian Barang";
			
			$text = "SELECT * FROM supplier ";
			$d['l_supp'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('lap_beli/form', $d, true);		
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
			$supplier = $this->input->post('supplier');
			$pilih = $this->input->post('pilih');
			
			if($pilih=='all'){
				$where = ' ';
			}elseif($pilih=='tgl'){
				$where = " WHERE a.tglbeli BETWEEN '$tgl1' AND '$tgl2'";
			}elseif($pilih=='supplier'){
				$where = " WHERE a.kode_supplier='$supplier'";	
			}else{
				$where = " WHERE b.kode_barang='$kode'";
			}
			
			$text = "SELECT a.kodebeli,a.tglbeli,a.kode_supplier,
					b.kode_barang,b.jmlbeli,b.hargabeli,
					c.nama_barang,c.satuan,
					d.nama_supplier
					FROM h_beli as a
					JOIN d_beli as b
					JOIN barang as c
					JOIN supplier as d
					ON a.kodebeli=b.kodebeli AND b.kode_barang=c.kode_barang AND a.kode_supplier=d.kode_supplier
					$where 
					ORDER BY a.kodebeli ASC ";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_beli/view',$d);
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
			$d['judul']="Laporan Pembelian Barang";
			
			$pilih = $this->uri->segment(3);
		
			if($pilih=='all'){
				$where = ' ';
				$d['filter'] = 'Semua Data';
			}elseif($pilih=='tgl'){
				$tgl1 = $this->app_model->tgl_sql($this->uri->segment(4));
				$tgl2 = $this->app_model->tgl_sql($this->uri->segment(5));
				
				$where = " WHERE a.tglbeli BETWEEN '$tgl1' AND '$tgl2'";
				$d['filter'] = 'Tanggal '.$this->app_model->tgl_indo($tgl1).' s.d '.$this->app_model->tgl_indo($tgl2);
			}elseif($pilih=='supplier'){
				$supplier = $this->uri->segment(4);
				$where = " WHERE a.kode_supplier='$supplier'";	
				$d['filter'] = 'Supplier '.$supplier;
			}else{
				$kode = $this->uri->segment(4);
				$where = " WHERE b.kode_barang='$kode'";
				$d['filter'] = 'Kode Barang '.$kode;
			}
			
			$text = "SELECT a.kodebeli,a.tglbeli,a.kode_supplier,
					b.kode_barang,b.jmlbeli,b.hargabeli,
					c.nama_barang,c.satuan,
					d.nama_supplier
					FROM h_beli as a
					JOIN d_beli as b
					JOIN barang as c
					JOIN supplier as d
					ON a.kodebeli=b.kodebeli AND b.kode_barang=c.kode_barang AND a.kode_supplier=d.kode_supplier
					$where 
					ORDER BY a.kodebeli ASC ";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_beli/cetak',$d);
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
			$d['judul']="Laporan Pembelian Barang";
			
			$pilih = $this->uri->segment(3);
		
			if($pilih=='all'){
				$where = ' ';
				$d['filter'] = 'Semua Data';
			}elseif($pilih=='tgl'){
				$tgl1 = $this->app_model->tgl_sql($this->uri->segment(4));
				$tgl2 = $this->app_model->tgl_sql($this->uri->segment(5));
				
				$where = " WHERE a.tglbeli BETWEEN '$tgl1' AND '$tgl2'";
				$d['filter'] = 'Tanggal '.$this->app_model->tgl_indo($tgl1).' s.d '.$this->app_model->tgl_indo($tgl2);
			}elseif($pilih=='supplier'){
				$supplier = $this->uri->segment(4);
				$where = " WHERE a.kode_supplier='$supplier'";	
				$d['filter'] = 'Supplier '.$supplier;
			}else{
				$kode = $this->uri->segment(4);
				$where = " WHERE b.kode_barang='$kode'";
				$d['filter'] = 'Kode Barang '.$kode;
			}
			
			$text = "SELECT a.kodebeli,a.tglbeli,a.kode_supplier,
					b.kode_barang,b.jmlbeli,b.hargabeli,
					c.nama_barang,c.satuan,
					d.nama_supplier
					FROM h_beli as a
					JOIN d_beli as b
					JOIN barang as c
					JOIN supplier as d
					ON a.kodebeli=b.kodebeli AND b.kode_barang=c.kode_barang AND a.kode_supplier=d.kode_supplier
					$where 
					ORDER BY a.kodebeli ASC ";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_beli/cetak_excel',$d);
		}else{
			header('location:'.base_url());
		}
	}

}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */