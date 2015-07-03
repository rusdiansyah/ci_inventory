<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian extends CI_Controller {

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
			
			$where = " WHERE kodebeli<>''";
			if(!empty($cari)){
				$where .= " AND kodebeli LIKE '%$cari%' OR kode_supplier LIKE '%$cari%'";
			}
			if(!empty($tgl)){
				$where .= " AND tglbeli='$tgl'";
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Pembelian";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT * FROM h_beli $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/pembelian/index/';
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
			

			$text = "SELECT * FROM h_beli $where 
					ORDER BY kodebeli DESC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('pembelian/view', $d, true);		
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

			$d['judul']="Pembelian";
			
			$kode	= $this->app_model->MaxKodeBeli();
			$tgl	= date('d-m-Y');
			
			$d['kode_beli']	= $kode;
			$d['tgl_beli']	= $tgl;
			$d['supplier']	='';
			
			$text = "SELECT * FROM supplier";
			$d['l_supp'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('pembelian/form', $d, true);		
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
			
			$d['judul'] = "Pembelian";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM h_beli WHERE kodebeli='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['kode_beli']	= $id;
					$d['tgl_beli']	= $this->app_model->tgl_str($db->tglbeli);
					$d['supplier']	= $db->kode_supplier;
				}
			}else{
					$d['kode_beli']		=$id;
					$d['tgl_beli']	='';
					$d['supplier']	='';
			}
			
			$text = "SELECT * FROM supplier";
			$d['l_supp'] = $this->app_model->manualQuery($text);
									
			$d['content'] = $this->load->view('pembelian/form', $d, true);		
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
			$this->app_model->manualQuery("DELETE FROM d_beli WHERE kodebeli='$id'");
			$this->app_model->manualQuery("DELETE FROM h_beli WHERE kodebeli='$id'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/pembelian'>";			
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
			$this->app_model->manualQuery("DELETE FROM d_beli WHERE kodebeli='$id' AND kode_barang='$kode'");
			
			$this->edit();
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan()
	{
		
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
				
				
				$up['kodebeli']		= $this->input->post('kode_beli');
				$up['tglbeli']		= $this->app_model->tgl_sql($this->input->post('tgl'));
				$up['kode_supplier']= $this->input->post('supplier');
				$up['username']= $this->session->userdata('username');
				
				$ud['kodebeli'] = $this->input->post('kode_beli');
				$ud['kode_barang'] = $this->input->post('kode_brg');
				$ud['jmlbeli'] = $this->input->post('jml');
				$ud['hargabeli'] = $this->input->post('harga');
				
				$id['kodebeli']=$this->input->post('kode_beli');
				
				$id_d['kodebeli']=$this->input->post('kode_beli');
				$id_d['kode_barang']=$this->input->post('kode_brg');
				
				$data = $this->app_model->getSelectedData("h_beli",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("h_beli",$up,$id);
						$data = $this->app_model->getSelectedData("d_beli",$id_d);
						if($data->num_rows()>0){
							$this->app_model->updateData("d_beli",$ud,$id_d);
						}else{
							$this->app_model->insertData("d_beli",$ud);
						}
					echo 'Update data Sukses';
				}else{
					$this->app_model->insertData("h_beli",$up);
					$this->app_model->insertData("d_beli",$ud);
					echo 'Simpan data Sukses';		
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
			$text = "SELECT a.kodebeli,a.kode_barang,a.jmlbeli,a.hargabeli,
					b.nama_barang,b.satuan
					FROM d_beli as a 
					JOIN barang as b
					ON a.kode_barang=b.kode_barang
					WHERE a.kodebeli='$id'";
			$d['data']= $this->app_model->manualQuery($text);

			$this->load->view('pembelian/detail',$d);
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
			
			$d['judul'] = "Faktur Pembelian";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM h_beli WHERE kodebeli='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['kode_beli']	= $id;
					$d['tgl_beli']	= $this->app_model->tgl_indo($db->tglbeli);
					$d['supplier']	= $db->kode_supplier.' - '.$this->app_model->NamaSupp($db->kode_supplier);
				}
			}else{
					$d['kode_beli']		=$id;
					$d['tgl_beli']	='';
					$d['supplier']	='';
			}
			
			$text = "SELECT a.kodebeli,a.kode_barang,a.jmlbeli,a.hargabeli,
					b.nama_barang,b.satuan
					FROM d_beli as a 
					JOIN barang as b
					ON a.kode_barang=b.kode_barang
					WHERE a.kodebeli='$id'";
			$d['data']= $this->app_model->manualQuery($text);
									
			$this->load->view('pembelian/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */