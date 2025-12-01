<?php
class M_transaksi extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');
		$this->username = $this->session->userdata('username');
		$this->waktu    = date('Y-m-d H:i:s');
		$this->load->model('m_master');
	}

	
	function save_tutor()
	{
		$status_input   = $this->input->post('sts_input');
		
		$pilihan        = $this->input->post('pilihan');
		$pil_job        = $this->input->post('pil_job');
		$pil_job_text   = $this->input->post('pil_job_text');
		$dasar_hukum    = $this->input->post('dasar_hukum');
		$syarat         = $this->input->post('syarat');
		$ket            = $this->input->post('ket');
		$tutor          = $this->input->post('tutor');
		$error_log      = $this->input->post('error_log');

		
		if($status_input == 'add')
		{									
			
			$data_header = array(
				'pilihan'         => $pilihan,
				'pil_job'         => $pil_job,
				'pil_job_text'    => $pil_job_text,
				'dasar_hukum'     => $dasar_hukum,
				'syarat'          => $syarat,
				'ket'             => $ket,
				'tutor'           => $tutor,
				'error_log'       => $error_log,
			);

			$result_header = $this->db->insert('tr_tutorial', $data_header);

			return $result_header;
			
		}else{
			
			$id_tutor    = $this->input->post('id_tutor');
			
			if ($pilihan =='YA')
			{
				$pil_job_ok         = $pil_job ;
				$pil_job_text_ok    = '' ;
			}else{
				$pil_job_ok         = '' ;
				$pil_job_text_ok    = $pil_job_text ;
			}

			$data_header = array(
				'pilihan'         => $pilihan,
				'pil_job'         => $pil_job_ok,
				'pil_job_text'    => $pil_job_text_ok,
				'dasar_hukum'     => $dasar_hukum,
				'syarat'          => $syarat,
				'ket'             => $ket,
				'tutor'           => $tutor,
				'error_log'       => $error_log,
			);

			$this->db->where('id_tutor', $id_tutor);
			$result_header = $this->db->update('tr_tutorial', $data_header);

			return $result_header;
			
		}
		
	}

	function save_perkara_bht()
	{
		$status_input   = $this->input->post('sts_input');
		
		$id_perkara   = $this->input->post('id_perkara');
		$no_perkara   = $this->input->post('no_perkara');
		$tgl_minutasi = $this->input->post('tgl_minutasi');
		$tgl_bht      = $this->input->post('tgl_bht');
		$tgl_putusan  = $this->input->post('tgl_putusan');
		$status       = $this->input->post('status');
		$pp           = $this->input->post('pp');

		
		if($status_input == 'add')
		{									
			
			$data_header = array(
				'no_perkara'    => $no_perkara,
				'tgl_minutasi'  => $tgl_minutasi,
				'tgl_bht'       => $tgl_bht,
				'tgl_putusan'   => $tgl_putusan,
				'status'        => $status,
				'pp'            => $pp,
			);

			$result_header = $this->db->insert('tr_perkara_bht', $data_header);

			return $result_header;
			
		}else{
			
			$id_perkara    = $this->input->post('id_perkara');
			
			$data_header = array(
				'no_perkara'    => $no_perkara,
				'tgl_minutasi'  => $tgl_minutasi,
				'tgl_bht'       => $tgl_bht,
				'tgl_putusan'   => $tgl_putusan,
				'status'        => $status,
				'pp'            => $pp,
			);

			$this->db->where('id_perkara', $id_perkara);
			$result_header = $this->db->update('tr_perkara_bht', $data_header);

			return $result_header;
			
		}
		
	}

}
