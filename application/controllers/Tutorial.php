<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Tutorial extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_master');
		$this->load->model('M_transaksi');
	}

	
	function List()
	{
		$data = array(
			'judul' => "Tutorial"
		);
		$this->load->view('header', $data);
		$this->load->view('Tutorial/v_tutor', $data);
		$this->load->view('footer');
	}

	function load_data()
	{
		// $db2 = $this->load->database('database_simroll', TRUE);
		$jenis    = $this->uri->segment(3);
		$data     = array();

		if ($jenis == "Invoice") {
			
			$blnn    = $_POST['blnn'];
			$query   = $this->db->query("SELECT * FROM invoice_header
			-- where type in ('box','sheet') 
			where month(tgl_invoice) in ('$blnn')
			ORDER BY tgl_invoice desc,no_invoice")->result();

			$i               = 1;
			foreach ($query as $r) {

				$queryd = $this->db->query("SELECT  CASE WHEN type='roll' THEN
					SUM(harga*weight)
				ELSE
					SUM(harga*hasil)
				END AS jumlah
				FROM invoice_detail 
				WHERE no_invoice='$r->no_invoice' ")->row();

				$result_sj = $this->db->query("SELECT * FROM invoice_detail WHERE no_invoice='$r->no_invoice' GROUP BY trim(no_surat) ORDER BY no_surat");
				if($result_sj->num_rows() == '1'){
					$no_sj = $result_sj->row()->no_surat;
				}else{					
					$no_sj_result    = '';
					foreach($result_sj->result() as $row){
						$no_sj_result .= $row->no_surat.'<br>';
					}
					$no_sj = $no_sj_result;
				}
				
				if($r->type=='roll')
				{
					$hub =' PPI - ROLL ';
				}else{

					$result_hub = $this->db->query("SELECT b.*,d.aka FROM invoice_detail b
					join trs_po c on b.no_po=c.kode_po
					join m_hub d on c.id_hub=d.id_hub
					WHERE no_invoice='$r->no_invoice' GROUP BY d.aka");
					if($result_hub->num_rows() == '1'){
						if($result_hub->row()->aka == 'MMM')
						{
							$hub = 'PPI';
						}else{
							$hub = $result_hub->row()->aka;
						}
					}else{					
						$hub_result    = '';
						foreach($result_hub->result() as $row){
							$hub_result .= $row->aka.', ';
						}
						$hub = $hub_result;
					}
				}				

				$ppn11        = 0.11 * $queryd->jumlah;
				$pph22        = 0.001 * $queryd->jumlah;
				if($r->pajak=='ppn')
				{
					if($r->inc_exc=='Include')
					{
						$nominal    = 0;
					}else if($r->inc_exc=='Exclude')
					{				
						$nominal    = $ppn11;
					}else{
						$nominal    = 0;
					}

				}else if($r->pajak=='ppn_pph') {
					if($r->inc_exc=='Include')
					{
						$nominal    = 0;
					}else if($r->inc_exc=='Exclude')
					{				
						$nominal    = $ppn11 + $pph22;
					}else{
						$nominal    = 0;
					}

				}else{
					if($r->inc_exc=='Include')
					{
						$nominal    = 0;
					}else if($r->inc_exc=='Exclude')
					{
						$nominal    = $ppn11;
					}else{
						$nominal    = 0;
					}
				}

				if($r->acc_admin=='N')
                {
                    $btn1   = 'btn-warning';
                    $i1     = '<i class="fas fa-lock"></i>';
                } else {
                    $btn1   = 'btn-success';
                    $i1     = '<i class="fas fa-check-circle"></i>';
                }

				if($r->acc_owner=='N')
                {
                    $btn2   = 'btn-warning';
                    $i2     = '<i class="fas fa-lock"></i>';
                } else {
                    $btn2   = 'btn-success';
                    $i2     = '<i class="fas fa-check-circle"></i>';
                }

				$total    = $queryd->jumlah + $nominal;

				$id       = "'$r->id'";
				$no_inv   = "'$r->no_invoice'";
				$print    = base_url("laporan/print_invoice_v2?no_invoice=") . $r->no_invoice;

				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '
				
				<table>
					<tr style="background-color: transparent !important">
						<td style="padding : 2px;border:none;"><b>No Inv </td>
						<td style="padding : 2px;border:none;">:</td></b> 
						<td style="padding : 2px;border:none;">'.$r->no_invoice .'<br></td>
					</tr>
					<tr style="background-color: transparent !important">
						<td style="padding : 2px;border:none;"><b>Kepada </td>
						<td style="padding : 2px;border:none;">:</td></b> 
						<td style="padding : 2px;border:none;">'.$r->kepada .'<br></td>
					</tr>
					<tr style="background-color: transparent !important">
						<td style="padding : 2px;border:none;"><b>Cust </td>
						<td style="padding : 2px;border:none;">:</td></b> 
						<td style="padding : 2px;border:none;">'.$r->nm_perusahaan .'<br></td>
					</tr>
					<tr style="background-color: transparent !important">
						<td style="padding : 2px;border:none;"><b>HUB </td>
						<td style="padding : 2px;border:none;">:</td></b> 
						<td style="padding : 2px;border:none;">'.$hub .'<br></td>
					</tr>
					<tr style="background-color: transparent !important">
						<td style="padding : 2px;border:none;"><b>NO SJ </td>
						<td style="padding : 2px;border:none;">:</td></b> 
						<td style="padding : 2px;border:none;">'.$no_sj .'<br></td>
					</tr>
					';
				$row[] = '<div class="text-center" style="font-weight:bold;color:#f00">'.$r->tgl_invoice.'</div>';
				$row[] = '<div class="text-center" style="font-weight:bold;color:#f00">'.$r->tgl_jatuh_tempo.'</div>';
				$row[] = '<div class="text-right"><b>'.number_format($total, 0, ",", ".").'</b></div>';
				// Pembayaran
				$bayar = $this->db->query("SELECT SUM(jumlah_bayar) AS byr_jual from trs_bayar_inv where no_inv='$r->no_invoice' GROUP BY no_inv");

				if ($r->acc_owner == "N") 
				{
					$txtB            = 'btn-light';
					$txtT            = '-';
					$kurang_bayar    = '';
				}else{

					if($bayar->num_rows() == 0){
						$txtB           = 'btn-danger';
						$txtT           = 'BELUM BAYAR';
						$kurang_bayar   = '';
					}
					
					if($bayar->num_rows() > 0){
						if($bayar->row()->byr_jual == round($total)){
							$txtB            = 'btn-success';
							$txtT            = 'LUNAS';
							$kurang_bayar    = '';
						}else{
							$txtB            = 'btn-warning';
							$txtT            = 'DI CICIL';
							$kurang_bayar    = '<br><span style="color:#ff5733">'.number_format($total-$bayar->row()->byr_jual,0,',','.').'</span>';
						}
					}
				}
				$row[] = '<div class="text-center">
					<button type="button" class="btn btn-xs '.$txtB.'" style="font-weight:bold" >'.$txtT.'</button><br>
				</div>';

				if (in_array($this->session->userdata('username'), ['karina']))
				{
					// $urll1 = "onclick=acc_inv(`admin`,'$r->acc_admin','$r->no_invoice')";
					// $urll1 = "onclick=open_modal('$r->id','$r->no_invoice')";
					$urll1 = '';
					$urll2 = '';

				} else if (in_array($this->session->userdata('username'), ['bumagda','developer']))
				{
					$urll1 = '';
					// $urll2 = "onclick=acc_inv(`owner`,'$r->acc_owner','$r->no_invoice')";
					// $urll2 = "onclick=open_modal('$r->id','$r->no_invoice')";
					$urll2 = "onclick=acc_inv('$r->no_invoice','$r->acc_owner')";
				} else {
					$urll1 = '';
					$urll2 = '';
				}

				$row[] = '<div class="text-center">
				<button '.$urll1.' type="button" title="VERIFIKASI DATA" style="text-align: center;" class="btn btn-sm '.$btn1.' ">'.$i1.'</button>
				<span style="font-size:1px;color:transparent">'.$r->acc_admin.'</span><div>';
					
				$row[] ='<div class="text-center"><a style="text-align: center;" class="btn btn-sm '.$btn2.' " '.$urll2.' title="VERIFIKASI DATA" >
				<b>'.$i2.' </b> </a><span style="font-size:1px;color:transparent">'.$r->acc_owner.'</span><div>';

				$cek_pembayaran = $this->db->query("SELECT*FROM trs_bayar_inv WHERE no_inv='$r->no_invoice' ")->num_rows();
				$aksi = "";

				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','Keuangan1']))
				{
					if ($r->acc_owner == "N") 
					{

						if($cek_pembayaran > 0)
						{
							$aksi = '
							<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/Cetak_Invoice?no_invoice=" . $r->no_invoice . "") . '" title="CETAK" ><b><i class="fa fa-print"></i> </b></a>
							';

						}else{

							if (!in_array($this->session->userdata('username'), ['developer','karina']))
							{
								$aksi = '
								<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/Cetak_Invoice?no_invoice=" . $r->no_invoice . "") . '" title="CETAK" ><b><i class="fa fa-print"></i> </b></a>
								';

							}else{

								// $aksi = '
								// <a class="btn btn-sm btn-warning" href="' . base_url("Logistik/Invoice_edit?id=" .$r->id ."&no_inv=" .$r->no_invoice ."") . '" title="EDIT DATA" >
								// 	<b><i class="fa fa-edit"></i> </b>
								// </a> ';
								$aksi = '
								<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ',' . $no_inv . ')" title="EDIT DATA" >
									<b><i class="fa fa-edit"></i> </b>
								</a> 
								
								<button type="button" title="DELETE"  onclick="deleteData(' . $id . ',' . $no_inv . ')" class="btn btn-danger btn-sm">
									<i class="fa fa-trash-alt"></i>
								</button> 

								<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/Cetak_Invoice?no_invoice=" . $r->no_invoice . "") . '" title="CETAK" ><b><i class="fa fa-print"></i> </b></a>
								';

							}
						}
						
					} else {

						if($cek_pembayaran > 0)
						{
							$aksi = '
							<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/Cetak_Invoice?no_invoice=" . $r->no_invoice . "") . '" title="CETAK" ><b><i class="fa fa-print"></i> </b></a>
							';

						}else{

							if (!in_array($this->session->userdata('username'), ['developer','karina']))
							{

								$aksi = '								
								<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/Cetak_Invoice?no_invoice=" . $r->no_invoice . "") . '" title="CETAK" ><b><i class="fa fa-print"></i> </b></a>
								';

							}else{

								$aksi = '
								<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ',' . $no_inv . ')" title="EDIT DATA" >
									<b><i class="fa fa-edit"></i> </b>
								</a> 
								
								<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/Cetak_Invoice?no_invoice=" . $r->no_invoice . "") . '" title="CETAK" ><b><i class="fa fa-print"></i> </b></a>
								';
							}

						}
						
					}
				} else {
					$aksi = '';
				}
				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;

				$i++;
			}
		}else if ($jenis == "tr_tutorial") {
			// $blnn    = $_POST['blnn'];
			
			$query   = $this->db->query("SELECT a.*,(select nm_job from m_job b where a.pil_job=b.id_job)nm_job FROM tr_tutorial a order by id_tutor")->result();

			$i = 1;
			foreach ($query as $r) {

				$id             = "'$r->id_tutor'";
				$pil_job_text   = $r->pil_job_text;
				$nm_job         = $r->nm_job;
				$dasar_hukum    = substr($r->dasar_hukum,0,30).'...';
				$syarat         = substr($r->syarat,0,30).'...';
				$tutor          = substr($r->tutor,0,30).'...';
				$error_log      = substr($r->error_log,0,30).'...';
				
				if($nm_job =='')
				{
					$job_ok    = $pil_job_text ;
					$nm_job2   = "'$pil_job_text'";
				}else{
					$job_ok    = $nm_job ;
					$nm_job2   = "'$nm_job'";
				}
				
				// $print    = base_url("laporan/print_invoice_v2?no_invoice=") . $r->no_invoice;

				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="text-left" style="font-weight:bold;color:#f00">'.$job_ok.'</div>';
				$row[] = '<div class="text-center" style="font-weight:bold;">'.$dasar_hukum.'</div>';
				$row[] = '<div class="text-center" style="font-weight:bold;">'.$syarat.'</div>';
				
				$aksi = "";

				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','ma']))
				{
					$aksi = '
						<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ')" title="EDIT DATA" >
							<b><i class="fa fa-edit"></i> </b>
						</a> 
						
						<button type="button" title="DELETE"  onclick="deleteData(' . $id . ','.$nm_job2.' )" class="btn btn-danger btn-sm">
							<i class="fa fa-trash-alt"></i>
						</button> 

						<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Tutorial/Cetak_tutor?id_tutor=" . $r->id_tutor."&ctk=1") . '" title="CETAK" ><b><i class="fa fa-print"></i> </b></a>
						';
				} else {
					$aksi = '';
				}

				$row[]    = '<div class="text-center">'.$aksi.'</div>';
				$data[]   = $row;

				$i++;
			}
		}else{
			
		}

		$output = array(
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	
	function load_data_1()
	{
		$id       = $this->input->post('id');
		$no       = $this->input->post('no');
		$jenis    = $this->input->post('jenis');

		if($jenis=='byr_invoice')
		{
			$queryh   = "SELECT *,IFNULL((select sum(jumlah_bayar) from trs_bayar_inv t
			where t.no_inv=a.no_inv
			group by no_inv),0) jum_bayar, a.id_bayar_inv as id_ok FROM trs_bayar_inv a join invoice_header b on a.no_inv=b.no_invoice where b.no_invoice='$no' and a.id_bayar_inv='$id' ORDER BY id_bayar_inv";
			
			$queryd   = "SELECT*FROM invoice_detail where no_invoice='$no' ORDER BY TRIM(no_surat) ";
		}else if($jenis=='edit_tutor')
		{  				
			$queryh   = "SELECT a.*,(select nm_job from m_job b where a.pil_job=b.id_job)nm_job FROM tr_tutorial a where id_tutor='$id' order by id_tutor";
			
			$data_h   = $this->db->query($queryh)->row();

			$queryd   = "SELECT a.*,(select nm_job from m_job b where a.pil_job=b.id_job)nm_job FROM tr_tutorial a where id_tutor='$id' order by id_tutor";

		}else{

			$queryh   = "SELECT*FROM invoice_header a where a.id='$id' and a.no_invoice='$no'";
			$queryd   = "SELECT*FROM invoice_detail where no_invoice='$no' ORDER BY TRIM(no_surat) ";
		}
		

		$header   = $this->db->query($queryh)->row();
		$detail   = $this->db->query($queryd)->result();
		$data     = ["header" => $header, "detail" => $detail];

        echo json_encode($data);
	}

	function pilihan_job()
    {
        $query = $this->db->query("SELECT*FROM m_job order by jns, urutan")->result();

		// $query = $this->db->query("SELECT*FROM m_job  where id_job not in (select pil_job from tr_tutorial)  order by jns, urutan")->result();

            if (!$query) {
                $response = [
                    'message'	=> 'not found',
                    'data'		=> [],
                    'status'	=> false,
                ];
            }else{
                $response = [
                    'message'	=> 'Success',
                    'data'		=> $query,
                    'status'	=> true,
                ];
            }
            $json = json_encode($response);
            print_r($json);
    }
	
	function hapus()
	{
		$jenis    = $_POST['jenis'];
		$field    = $_POST['field'];
		$id       = $_POST['id'];

		if ($jenis == "tutor") 
		{
			$result          = $this->m_master->query("DELETE FROM tr_tutorial WHERE  $field = '$id'");
			
		} else {

			$result = $this->m_master->query("DELETE FROM $jenis WHERE  $field = '$id'");
		}

		echo json_encode($result);
	}

	function insert_tutor()
	{
		if($this->session->userdata('username'))
		{ 
			$result = $this->M_transaksi->save_tutor();
			echo json_encode($result);
		}
		
	}

	
	function Cetak_tutor()
	{
		
		$html       = '';
		$id_tutor   = $_GET['id_tutor'];
		// $ctk        = 0;
		$ctk        = $_GET['ctk'];

        $query_header = $this->db->query("SELECT a.*,(select nm_job from m_job b where a.pil_job=b.id_job)nm_job FROM tr_tutorial a where id_tutor='$id_tutor' order by id_tutor");
        
        $data = $query_header->row();
        
        $query_detail = $this->db->query("SELECT a.*,(select nm_job from m_job b where a.pil_job=b.id_job)nm_job FROM tr_tutorial a where id_tutor='$id_tutor' order by id_tutor");		

		
		$data_syarat = str_replace('
', "\n ", $data->syarat);

		$ket_ok = str_replace('
', "\n ", $data->ket);

		$dasar_hukum_ok = str_replace('
', "\n ", $data->dasar_hukum);
		

		$tutor_ok = str_replace('
', "\n ", $data->tutor);
		

		$error_log_ok = str_replace('
', "\n ", $data->error_log);
		
		if($data->nm_job =='')
		{
			$nm_job2   = $data->pil_job_text;
		}else{
			$nm_job2   = $data->nm_job;
		}
		
		$position   = 'P';
		$judul      = $nm_job2;

		
		$html = '<table style="margin-bottom:5px;border-collapse:collapse;vertical-align:top;width:100%;font-weight:bold;font-family:Tahoma">
			<tr>
				<th style="width:25%"></th>
				<th style="width:75%"></th>
			</tr>
			<tr>
				<td style="border:1;text-align:center" rowspan="2">
					<img src="'.base_url('assets/gambar/muara teweh.png').'" width="100" height="80">
				</td>
				<td style="border:1;font-size:30px;padding:19px 0 ;text-align:center" >'.$judul.'</td>
			</tr>
		</table>
		<br></br>';


		if ($query_header->num_rows() > 0) 
		{

			$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
			
				<tr style="background-color:#cccccc">
					<th align="Center">SYARAT</th>
					<th align="Center">KETERANGAN</th>
				</tr>
				<tr> 
					<td align="left" style="width:50%">'.nl2br(htmlspecialchars($data_syarat)).'</td>
					<td align="left" style="width:50%">'.nl2br(htmlspecialchars($ket_ok)).'</td>
				</tr>
			</table><br>';
			
			$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
			
				<tr style="background-color:#cccccc">
					<th align="Center">DASAR HUKUM</th>
				</tr>
				<tr> 
					<td align="left" style="width:100%">'.nl2br(htmlspecialchars($dasar_hukum_ok)).'</td>
				</tr>
			</table> <br>';

			$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
			
				<tr style="background-color:#cccccc">
					<th align="Center">TUTORIAL</th>
				</tr>
				<tr> 
					<td align="left" style="width:100%">'.nl2br(htmlspecialchars($tutor_ok)).'</td>
				</tr>
			</table>
			<br>';

			$html .= '<table width="100%" border="1" cellspacing="1" cellpadding="3" style="border-collapse:collapse;font-size:12px;font-family: ;">
			
				<tr style="background-color:#cccccc">
					<th align="Center">ERROR LOG</th>
				</tr>
				<tr> 
					<td align="left" style="width:100%">'.nl2br(htmlspecialchars($error_log_ok)).'</td>
				</tr>
			</table>';
						

		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		
		// $data['prev'] = $html;

		switch ($ctk) {
			case 0;
				echo ("<title>$judul</title>");
				echo ($html);
				break;

			case 1;

				// $this->m_fungsi->newMpdf($judul, '', $html, 10, 3, 3, 3, 'L', 'TT', $bln_judul.'.pdf');

				// $this->M_fungsi->_mpdf_hari('L', 'A4','AAA', $html, 'AAA.pdf', 5, 5, 5, 10,'','','','MINI SOCCER');

				$this->m_fungsi->_mpdf_hari2($position, 'A4', $judul, $html,$judul.'.pdf', 5, 5, 5, 10);
				
				// $this->m_fungsi->newMpdf('aa', '', $html, 5, 5, 5, 5, $position, 'TT', 'aa.pdf');
				break;

				
				
			case 2;
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd-ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('Master/master_cetak', $data);
				break;
		}
		
	}


}
