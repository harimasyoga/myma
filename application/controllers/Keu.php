<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Keu extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_master');
		$this->load->model('M_keuangan');
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
	
	function List_minso()
	{
		$data = array(
			'judul' => "MINI SOCCER"
		);
		$this->load->view('header', $data);
		$this->load->view('Keuangan/v_minso', $data);
		$this->load->view('footer');
	}

	function load_data()
	{
		// $db2 = $this->load->database('database_simroll', TRUE);
		$jenis    = $this->uri->segment(3);
		$data     = array();

		if ($jenis == "m_minso")
		{
			// $blnn    = $_POST['blnn'];
			
			$query   = $this->db->query("SELECT * FROM trs_h_minso order by id_h_minso desc")->result();

			$i = 1;
			foreach ($query as $r) {

				$id   = "'$r->id_h_minso'";
				$ket_ = "'$r->ket'";
				
				// $print    = base_url("laporan/print_invoice_v2?no_invoice=") . $r->no_invoice;

				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="text-center" style="font-weight:bold;color:#f00">'.$r->urut.'</div>';
				$row[] = '<div class="text-center" style="font-weight:bold;color:#f00">'.$r->tgl.'</div>';
				
				$row[] = '<div class="text-center" style="font-weight:bold;color:#f00">'.$r->ket.'</div>';

				$row[] = '<div class="text-center" style="font-weight:bold;color:#f00">' . number_format($r->tot_masuk, 0, ",", ".") . ' </div>';

				$row[] = '<div class="text-center" style="font-weight:bold;color:#f00">' . number_format($r->tot_keluar, 0, ",", ".") . ' </div>';

				$aksi = "";

				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','ma']))
				{
					$aksi = '
						<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ')" title="EDIT DATA" >
							<b><i class="fa fa-edit"></i> </b>
						</a> 
						
						<button type="button" title="DELETE"  onclick="deleteData(' . $id . ','.$ket_.')" class="btn btn-danger btn-sm">
							<i class="fa fa-trash-alt"></i>
						</button> 

						<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/Cetak_Invoice?no_invoice=" . $r->id_h_minso . "") . '" title="CETAK" ><b><i class="fa fa-print"></i> </b></a>
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
		}else if($jenis=='edit_minso')
		{  				
			$queryh   = "SELECT*from trs_h_minso a join trs_d_minso b on a.id_h_minso=b.id_h_minso
			WHERE a.id_h_minso='$id'
			ORDER BY tgl desc,a.id_h_minso";
			
			$data_h   = $this->db->query($queryh)->row();

			$queryd   = "SELECT*from trs_d_minso WHERE id_h_minso='$id'
				order by nominal desc,id_d_minso";

		}else{

			$queryh   = "SELECT*FROM invoice_header a where a.id='$id' and a.no_invoice='$no'";
			$queryd   = "SELECT*FROM invoice_detail where no_invoice='$no' ORDER BY TRIM(no_surat) ";
		}
		

		$header   = $this->db->query($queryh)->row();
		$detail   = $this->db->query($queryd)->result();
		$data     = ["header" => $header, "detail" => $detail];

        echo json_encode($data);
	}

	
	function insert_minso()
	{
		if($this->session->userdata('username'))
		{ 
			$result = $this->M_keuangan->save_minso();
			echo json_encode($result);
		}
		
	}

	function hapus()
	{
		$jenis    = $_POST['jenis'];
		$field    = $_POST['field'];
		$id       = $_POST['id'];

		if ($jenis == "minso") 
		{
			$result          = $this->m_master->query("DELETE FROM trs_h_minso WHERE  $field = '$id'");

			$result          = $this->m_master->query("DELETE FROM trs_d_minso WHERE  $field = '$id'");

			
		} else {

			$result = $this->m_master->query("DELETE FROM $jenis WHERE  $field = '$id'");
		}

		echo json_encode($result);
	}

	function Cetak_minso()
	{
		$position   = 'P';
		$judul      = 'MINI SOCCER';
		$html       = '';
		$ctk        = $_GET['ctk'];
					
        $query_header = $this->db->query("SELECT*from trs_h_minso order by tgl, tot_masuk desc");
        
        $data = $query_header->row();
        
        $query_detail = $this->db->query("SELECT*from trs_h_minso order by tgl, tot_masuk desc");
		
		$html .= '<br>';


		$html .= "<table cellspacing=\"0\" style=\"font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;font-family: &quot;YACgEe79vK0 0&quot;, _fb_, auto;\" BORDER=\"0\">
		<tr>
			<td align=\"center\">
				<img src=\"" . base_url() . "assets/gambar/logo_mtw.jpeg\"  width=\"150\" height=\"140\" />
			</td>
		</tr>

		<tr>            
            <td style=\"color:#386fa4;font-size:40px;text-align:center;font-weight:bold\" >MINI SOCCER PN</td>            
        </tr>
		<tr>            
            <td style=\"color:#386fa4;font-size:15px;text-align:center;\" ></td>            
        </tr><br><br>
		";

        $html .= "</table> ";

		if ($query_header->num_rows() > 0) 
		{

			$html .= "<table width=\"100%\" border=\"1\" cellspacing=\"1\" cellpadding=\"3\" style=\"border-collapse:collapse;font-size:12px;font-family: ;\">
                        <tr style=\"background-color:#cccccc\">
							<th align=\"Center\" rowspan=\"2\">No</th>
							<th align=\"Center\" rowspan=\"2\">Tgl Transaksi</th>
							<th align=\"Center\" rowspan=\"2\">Keterangan</th>
							<th align=\"Center\" rowspan=\"2\">Jenis</th>
							<th align=\"Center\" colspan=\"2\" >Sparing</th>
							<th align=\"Center\" colspan=\"2\" >Internal</th>
						</tr>
						<tr style=\"background-color:#cccccc\">
							
							<th align=\"Center\">Masuk</th>
							<th align=\"Center\">Keluar</th>
							<th align=\"Center\">Masuk</th>
							<th align=\"Center\">Keluar</th>
						</tr>";
			
			$no                  = 1;
			$total_masuk         = 0;
			$total_keluar        = 0;
			$total_masuk_spar    = 0;
			$total_keluar_spar   = 0;
			foreach ($query_detail->result() as $r) 
			{
				if($r->jns == 'masuk_sparing')
				{
					$masuk_sparing   = $r->tot_masuk;
					$keluar_sparing  = 0;
					$masuk_internal  = 0;
					$keluar_internal = 0;
				
				}else if($r->jns == 'keluar_sparing')
				{
					$masuk_sparing   = 0;
					$keluar_sparing  = $r->tot_keluar;
					$masuk_internal  = 0;
					$keluar_internal = 0;
				
				}else if($r->jns == 'masuk'){

					$masuk_sparing   = 0;
					$keluar_sparing  = 0;
					$masuk_internal  = $r->tot_masuk;
					$keluar_internal = 0;

				}else{
					$masuk_sparing   = 0;
					$keluar_sparing  = 0;
					$masuk_internal  = 0;
					$keluar_internal = $r->tot_keluar;
				}

				$html .= '<tr>
						<td align="center">'.$no.'</td>
						<td align="center">'.$this->m_fungsi->tanggal_ind(substr($r->tgl,0,10)).'</td>
						<td align="left">' . $r->ket . '</td>
						<td align="left">' . $r->jns . '</td>
						<td align="right" style="background-color:#b2d2fa">Rp ' . number_format($masuk_sparing, 0, ",", ".") . '</td>
						<td align="right" style="background-color:#b2d2fa">Rp ' . number_format($keluar_sparing, 0, ",", ".") . '</td>
						<td align="right">Rp ' . number_format($masuk_internal, 0, ",", ".") . '</td>
						<td align="right">Rp ' . number_format($keluar_internal, 0, ",", ".") . '</td>
					</tr>';

					$no++;

				$total_masuk_spar   += $masuk_sparing;
				$total_keluar_spar  += $keluar_sparing;
				$total_masuk        += $masuk_internal;
				$total_keluar       += $keluar_internal;
			}

			$sisa_sparing    = $total_masuk_spar - $total_keluar_spar;
			$sisa_internal   = $total_masuk - $total_keluar;
			$sisa_all        = $sisa_sparing + $sisa_internal;

			$html .= '<tr>
						<td align="right" colspan="4" style="background-color:#cccccc"><b>TOTAL &nbsp;&nbsp;&nbsp;</b></td>
						
						<td align="right" style="background-color:#cccccc;color:#080b81" ><b>Rp '.number_format($total_masuk_spar, 0, ",", ".").'</b></td>

						<td align="right" style="background-color:#cccccc;color:#080b81" ><b>Rp '.number_format($total_keluar_spar, 0, ",", ".").'</b></td>

						<td align="right" style="background-color:#cccccc;color:#f00000"><b>Rp '.number_format($total_masuk, 0, ",", ".").'</b></td>

						<td align="right" style="background-color:#cccccc;color:#f00000"><b>Rp '.number_format($total_keluar, 0, ",", ".").'</b></td>
					</tr>';

			$html .= '<tr>
						<td align="right" colspan="4" style="background-color:#cccccc"><b>SISA &nbsp;&nbsp;&nbsp;</b></td>
						
						<td align="right" style="background-color:#cccccc; color:#080b81" colspan="2"><b>Rp '.number_format($sisa_sparing, 0, ",", ".").'</b></td>

						<td align="right" style="background-color:#cccccc;color:#f00000" colspan="2"><b>Rp '.number_format($sisa_internal, 0, ",", ".").'</b></td>
					</tr>';
			$html .= '<tr>
						<td align="right" colspan="4" style="background-color:#cccccc"><b>TOTAL SISA &nbsp;&nbsp;&nbsp;</b></td>
						
						<td align="right" style="background-color:#cccccc;" colspan="4"><b>Rp '.number_format($sisa_all, 0, ",", ".").'</b></td>
					</tr>';
			$html .= '</table>';
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

				$this->m_fungsi->_mpdf_hari2($position, 'A4', $judul, $html,$judul.'.pdf', 5, 5, 5, 5);
				
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
