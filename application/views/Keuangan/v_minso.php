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
									<th style="width:5%">URUT</th>
									<th style="width:15%">TGL</th>
									<th style="width:25%">KETERANGAN</th>
									<th style="width:20%">TOTAL MASUK</th>
									<th style="width:20%">TOTAL KELUAR</th>
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
						<div class="col-md-2">No Urut</div>
						<div class="col-md-3">
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="id_h_minso" id="id_h_minso">
							<input type="text" class="angka form-control" name="no_urut" id="no_urut" value ="" >
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-2">JENIS</div>
						<div class="col-md-3">
							<select id="jnss" name="jnss" class="form-control select2"> 
								<option value="masuk">MASUK INTERNAL</option>
								<option value="keluar">KELUAR INTERNAL</option>
								<option value="masuk_sparing">MASUK SPARING</option>
								<option value="keluar_sparing">KELUAR SPARING</option>
							</select>
						</div>
					</div>
										
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
											
						<div class="col-md-2">Keterangan</div>
						<div class="col-md-3">
							<input type="text" class="form-control" name="ket" id="ket" >
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-2">Tanggal Invoice</div>
						<div class="col-md-3">
							<input type="date" class="form-control" name="tgl_minso" id="tgl_minso" value ="<?= date('Y-m-d') ?>" >
						</div>
					</div>
					<br>
					
					<!-- detail PO-->
					<hr>
					<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
						<div class="col-md-4" style="padding-right:0">List Item Pembelian</div>
						<div class="col-md-8">&nbsp;
						</div>
					</div>


					<div style="overflow:auto;white-space:nowrap;" >
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_item" width="100%">
							<thead class="color-tabel">
								<tr>
									<th id="header_del">Delete</th>
									<th style="padding : 12px 50px">Transaksi</th>
									<th style="padding : 12px 50px" >Nominal</th>
								</tr>
							</thead>
							<tbody>
								<tr id="itemRow0">
									<td id="detail-hapus-0">
										<div class="text-center">
											<a class="btn btn-danger" id="btn-hapus-0" onclick="removeRow(0)">
												<i class="far fa-trash-alt" style="color:#fff"></i> 
											</a>
										</div>
									</td>
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<input type="text" size="5" name="ket_detail[0]" id="ket_detail0" class="form-control">
										</div>
									</td>		

									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>	
											<input type="text" size="5" name="nominal[0]" id="nominal0" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
												
										</div>
										
									</td>		
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2" class="text-right">
										<label for="total">TOTAL</label>
									</td>	
									<td>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="total_all" id="total_all" class="angka form-control" value='0' readonly>
										</div>
										
									</td>	
								</tr>
							</tfoot>
						</table>
						<div id="add_button" >
							<button type="button" onclick="addRow()" class="btn-tambah-produk btn  btn-success"><b><i class="fa fa-plus" ></i></b></button>
							<input type="hidden" name="bucket" id="bucket" value="0">
						</div>
						<br>
					</div>

					<!-- end detail PO-->

				
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
	
	function addRow() 
	{
		var b = $('#bucket').val();

		if (b == -1) {
			b = 0;
			rowNum = 0;
		}
		var ket         = $('#ket' + b).val();
		var nominal     = $('#nominal' + b).val();
			
		if (nominal != '0' && nominal != '' && ket != '') 
		{			
			rowNum++;
			var x = rowNum + 1;
			
				$('#table_list_item').append(
					`<tr id="itemRow${ rowNum }">
						<td id="detail-hapus-${ rowNum }">
							<div class="text-center">
								<a class="btn btn-danger" id="btn-hapus-${ rowNum }" onclick="removeRow(${ rowNum })">
									<i class="far fa-trash-alt" style="color:#fff"></i> 
								</a>
							</div>
						</td>
						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<input type="text" size="5" name="ket_detail[${ rowNum }]" id="ket_detail${ rowNum }" class="form-control">
							</div>
						</td>		

						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<div class="input-group-append">
									<span class="input-group-text"><b>Rp</b>
									</span>
								</div>	
								<input type="text" size="5" name="nominal[${ rowNum }]" id="nominal${ rowNum }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
									
							</div>
							
						</td>		
					</tr>
					`);
				$('#bucket').val(rowNum);
				$('#list' + rowNum).focus();
		}else{
			swal({
				title               : "Cek Kembali",
				html                : "Isi form diatas terlebih dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}
	}

	function removeRow(e) 
	{
		if (rowNum > 0) {
			jQuery('#itemRow' + e).remove();
			// rowNum--;
		} else {
			// toastr.error('Baris pertama tidak bisa dihapus');
			// return;

			swal({
					title               : "Cek Kembali",
					html                : "Baris pertama tidak bisa dihapus",
					type                : "error",
					confirmButtonText   : "OK"
				});
			return;
		}
		// $('#bucket').val(rowNum);
	}

	function clearRow() 
	{
		var bucket = $('#bucket').val();
		for (var e = bucket; e > 0; e--) {
			jQuery('#itemRow' + e).remove();
			rowNum--;
		}		
		$('#bucket').val(rowNum);
	}

	function hitung_total()
	{
		var total_nominal = 0
		for(loop = 0; loop <= rowNum; loop++)
		{
			var nom = $("#nominal"+loop).val()
			if(nom=='')
			{
				nom1 = 0;
			}else{
				nom1 = nom;
			}
			var nominal   = parseInt(nom1.split('.').join(''))
			total_nominal += nominal
		}		
		total_nominal_ok = (total_nominal=='' || isNaN(total_nominal) || total_nominal == null) ? 0 : total_nominal
		
		
		var total_all     = parseInt(total_nominal_ok)

		$("#total_all").val(format_angka(total_all))
		
	}
	

	function Cetak(ctk) 
	{
		// no_invoice = $("#no_invoice").val();
		var url = "<?= base_url('Keu/Cetak_minso'); ?>";
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
				"url": '<?php echo base_url(); ?>Keu/load_data/m_minso',
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
			url        : '<?= base_url(); ?>Keu/load_data_1',
			type       : "POST",
			data       : { id, jenis :'edit_minso' },
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
					$("#id_h_minso").val(data.header.id_h_minso);
					$("#no_urut").val(data.header.urut);
					// $("#jnss").val(data.header.jns).trigger('change');
					$("#jnss").val(data.header.jns).trigger('change');
 
					$("#jnss").prop("readonly", true); 
					$("#ket").val(data.header.ket);
					$("#tgl_minso").val(data.header.tgl);
					
					
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
					$.each(data.detail, function(index, val) {
						
						list += `
							<tr id="itemRow${ no }">
								<td id="detail-hapus-${ no }">
									<div class="text-center">
										<a class="btn btn-danger" id="btn-hapus-${ no }" onclick="removeRow(${ no })">
											<i class="far fa-trash-alt" style="color:#fff"></i> 
										</a>
									</div>
								</td>
								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<input type="text" size="5" name="ket_detail[${ no }]" id="ket_detail${ no }" class="form-control" value="${(val.ket_detail)}">
									</div>
								</td>		

								<td style="padding : 12px 20px">
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text"><b>Rp</b>
											</span>
										</div>	
										<input type="text" size="5" name="nominal[${ no }]" id="nominal${ no }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value="${format_angka(val.nominal)}">
											
									</div>
									
								</td>		
							</tr>
						`;
						no ++;
					})
					
					list +=`<tfoot>
								<tr>
									<td colspan="2" class="text-right">
										<label for="total">TOTAL</label>
									</td>	
									<td>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="total_all" id="total_all" class="angka form-control" value='0' readonly>
										</div>
										
									</td>	
								</tr>
							</tfoot>`;
					rowNum = no-1 
					$('#bucket').val(rowNum);					
					$("#table_list_item").html(list);
					hitung_total()	
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
		
		clearRow()
		hitung_total()
		
		swal.close()
	}

	function simpan() 
	{ 
		var id_h_minso    = $("#id_h_minso").val();
		var no_urut       = $("#no_urut").val();
		var jnss         = $("#jnss").val();
		var ket           = $("#ket").val();
		var tgl_minso     = $("#tgl_minso").val();
		
		if ( no_urut=='' || jnss=='' || ket== '' || tgl_minso =='') 
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
			url        : '<?= base_url(); ?>Keu/insert_minso',
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

	function deleteData(id,ket_) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS PEMBAYARAN",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong><b>" +ket_+ "</b> </strong> ",
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
					jenis      : 'minso',
					field      : 'id_h_minso'
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
