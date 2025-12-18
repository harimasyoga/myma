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
		.box-input {
		border: 1px solid #d1d3e2;
		border-radius: 6px;
		padding: 15px;
		background-color: #fff;
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
									<th style="width:5%">No</th>
									<th style="width:25%">TAHUN</th>
									<th style="width:25%">NO BOX1</th>
									<th style="width:15%">NO BOX2</th>
									<th style="width:25%">NO BOX3</th>
									<th style="width:25%">NO BOX4</th>
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
				<br>
				<div class="row">
					<div class="col-md-6">
						<div class="box-input">
							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
								<div class="col-md-4" style="color:red">LABEL 1</div>
								<div class="col-md-8">
									<input type="hidden" name="sts_input" id="sts_input">
									<input type="hidden" name="id_label" id="id_label">
									<label>
										<input type="radio" id="pilihan1" name="pilihan1" value="PIDANA" onclick="pilihan1('PIDANA')" checked> PIDANA
									</label>&nbsp;&nbsp; || &nbsp;&nbsp;
									<label>
										<input type="radio" id="pilihan1" name="1" value="PERDATA" onclick="pilihan1('PERDATA')"> PERDATA
									</label>
								</div>
								<!-- <div class="col-md-1"></div> -->
							</div>
								
							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
													
								<div class="col-md-4">TAHUN</div>
								<div class="col-md-8">
									<select class="form-control select2" id="thnn1" name="thnn1">
										<!-- <option selected value="all">-- SEMUA -- </option> -->
											
									<?php 
										$thang        = date("Y");
										$thang_maks   = $thang+1 ;
										$thang_min    = $thang-5 ;
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
								<!-- <div class="col-md-1"></div> -->
							</div>

											
							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
													
								<div class="col-md-4">NO BOX</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="no_box1" id="no_box1">
								</div>
								<!-- <div class="col-md-1"></div> -->
							</div>


							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
													
								<div class="col-md-4">NO PERKARA</div>
								<div class="col-md-8">
									<textarea class="form-control"  name="no_perkara1" id="no_perkara1"></textarea>
								</div>
								<!-- <div class="col-md-1"></div> -->
							</div>
						</div>

						
					</div>
					
					<div class="col-md-6">
						<div class="box-input">
							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
								<div class="col-md-4" style="color:red">LABEL 2</div>
								<div class="col-md-8">
									<label>
										<input type="radio" id="pilihan2" name="pilihan2" value="PIDANA" onclick="pilihan2('PIDANA')" checked> PIDANA
									</label>&nbsp;&nbsp; || &nbsp;&nbsp;
									<label>
										<input type="radio" id="pilihan2" name="pilihan2" value="PERDATA" onclick="pilihan2('PERDATA')"> PERDATA
									</label>
								</div>
								<!-- <div class="col-md-1"></div> -->
							</div>
								
							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
													
								<div class="col-md-4">TAHUN</div>
								<div class="col-md-8">
									<select class="form-control select2" id="thnn2" name="thnn2" onchange="load_data()">
										<!-- <option selected value="all">-- SEMUA -- </option> -->
											
									<?php 
										$thang        = date("Y");
										$thang_maks   = $thang+1 ;
										$thang_min    = $thang-5 ;
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
								<!-- <div class="col-md-1"></div> -->
							</div>

											
							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
													
								<div class="col-md-4">NO BOX</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="no_box2" id="no_box2">
								</div>
								<!-- <div class="col-md-1"></div> -->
							</div>


							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
													
								<div class="col-md-4">NO PERKARA</div>
								<div class="col-md-8">
									<textarea class="form-control"  name="no_perkara2" id="no_perkara2"></textarea>
								</div>
								<!-- <div class="col-md-1"></div> -->
							</div>
						</div>

						
					</div>
					
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="box-input">
							<br>
							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
								<div class="col-md-4" style="color:red">LABEL 3</div>
								<div class="col-md-8">
									<label>
										<input type="radio" id="pilihan3" name="pilihan3" value="PIDANA" onclick="pilihan3('PIDANA')" checked> PIDANA
									</label>&nbsp;&nbsp; || &nbsp;&nbsp;
									<label>
										<input type="radio" id="pilihan3" name="pilihan3" value="PERDATA" onclick="pilihan3('PERDATA')"> PERDATA
									</label>
								</div>
								<!-- <div class="col-md-1"></div> -->
							</div>
								
							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
													
								<div class="col-md-4">TAHUN</div>
								<div class="col-md-8">
									<select class="form-control select2" id="thnn3" name="thnn3" onchange="load_data()">
										<!-- <option selected value="all">-- SEMUA -- </option> -->
											
									<?php 
										$thang        = date("Y");
										$thang_maks   = $thang+1 ;
										$thang_min    = $thang-5 ;
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
								<!-- <div class="col-md-1"></div> -->
							</div>

											
							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
													
								<div class="col-md-4">NO BOX</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="no_box3" id="no_box3">
								</div>
								<!-- <div class="col-md-1"></div> -->
							</div>


							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
													
								<div class="col-md-4">NO PERKARA</div>
								<div class="col-md-8">
									<textarea class="form-control"  name="no_perkara3" id="no_perkara3"></textarea>
								</div>
								<!-- <div class="col-md-1"></div> -->
							</div>
						</div>

						
					</div>
					
					<div class="col-md-6">
						<div class="box-input">
							<br>
							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
								<div class="col-md-4" style="color:red">LABEL 4</div>
								<div class="col-md-8"> 
									<label>
										<input type="radio" id="pilihan4" name="pilihan4" value="PIDANA" onclick="pilihan4('PIDANA')" checked> PIDANA
									</label>&nbsp;&nbsp; || &nbsp;&nbsp;
									<label>
										<input type="radio" id="pilihan4" name="pilihan4" value="PERDATA" onclick="pilihan4('PERDATA')"> PERDATA
									</label>
								</div>
								<!-- <div class="col-md-1"></div> -->
							</div>
								
							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
													
								<div class="col-md-4">TAHUN</div>
								<div class="col-md-8">
									<select class="form-control select2" id="thnn4" name="thnn4" onchange="load_data()">
										<!-- <option selected value="all">-- SEMUA -- </option> -->
											
									<?php 
										$thang        = date("Y");
										$thang_maks   = $thang+1 ;
										$thang_min    = $thang-5 ;
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
								<!-- <div class="col-md-1"></div> -->
							</div>

											
							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
													
								<div class="col-md-4">NO BOX</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="no_box4" id="no_box4">
								</div>
								<!-- <div class="col-md-1"></div> -->
							</div>


							<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
													
								<div class="col-md-4">NO PERKARA</div>
								<div class="col-md-8">
									<textarea class="form-control"  name="no_perkara4" id="no_perkara4"></textarea>
								</div>
								<!-- <div class="col-md-1"></div> -->
							</div>
						</div>

						
					</div>
					
				</div>

				<br>

				
				
				<div class="card-body row"style="font-weight:bold">
					<div class="col-md-4">
						<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
							<i class="fa fa-chevron-left" ></i> Kembali</b>
						</button>

						<span id="btn-simpan"></span>

					</div>
					
					<div class="col-md-1"></div>
					
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
		var url = "<?= base_url('Tutorial/Cetak_tutor'); ?>";
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
				"url": '<?php echo base_url(); ?>Lain/load_data/label',
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
			url        : '<?= base_url(); ?>Lain/load_data_1',
			type       : "POST",
			data       : { id, jenis :'edit_label' },
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
					$("#id_label").val(data.header.id_label);
					
					$("input[name='pilihan1'][value='" + data.header.pilihan1 + "']").prop("checked", true).trigger('change');

					$("#thnn1").val(data.header.thnn1).trigger('change');
					$("#no_box1").val(data.header.no_box1);
					$("#no_perkara1").val(data.header.no_perkara1);

					$("input[name='pilihan2'][value='" + data.header.pilihan2 + "']").prop("checked", true).trigger('change');

					$("#thnn2").val(data.header.thnn2).trigger('change');
					$("#no_box2").val(data.header.no_box2);
					$("#no_perkara2").val(data.header.no_perkara2);

					$("input[name='pilihan3'][value='" + data.header.pilihan3 + "']").prop("checked", true).trigger('change');

					$("#thnn3").val(data.header.thnn3).trigger('change');
					$("#no_box3").val(data.header.no_box3);
					$("#no_perkara3").val(data.header.no_perkara3);

					$("input[name='pilihan4'][value='" + data.header.pilihan4 + "']").prop("checked", true).trigger('change');

					$("#thnn4").val(data.header.thnn4).trigger('change');
					$("#no_box4").val(data.header.no_box4);
					$("#no_perkara4").val(data.header.no_perkara4);
					
					
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
		$("input[name='pilihan'][value='PIDANA']").prop("checked", true).trigger('change');
		$("#sts_input").val('');			
		$("#id_label").val('');			
		$("#pilihan1").val('PIDANA');			
		$("#pilihan2").val('PIDANA');			
		$("#pilihan3").val('PIDANA');			
		$("#pilihan4").val('PIDANA');	
		$("#no_box1").val('');	
		$("#no_perkara1").val('');	
		$("#no_box2").val('');	
		$("#no_perkara2").val('');	
		$("#no_box3").val('');	
		$("#no_perkara3").val('');	
		$("#no_box4").val('');	
		
		
		swal.close()
	}

	function simpan() 
	{ 
		var id_label    = $("#id_label").val();
		var pilihan1     = $("#pilihan1").val();
		var thnn1        = $("#thnn1").val();
		var no_box1      = $("#no_box1").val();
		var no_perkara1  = $("#no_perkara1").val();

		var pilihan2     = $("#pilihan2").val();
		var thnn2        = $("#thnn2").val();
		var no_box2      = $("#no_box2").val();
		var no_perkara2  = $("#no_perkara2").val();

		var pilihan3     = $("#pilihan3").val();
		var thnn3        = $("#thnn3").val();
		var no_box3      = $("#no_box3").val();
		var no_perkara3  = $("#no_perkara3").val();

		var pilihan4     = $("#pilihan4").val();
		var thnn4        = $("#thnn4").val();
		var no_box4      = $("#no_box4").val();
		var no_perkara4  = $("#no_perkara4").val();
		
		if ( pilihan1 =='' || thnn1 =='' || no_box1 =='' || no_perkara1 =='') 
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
			url        : '<?= base_url(); ?>Lain/insert_label',
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

	function deleteData(id,no) 
	{
		console.log(no)
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS PEMBAYARAN",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong><b>" +no+ "</b> </strong> ",
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
				url: '<?= base_url(); ?>Lain/hapus',
				data: ({
					id         : id,
					jenis      : 'tr_label',
					field      : 'id_label'
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
