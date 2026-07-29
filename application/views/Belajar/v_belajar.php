<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6"></div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right"></ol>
			</div>
			</div>
		</div>
	</section>

	<style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
	</style>

	<section class="content">
		<div class="card shadow mb-3">
			<div class="row-list">
				<div class="card-header" style="font-family:Cambria;">		
						<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
						</div>
				</div>
				<div class="card-body" >
					<?php if(in_array($this->session->userdata('level'), ['Admin','konsul_keu','ma'])){ ?>
						<div style="margin-bottom:12px">
							<button type="button" class="btn btn-sm btn-info" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>

							
							<button type="button" class="btn btn-sm btn-danger" id="modal_btn-print" onclick="Cetak(1)" ><i class="fas fa-print"></i> <b>Print</b></button>
							
						</div>
					<?php } ?>
					<div style="overflow:auto;">
						<table id="datatable" class="table table-bordered table-striped table-scrollable" width="100%">
							<thead class="color-tabel">
								<tr>
									<th style="width:5%">#</th>
									<th style="width:15%">JUDUL</th>
									<th style="width:10%">TGL</th>
									<th style="width:25%">DASAR HUKUM</th>
									<th style="width:35%">PENJELASAN</th>
									<th style="width:10%">AKSI</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>			
		</div>
	</section>

	<section class="content">

		<!-- Default box -->
		<div class="card shadow row-input" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>Input <?=$judul?></b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<form role="form" method="post" id="myForm">
				<div class="col-md-12">
								
					<br>
										
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
											
						<div class="col-md-2">JUDUL</div>
						<div class="col-md-9">
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="id_belajar" id="id_belajar">
							<textarea class="form-control"  name="judul" id="judul"></textarea>
						</div>
						<!-- <div class="col-md-1"></div> -->
					</div>

					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
											
						<div class="col-md-2">TANGGAL</div>
						<div class="col-md-3">
							<input type="date" class="form-control" name="tgl" id="tgl">
						</div>
						<div class="col-md-6"></div>
					</div>

									
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
											
						<div class="col-md-2">DASAR HUKUM</div>
						<div class="col-md-9">
							<textarea class="form-control"  name="dasar_hukum" id="dasar_hukum"></textarea>
						</div>
						<!-- <div class="col-md-1"></div> -->
					</div>


					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
											
						<div class="col-md-2">PENJELASAN</div>
						<div class="col-md-9">
							<textarea class="form-control"  name="penjelasan" id="penjelasan"></textarea>
						</div>
						<!-- <div class="col-md-1"></div> -->
					</div>

					<div class="card-body row"style="font-weight:bold">
						<div class="col-md-4">
							<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
								<i class="fa fa-chevron-left" ></i> Kembali</b>
							</button>

							<span id="btn-simpan"></span>

						</div>
						
						<div class="col-md-6"></div>
						
					</div>

					<br>
					
				</div>
			</form>	
		</div>
		<!-- /.card -->
	</section>
</div>

<script type="text/javascript">

	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		$('.select2').select2();
	});
	
	var rowNum = 0;
	

	function Cetak(ctk) 
	{
		// no_invoice = $("#no_invoice").val();
		var url = "<?= base_url('Belajar/Cetak_belajar'); ?>";
		window.open(url + '?ctk=' + ctk, '_blank');
		// window.open(url, '_blank');
	}

	function reloadTable() 
	{
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() 
	{
		var table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Belajar/load_data/tr_belajar',
				"type": "POST",
			},
			responsive: false,
			"pageLength": 25,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}
	
	function edit_data(id)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		$.ajax({
			url        : '<?= base_url(); ?>Belajar/load_data_1',
			type       : "POST",
			data       : { id, jenis :'edit_belajar' },
			dataType   : "JSON",
			beforeSend: function() {
				swal({
				title: 'loading data...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success: function(data) {
				if(data){ 
					// header
					$("#id_belajar").val(data.header.id_belajar);
					// $("#pilihan").val(data.header.pilihan).trigger('change');

					$("#judul").val(data.header.judul);
					$("#tgl").val(data.header.tgl);
					$("#dasar_hukum").val(data.header.dasar_hukum);
					$("#penjelasan").val(data.header.penjelasan);
					
					
					swal.close();
					// detail


				} else {

					swal.close();
					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal.close();
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		});
	}


	function kosong()
	{
		rowNum = 0
		$("input[name='pilihan'][value='YA']").prop("checked", true).trigger('change');
		$("#pil_job").val('');			
		$("#pil_job_text").val('');			
		$("#dasar_hukum").val('');			
		$("#syarat").val('');			
		$("#ket").val('');			
		$("#belajar").val('');			
		$("#error_log").val('');		
		
		
		swal.close()
	}

	function simpan() 
	{ 
		var id_belajar    = $("#id_belajar").val();
		var judul         = $("#judul").val();
		var tgl           = $("#tgl").val();
		var dasar_hukum   = $("#dasar_hukum").val();
		var penjelasan    = $("#penjelasan").val();
		
		if ( dasar_hukum =='' || penjelasan =='' || judul =='' ) 
		{
			swal({
				title               : "Cek Kembali",
				html                : "Harap Lengkapi Form Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		$.ajax({
			url        : '<?= base_url(); ?>Belajar/insert_belajar',
			type       : "POST",
			data       : $('#myForm').serialize(),
			dataType   : "JSON",
			beforeSend: function() {
				swal({
				title: 'loading ...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success: function(data) {
				if(data == true){
					// toastr.success('Berhasil Disimpan');						
					kosong();
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});
					kembaliList()
					
				} else {
					// toastr.error('Gagal Simpan');
					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
				reloadTable();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal.close();
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		});

	}

	function add_data()
	{
		kosong()
		$(".row-input").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$("#sts_input").val('add');
		
		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Simpan</b> </button>`)
	}

	function kembaliList()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none')
		$(".row-list").attr('style', '')
	}

	function deleteData(id,judul) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS DATA",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong><b>" +judul+ "</b> </strong> ",
			type               : "question",
			showCancelButton   : true,
			confirmButtonText  : '<b>Hapus</b>',
			cancelButtonText   : '<b>Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass  : 'btn btn-danger',
			cancelButtonColor  : '#d33'
		}).then(() => {

		// if (cek) {
			$.ajax({
				url: '<?= base_url(); ?>belajar/hapus',
				data: ({
					id         : id,
					jenis      : 'tr_belajar',
					field      : 'id_belajar'
				}),
				type: "POST",
				beforeSend: function() {
					swal({
					title: 'loading ...',
					allowEscapeKey    : false,
					allowOutsideClick : false,
					onOpen: () => {
						swal.showLoading();
					}
					})
				},
				success: function(data) {
					toastr.success('Data Berhasil Di Hapus');
					swal.close();

					// swal({
					// 	title               : "Data",
					// 	html                : "Data Berhasil Di Hapus",
					// 	type                : "success",
					// 	confirmButtonText   : "OK"
					// });
					reloadTable();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// toastr.error('Terjadi Kesalahan');
					swal({
						title               : "Cek Kembali",
						html                : "Terjadi Kesalahan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			});
		// }

		});


	}
</script>
