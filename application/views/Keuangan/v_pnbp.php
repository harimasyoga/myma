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
									<th style="width:5%">ID</th>
									<th style="width:25%">NO SURAT</th>
									<th style="width:15%">PEMOHON</th>
									<th style="width:20%">JENIS</th>
									<th style="width:20%">TGL</th>
									<th style="width:20%">PETUGAS</th>
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
						<div class="col-md-2">NAMA PEMOHON</div>
						<div class="col-md-3">
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="id_pnbp" id="id_pnbp">
							<input type="text" class="form-control" name="nm_pemohon" id="nm_pemohon" value ="" >
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-2">JENIS</div>
						<div class="col-md-3">
							<select id="jns" name="jns" class="form-control select2"> 
								<option value="1" selected>SURAT KETERANGAN</option>
								<option value="2">SURAT KUASA</option>
							</select>
						</div>
					</div>
										
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
											
						<div class="col-md-2">NO SURAT</div>
						<div class="col-md-3">
							<input type="text" class="form-control" name="no_surat" id="no_surat" >
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-2">Tanggal TTD</div>
						<div class="col-md-3">
							<input type="date" class="form-control" name="tgl" id="tgl" value ="<?= date('Y-m-d') ?>" >
						</div>
					</div>

							
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
											
						<div class="col-md-2">PETUGAS</div>
						<div class="col-md-3">
							<select id="nm_ttd" name="nm_ttd" class="form-control select2"> 
								<option value="Harimas" selected>Harimas</option>
								<option value="Dina">Dina</option>
							</select>
						</div>
						<div class="col-md-6"></div>
					</div>
					<br>
									
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
		var url = "<?= base_url('Keu/Cetak_pnbp'); ?>";
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
				"url": '<?php echo base_url(); ?>Keu/load_data/m_pnbp',
				"type": "POST",
			},
			responsive: false,
			"pageLength": 25,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}
	
	function kosong()
	{
		$tgl = '<?= date('Y-m-d') ?>'	
		rowNum = 0
		$("#no_urut").val(''); 
		$("#ket").val(''); 		
		$("#jnss").val('masuk').trigger('change').prop('disabled', false);	
 
		$("#tgl_minso").val($tgl)  
 
		$("#ket_detail0").val('');			
		$("#nominal0").val(0);		
		
		
		swal.close()
	}

	
	function edit_data(id)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		$.ajax({
			url        : '<?= base_url(); ?>Keu/load_data_1',
			type       : "POST",
			data       : { id, jenis :'edit_pnbp' },
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

					$("#id_pnbp").val(data.header.id_pnbp);
					$("#nm_pemohon").val(data.header.nm_pemohon);
					$("#no_surat").val(data.header.no_surat);
					// $("#jnss").val(data.header.jns).trigger('change');
					$("#jns").val(data.header.jns).trigger('change');
 
					$("#tgl").val(data.header.tgl);
					$("#nm_ttd").val(data.header.nm_ttd);
					
					
					swal.close();
					// detail

					var list = `
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_item" width="100%">
							<thead class="color-tabel">
								<tr>
									<th id="header_del">Delete</th>
									<th style="padding : 12px 50px">Transaksi</th>
									<th style="padding : 12px 50px" >Nominal</th>
								</tr>
							</thead>`;
						
					var no   = 0;
					
					$('#bucket').val(rowNum);					
					$("#table_list_item").html(list);
					swal.close();

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


	function simpan() 
	{ 
		var id_pnbp       = $("#id_pnbp").val();
		var nm_pemohon    = $("#nm_pemohon").val();
		var jns           = $("#jns").val();
		var no_surat      = $("#no_surat").val();
		var tgl           = $("#tgl").val();
		var nm_ttd        = $("#nm_ttd").val();
		
		if ( nm_pemohon=='' || jns=='' || no_surat== '' || tgl ==''|| nm_ttd =='') 
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
			url        : '<?= base_url(); ?>Keu/insert_pnbp',
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

	function deleteData(id,no_surat) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS DATA",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong><b>" +no_surat+ "</b> </strong> ",
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
				url: '<?= base_url(); ?>Keu/hapus',
				data: ({
					id         : id,
					jenis      : 'pnbp',
					field      : 'id_pnbp'
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
