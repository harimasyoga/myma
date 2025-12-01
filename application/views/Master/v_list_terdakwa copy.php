<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<!-- <h1><b>Data Master</b></h1> -->
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<!-- <li class="breadcrumb-item active"><a href="#">Sales</a></li> -->
					</ol>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="card">
			
			<div class="card-body">
				
				
				<div class="card-body row" style="padding:0 0 8px;font-weight:bold">
					
					<div class="col-md-2" style="padding-bottom:3px">
						<button type="button" style="font-family:Cambria;" class="tambah_data btn btn-info pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;<b>Tambah Data</b></button>

					</div>
					<div class="col-md-2" style="padding-bottom:3px">
						<select class="form-control select2" id="thnn" name="thnn" onchange="load_data()">
							<option selected value="all">-- SEMUA -- </option>
								
						<?php 
							$thang        = date("Y");
							$thang_maks   = 2012 ;
							$thang_min    = 1986 ;
							for ($th=$thang_maks ; $th>=$thang_min ; $th--)
							{ ?>

								<?php if ($th==$thang) { ?>

								<option selected value="<?= $th ?>"> <?= $thang ?> </option>
								
								<?php }else{ ?>
								
								<option value="<?= $th ?>"> <?= $th ?> </option>
								<?php } ?>
						<?php } ?>
						</select>
					</div>
					<!-- <div class="col-md-2" style="padding-bottom:3px">
						<select id="order_by" class="form-control select2" onchange="load_data()"> 
							<option value="all">-- ORDER BY --</option>
							<option value="exp_bc">EXPIRED BC</option>
							<option value="exp_faktur">EXPIRED FAKTUR</option>
							<option value="exp_resi">EXPIRED RESI</option>
							<option value="exp_inv_terima">EXPIRED INV TERIMA</option>
							<option value="exp_mutasi">EXPIRED MUTASI</option>
							<option value="exp_sj_balik">EXPIRED SJ BALIK</option>
							<option value="edit">EDIT TERAKHIR</option>
						</select>
					</div> -->
					<div class="col-md-8" style="padding-bottom:3px">
					</div>
				</div>
				<br><br>
				<!-- <div style="overflow:auto;white-space:nowrap"> -->
					<table id="datatable" class="table table-bordered table-striped">
						<thead class="color-tabel">
							<tr>
								<th style="width:10%">#</th>
								<th style="width:10%">NO PERKARA</th>
								<th style="width:30%">NAMA</th>
								<th style="width:20%">TTL</th>
								<th style="width:10%">TH PERKARA</th>
								<th style="width:10%">AKSI</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				<!-- </div> -->
			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="judul"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table style="width:100%" cellspacing="5">
					<tr>
						<td style="border:0;padding:0"></td>
						<td style="border:0;padding:0"></td>
					</tr>
					<tr>
						<td style="font-weight:bold">NO PERKARA</td>
						<td>
							<input type="hidden" id="id_peg">
							<input class="form-control" type="text" name="no_perkara" id="no_perkara" autocomplete="off">
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold">NAMA</td>
						<td>
							<input class="form-control" type="text" name="nm_terdakwa" id="nm_terdakwa" autocomplete="off">
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold">TTL</td>
						<td>
							<input class="form-control" type="text" name="ttl" id="ttl" autocomplete="off">
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold">TH PERKARA</td>
						<td>
							<input class="form-control" type="text" name="th_perkara" id="th_perkara" autocomplete="off">
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save"></i> Simpan</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	status = "insert";
	$(document).ready(function() {
		load_data();
	});

	$(".tambah_data").click(function(event) {
		status = "insert"
		kosong();
		$("#judul").html('<h3> Form Tambah Data</h3>');
		$("#modalForm").modal("show");
	});

	function kosong(){
		status = "insert"
		$("#nm_peg").val("")
		$("#nip").val("")
		$("#jabatan").val("")
		$("#btn-simpan").prop("disabled", false);
	}

	function simpan(){
		$("#btn-simpan").prop("disabled", true);
		let id_peg = $("#id_peg").val()
		let nm_peg = $("#nm_peg").val()
		let nip = $("#nip").val()
		let jabatan = $("#jabatan").val()

		if(nm_peg == "" || nip == "" || jabatan == ""){
			toastr.info('Harap Lengkapi Form');
			return;
		}

		// alert(nm_sales+" - "+no_hp+" - "+status)
		$.ajax({
			url: '<?php echo base_url('Master/Insert/')?>'+status,
			type: "POST",
			data: ({
				id_peg, nm_peg, nip, jabatan, jenis: "m_pegawai", status
			}),
			success: function(json){
				data = JSON.parse(json)
				if(data){
					toastr.success('Berhasil Disimpan');
					kosong();
					$("#modalForm").modal("hide");
				}else{
					toastr.error('Gagal Simpan!');
				}
				reloadTable()
			},
			error: function(jqXHR, textStatus, errorThrown) {
				toastr.error('Terjadi Kesalahan')
			}
		})
	}

	function load_data() 
	{
		
		var thnn    = $('#thnn').val();
		var table   = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Master/load_data/terdakwa_lama',
				"type": "POST",
				data  : ({thnn}), 
			},
			responsive: false,
			"pageLength": 25,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function tampil_edit(id, act) {
		kosong();
		$("#modalForm").modal("show");
		if (act == 'detail') {
			$("#judul").html('<h3> Detail Data</h3>');
			$("#btn-simpan").hide();
		} else {
			$("#judul").html('<h3> Form Edit Data</h3>');
			$("#btn-simpan").show();
		}
		$("#jenis").val('Update');

		status = "update";

		$.ajax({
			url: '<?php echo base_url('Master/get_edit'); ?>',
			type: 'POST',
			data: ({
				id,
				jenis: 'm_terdakwa_lama',
				field: 'id_terdakwa',
			})
		})
		.done(function(json) {
			data = JSON.parse(json)
			// console.log(data)
			$("#id_terdakwa").val(data.id_terdakwa);
			$("#no_perkara").val(data.no_perkara);
			$("#nm_terdakwa").val(data.nm_terdakwa);
			$("#ttl").val(data.ttl);
			$("#th_perkara").val(data.th_perkara);
		})
	}

	function deleteData(id) {
		let cek = confirm("Apakah Anda Yakin?");
		if (cek) {
			$.ajax({
				url: '<?php echo base_url(); ?>Master/hapus',
				type: "POST",
				data: ({
					id,
					jenis: 'm_terdakwa_lama',
					field: 'id_terdakwa'
				}),
				success: function(data) {
					toastr.success('Data Berhasil Di Hapus');
					reloadTable();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					toastr.error('Terjadi Kesalahan');
				}
			});
		}else{
			toastr.info('Gak Jadi');
		}
	}

</script>
