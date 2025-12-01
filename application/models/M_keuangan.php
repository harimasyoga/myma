<?php
class M_keuangan extends CI_Model
{
 
	function __construct()
	{
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');
		$this->username = $this->session->userdata('username');
		$this->waktu    = date('Y-m-d H:i:s');
		$this->load->model('m_master');
	}

	function save_minso()
	{
		$status_input   = $this->input->post('sts_input');
		
		$no_urut        = $this->input->post('no_urut');
		$jenis          = $this->input->post('jnss');
		$ket            = $this->input->post('ket');
		$tgl_minso      = $this->input->post('tgl_minso');

		if($jenis=='masuk'){
			$masuk    = str_replace('.','',$this->input->post('total_all'));
			$keluar   = 0;
		}else{
			$keluar   = str_replace('.','',$this->input->post('total_all'));
			$masuk    = 0;
		}
		
		if($status_input == 'add')
		{									
			
			$data_header = array(
				'urut'          => $no_urut,
				'jns'           => $jenis,
				'ket'           => $ket,
				'tgl'           => $tgl_minso,
				'tot_masuk'     => $masuk,
				'tot_keluar'    => $keluar,
			);

			$result_header = $this->db->insert('trs_h_minso', $data_header);

			$cek = $this->db->query("SELECT*FROM trs_h_minso where urut='$no_urut' and jns='$jenis' and tgl='$tgl_minso' ")->row();
			// rinci

			$rowloop     = $this->input->post('bucket');
			for($loop = 0; $loop <= $rowloop; $loop++)
			{
				$data_detail = array(				
					'id_h_minso'       => $cek->id_h_minso,
					'ket_detail'     	=> $this->input->post('ket_detail['.$loop.']'),
					'nominal'     		=> str_replace('.','',$this->input->post('nominal['.$loop.']')),
				);

				$result_detail = $this->db->insert('trs_d_minso', $data_detail);

			}		

			return $result_detail;
			
		}else{
			$id_h_minso    = $this->input->post('id_h_minso');

			$cek     = $this->db->query("SELECT*FROM trs_h_minso where id_h_minso ='$id_h_minso' ")->row();
			
			$data_header = array(
				'urut'          => $no_urut,
				'jns'           => $jenis,
				'ket'           => $ket,
				'tgl'           => $tgl_minso,
				'tot_masuk'     => $masuk,
				'tot_keluar'    => $keluar,
			);

			$this->db->where('id_h_minso', $id_h_minso);
			$result_header = $this->db->update('trs_h_minso', $data_header);
	
			// delete rinci
			$del_detail = $this->db->query("DELETE FROM trs_d_minso where id_h_minso='$id_h_minso' ");

			// rinci
			if($del_detail)
			{
				$rowloop     = $this->input->post('bucket');
				for($loop = 0; $loop <= $rowloop; $loop++)
				{
					if($this->input->post('ket_detail['.$loop.']'))
					{

						$data_detail = array(				
							'id_h_minso'        => $id_h_minso,
							'ket_detail'     	=> $this->input->post('ket_detail['.$loop.']'),
							'nominal'     		=> str_replace('.','',$this->input->post('nominal['.$loop.']')),
						);
		
						$result_detail = $this->db->insert('trs_d_minso', $data_detail);
					}
				}		
				return $result_detail;
			}
			
		}
		
	}
}
