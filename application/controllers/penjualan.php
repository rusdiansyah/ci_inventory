<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan extends CI_Controller {

	/**
	 * @author : Deddy Rusdiansyah,S.Kom
	 * @web : http://deddyrusdiansyah.blogspot.com
	 * @keterangan : Controller untuk halaman profil
	 **/
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari = $this->input->post('txt_cari');
			$tgl = $this->app_model->tgl_sql($this->input->post('cari_tgl'));
			
			$where = " WHERE kodejual<>''";
			if(!empty($cari)){
				$where .= " AND kodejual LIKE '%$cari%'";
			}
			if(!empty($tgl)){
				$where .= " AND tgljual='$tgl'";
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Penjualan";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT * FROM h_jual $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/penjualan/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['next_link'] = 'Lanjut &raquo;';
			$config['prev_link'] = '&laquo; Kembali';
			$config['last_link'] = '<b>Terakhir &raquo; </b>';
			$config['first_link'] = '<b> &laquo; Pertama</b>';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			$d['hal'] = $offset;
			

			$text = "SELECT * FROM h_jual $where 
					ORDER BY kodejual DESC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('penjualan/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function tambah()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul']="Penjualan";
			
			$kode	= $this->app_model->MaxKodeJual();
			$tgl	= date('d-m-Y');
			
			$d['kode_jual']	= $kode;
			$d['tgl_jual']	= $tgl;
			
			$d['content'] = $this->load->view('penjualan/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function edit()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Penjualan";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM h_jual WHERE kodejual='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['kode_jual']	= $id;
					$d['tgl_jual']	= $this->app_model->tgl_str($db->tgljual);
				}
			}else{
					$d['kode_jual']		=$id;
					$d['tgl_jual']	='';
			}
									
			$d['content'] = $this->load->view('penjualan/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$id = $this->uri->segment(3);
			$this->app_model->manualQuery("DELETE FROM d_jual WHERE kodejual='$id'");
			$this->app_model->manualQuery("DELETE FROM h_jual WHERE kodejual='$id'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/penjualan'>";			
		}else{
			header('location:'.base_url());
		}
	}
	public function hapus_detail()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$id = $this->uri->segment(3);
			$kode = $this->uri->segment(4);
			$this->app_model->manualQuery("DELETE FROM d_jual WHERE kodejual='$id' AND kode_barang='$kode'");
			
			$this->edit();
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan()
	{
		
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$stok = $this->app_model->CariStokAkhir($this->input->post('kode_brg'));
			$jml = $this->input->post('jml');
			if($stok >= $jml){	
				
				$up['kodejual']		= $this->input->post('kode_jual');
				$up['tgljual']		= $this->app_model->tgl_sql($this->input->post('tgl'));
				$up['username']= $this->session->userdata('username');
				
				$ud['kodejual'] = $this->input->post('kode_jual');
				$ud['kode_barang'] = $this->input->post('kode_brg');
				$ud['jmljual'] = $this->input->post('jml');
				$ud['hargajual'] = $this->input->post('harga');
				
				$id['kodejual']=$this->input->post('kode_jual');
				
				$id_d['kodejual']=$this->input->post('kode_jual');
				$id_d['kode_barang']=$this->input->post('kode_brg');
				
				$data = $this->app_model->getSelectedData("h_jual",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("h_jual",$up,$id);
						$data = $this->app_model->getSelectedData("d_jual",$id_d);
						if($data->num_rows()>0){
							$this->app_model->updateData("d_jual",$ud,$id_d);
						}else{
							$this->app_model->insertData("d_jual",$ud);
						}
					echo 'Update data Sukses';
				}else{
					$this->app_model->insertData("h_jual",$up);
					$this->app_model->insertData("d_jual",$ud);
					echo 'Simpan data Sukses';		
				}
			}else{
				echo 'Maaf, Stok tidak mencukupi. Stok Barang Sekarang <b>'.$stok.'</b>';
			}
		}else{
				header('location:'.base_url());
		}
	
	}
	
	public function DataDetail()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$id = $this->input->post('kode');
			$text = "SELECT a.kodejual,a.kode_barang,a.jmljual,a.hargajual,
					b.nama_barang,b.satuan
					FROM d_jual as a 
					JOIN barang as b
					ON a.kode_barang=b.kode_barang
					WHERE a.kodejual='$id'";
			$d['data']= $this->app_model->manualQuery($text);

			$this->load->view('penjualan/detail',$d);
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
			
			$d['judul'] = "Faktur Penjualan";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM h_jual WHERE kodejual='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['kode_jual']	= $id;
					$d['tgl_jual']	= $this->app_model->tgl_indo($db->tgljual);
				}
			}else{
					$d['kode_jual']		=$id;
					$d['tgl_jual']	='';
			}
			
			$text = "SELECT a.kodejual,a.kode_barang,a.jmljual,a.hargajual,
					b.nama_barang,b.satuan
					FROM d_jual as a 
					JOIN barang as b
					ON a.kode_barang=b.kode_barang
					WHERE a.kodejual='$id'";
			$d['data']= $this->app_model->manualQuery($text);
									
			$this->load->view('penjualan/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */