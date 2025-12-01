<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Jobdesk extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_master');
	}

	
	function List()
	{
		$data = array(
			'judul' => "Jobdesk"
		);
		$this->load->view('header', $data);
		$this->load->view('Jobdesk/v_job', $data);
		$this->load->view('footer');
	}

	
	function Insert()
	{
		$jenis    = $this->input->post('jenis');
		$status   = $this->input->post('status');
		
		$result   = $this->m_master->$jenis($jenis, $status);
		echo json_encode($result);
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
		}else if ($jenis == "inv_beli") {			
			$query = $this->db->query("SELECT a.* FROM invoice_header_beli a
			ORDER BY id_header_beli desc,tgl_inv desc,id_header_beli")->result();

			$i               = 1;
			foreach ($query as $r) {

				$rinci_stok  = $this->db->query("SELECT*from invoice_header_beli a JOIN
				invoice_detail_beli b ON a.no_inv_beli=b.no_inv_beli
				WHERE a.no_inv_beli='$r->no_inv_beli'
				order by b.id_det_beli");

				if($rinci_stok->num_rows() == '1'){
					$nm_produk   = $rinci_stok->row()->nm_produk;
				}else{
					$no                  = 1;
					$nm_produk_result    = '';
					foreach($rinci_stok->result() as $row_po){
						$nm_produk_result .= '<b>'.$no.'.</b> '.$row_po->nm_produk.'<br>';
						$no ++;
					}
					$nm_produk   = $nm_produk_result;

				}

				// HITUNG NOMINAL

				$rinci_stok  = $this->db->query("SELECT*from invoice_header_beli a JOIN
				invoice_detail_beli b ON a.no_inv_beli=b.no_inv_beli
				WHERE a.no_inv_beli='$r->no_inv_beli'
				order by b.id_det_beli");

				$total_harga = 0;
				foreach ($rinci_stok->result() as $row_detail) 
				{
					$total_harga   += $row_detail->total_harga;
				}		

				$total_harga_ok = $total_harga;
				
				
				$total_all     = $total_harga_ok + $r->ongkir + $r->asuransi + $r->jasa ;

				$id             = "'$r->id_header_beli'";
				$no_inv_beli    = "'$r->no_inv_beli'";

				if($r->acc_owner=='N')
                {
                    $btn2   = 'btn-warning';
                    $i2     = '<i class="fas fa-lock"></i>';
                } else {
                    $btn2   = 'btn-success';
                    $i2     = '<i class="fas fa-check-circle"></i>';
                }
				
				if (in_array($this->session->userdata('username'), ['bumagda','developer']))
				{
					// $urll2 = "onclick=open_modal('$r->id_header_beli','$r->no_inv_beli')";
					$urll2 = "onclick=acc_inv('$r->no_inv_beli','$r->acc_owner')";
				} else {
					$urll2 = '';
				}
					
				$row    = array();
				$row[]  = '<div class="text-center">'.$i.'</div>';
				$row[] = '<table>
					<tr style="background: transparent !important">
						<td style="border:0;padding:0 0 3px;font-weight:bold">No Inv</td>
						<td style="border:0;padding:0 5px 3px;font-weight:bold">:</td>
						<td style="border:0;padding:0 0 3px">'.$r->no_inv_beli.'</td>
					</tr>
					<tr style="background: transparent !important">
						<td style="border:0;padding:0 0 3px;font-weight:bold">Penjual</td>
						<td style="border:0;padding:0 5px 3px;font-weight:bold">:</td>
						<td style="border:0;padding:0 0 3px">'.$r->nm_penjual.'</td>
					</tr>
					<tr style="background: transparent !important">
						<td style="border:0;padding:0 0 3px;font-weight:bold">Pembeli</td>
						<td style="border:0;padding:0 5px 3px;font-weight:bold">:</td>
						<td style="border:0;padding:0 0 3px">'.$r->nm_pembeli.'</td>
					</tr>
				</table>';
				$row[]  = '<div class="text-center">'.$r->tgl_inv.'</div>';
				$row[]  = '<div class="text-center"><b>Rp'.number_format($total_all, 0, ",", ".").'</b></div>';

				
				$row[]  = '<div class="text-center">'.$nm_produk.'</div>';


				$row[]  = '
						<div class="text-center"><a style="text-align: center;" class="btn btn-sm '.$btn2.' " '.$urll2.' title="VERIFIKASI DATA" ><b>'.$i2.' </b> </a><span style="font-size:1px;color:transparent">'.$r->acc_owner.'</span><div>';

				$btncetak ='<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/Cetak_inv_beli2?no_inv_beli="."$r->no_inv_beli"."") . '" title="Cetak" ><i class="fas fa-print"></i> </a>';

				$btnEdit = '<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ',' . $no_inv_beli . ')" title="EDIT DATA" >
				<b><i class="fa fa-edit"></i> </b></a>';

				$btnHapus = '<button type="button" title="DELETE"  onclick="deleteData(' . $id . ',' . $no_inv_beli . ')" class="btn btn-danger btn-sm">
				<i class="fa fa-trash-alt"></i></button> ';
					
				if (in_array($this->session->userdata('level'), ['Admin','user','Keuangan1']))
				{
					if ($r->acc_owner == "N") 
					{						
						$row[] = '<div class="text-center">'.$btnEdit.' '.$btncetak.' '.$btnHapus.'</div>';
					}else{

						if($bayar->num_rows() == 0)
						{
							$row[] = '<div class="text-center">'.$btnEdit.' '.$btncetak.' '.$btnHapus.'</div>';
						}else{
							$row[] = '<div class="text-center">'.$btnEdit.' '.$btncetak.'</div>';

						}
						
						
					}

				}else{
					$row[] = '<div class="text-center"></div>';
				}
				
				$data[] = $row;
				$i++;
			} 
		 
		} else if ($jenis == "m_job") {
			$query = $this->m_master->query("SELECT * FROM m_job ORDER BY jns,urutan ")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();
				$row[] = '<div class="text-center"><a href="javascript:void(0)" onclick="tampil_edit('."'".$r->id_job."'".','."'detail'".')">'.$i.'<a></div>';
				$row[] = $r->nm_job;
				$row[] = strtoupper($r->jns);
				$row[] = $r->ket; 

				$btnEdit = '<button type="button" class="btn btn-warning btn-sm" onclick="tampil_edit('."'".$r->id_job."'".','."'edit'".')"><i class="fas fa-pen"></i></button>';

				$btnHapus = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteData('."'".$r->id_job."'".')"><i class="fas fa-times"></i></button>';
				
					$btnAksi = $btnEdit.' '.$btnHapus;
				$row[] = '<div class="text-center">'.$btnAksi.'</div>';
				$data[] = $row;
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
	

}
