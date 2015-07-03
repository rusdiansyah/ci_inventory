<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends CI_Controller {

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

			
			$d['judul']="Edit Profil";
			
			$id = $this->session->userdata('username');
			
			$where = " WHERE username='$id'";

			$text = "SELECT * FROM admins $where ";
			$hasil = $this->app_model->manualQuery($text);
			$r = $hasil->num_rows();
			if($r>0){
				foreach($hasil->result() as $t){
					$d['username'] = $id;
					$d['nama_lengkap'] = $t->nama_lengkap;
					$d['password'] ='';
					$d['foto'] = '';
				}
			}else{
				$d['username'] = $id;
				$d['nama_lengkap'] ='';
				$d['password'] ='';
				$d['foto'] = '';
			}
			
			$d['content'] = $this->load->view('profil/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan()
	{
		
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
				
				$pwd 	= $this->input->post('pwd');
				$nama 	= $this->input->post('nama_lengkap');
				$user	= mysql_real_escape_string($this->input->post('username'));
				
				$up['username']		= $user;
				$up['nama_lengkap']	= $nama;
				$up['password']		= md5($pwd);
				
				$id['username']=$this->input->post('username');
				
				$data = $this->app_model->getSelectedData("admins",$id);
				if($data->num_rows()>0){
					if(empty($pwd)){
						$this->app_model->manualQuery("UPDATE admins SET nama_lengkap='$nama' WHERE username='$user'");
					}else{
						$this->app_model->updateData("admins",$up,$id);
					}
					echo 'Update data Sukses';
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */