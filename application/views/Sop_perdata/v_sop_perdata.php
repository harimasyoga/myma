<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1 style="font-size:22px;">SOP Kepaniteraan Perdata</h1>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right"></ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card shadow mb-3">
            <div class="card-header">
                <h3 class="card-title" style="color:#4e73df;">
                    <b><?= html_escape(isset($judul) ? $judul : 'SOP Kepaniteraan Perdata'); ?></b>
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                        data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="alert alert-info">
                    Pilih salah satu SOP untuk melihat identitas dokumen, informasi pelaksanaan,
                    dan seluruh tahapan prosedur berdasarkan lembar SOP.
                </div>
                
                <div class="mb-3">
                    <a href="<?= base_url('assets/sop/SOP_2026_GABUNG.pdf'); ?>"
                    class="btn btn-primary"
                    target="_blank">
                        <i class="fas fa-file-pdf"></i> Lihat PDF SOP
                    </a>
                </div>
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped" width="100%">
                        <thead class="color-tabel">
                            <tr>
                                <th style="width:5%;">No.</th>
                                <th style="width:23%;">Nomor SOP</th>
                                <th>Nama SOP</th>
                                <th style="width:12%;">Halaman Sumber</th>
                                <th style="width:10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modalDetailSop" tabindex="-1" role="dialog" aria-labelledby="judulModalSop" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width:95%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulModalSop">Detail SOP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="loadingSop" class="text-center" style="display:none;">
                    <i class="fas fa-spinner fa-spin"></i> Memuat data SOP...
                </div>
                <div id="errorDetailSop" class="alert alert-danger" style="display:none;"></div>
                <div id="isiDetailSop" style="display:none;">
                    <div class="text-center mb-3">
                        <h4 id="dJudul" style="font-weight:bold;"></h4>
                        <div id="dNomor" style="font-weight:bold;"></div>
                    </div>

                    <table class="table table-bordered table-sm">
                        <tbody>
                            <tr><th style="width:25%;">Tanggal Pembuatan</th><td id="dPembuatan"></td></tr>
                            <tr><th>Tanggal Revisi</th><td id="dRevisi"></td></tr>
                            <tr><th>Tanggal Efektif</th><td id="dEfektif"></td></tr>
                            <tr><th>Pelaksana yang tercantum</th><td id="dPelaksana"></td></tr>
                            <tr><th>Keterkaitan</th><td id="dKeterkaitan"></td></tr>
                            <tr><th>Peringatan/Catatan</th><td id="dPeringatan"></td></tr>
                            <tr><th>Kualifikasi Pelaksana</th><td id="dKualifikasi"></td></tr>
                            <tr><th>Peralatan/Perlengkapan</th><td id="dPeralatan"></td></tr>
                            <tr><th>Pencatatan dan Pendataan</th><td id="dPencatatan"></td></tr>
                            <tr><th>Halaman Sumber</th><td id="dHalaman"></td></tr>
                        </tbody>
                    </table>

                    <h5 class="mt-4 mb-2"><b>Prosedur Pelaksanaan</b></h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="tabelTahapanSop">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:4%;">No.</th>
                                    <th style="width:27%;">Aktivitas</th>
                                    <th style="width:25%;">Persyaratan/Perlengkapan</th>
                                    <th style="width:9%;">Waktu</th>
                                    <th style="width:25%;">Output</th>
                                    <th style="width:10%;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div id="dCatatanTahapan" class="mt-3"></div>
                    <div class="text-muted small mt-2">
                        Catatan: kolom Dasar Hukum dan Unit Kerja tidak ditampilkan sesuai pengaturan menu.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
(function ($) {
    'use strict';

    var urlLoadSop = '<?= site_url('Sop_perdata/load_data'); ?>';
    var urlDetailSop = '<?= site_url('Sop_perdata/detail'); ?>';

    function safeText(value) {
        return (value === null || value === undefined || value === '') ? '-' : String(value);
    }

    function setText(selector, value) {
        $(selector).text(safeText(value));
    }

    $(document).ready(function () {
        if (!$.fn.DataTable) {
            $('#datatable tbody').html('<tr><td colspan="5" class="text-center text-danger">Plugin DataTables tidak ditemukan pada template.</td></tr>');
            return;
        }

        $('#datatable').DataTable({
            processing: true,
            ajax: {
                url: urlLoadSop,
                type: 'GET',
                dataSrc: 'data'
            },
            columns: [
                { data: 'no', className: 'text-center' },
                { data: 'nomor_sop' },
                { data: 'judul_sop' },
                { data: 'halaman_sumber', className: 'text-center' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function (data, type, row) {
                        return '<button type="button" class="btn btn-xs btn-info btn-detail-sop" data-id="' +
                            parseInt(row.id_sop, 10) + '"><i class="fas fa-eye"></i> Detail</button>';
                    }
                }
            ],
            pageLength: 25,
            ordering: false,
            autoWidth: false,
            language: {
                emptyTable: 'Belum ada data SOP.',
                processing: 'Memuat data...',
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                zeroRecords: 'Data tidak ditemukan',
                paginate: {
                    first: 'Awal',
                    last: 'Akhir',
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                }
            }
        });

        $('#datatable').on('click', '.btn-detail-sop', function () {
            var id = $(this).data('id');
            $('#errorDetailSop').hide().text('');
            $('#isiDetailSop').hide();
            $('#loadingSop').show();
            $('#modalDetailSop').modal('show');

            $.ajax({
                url: urlDetailSop + '/' + encodeURIComponent(id),
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    $('#loadingSop').hide();
                    if (!response || response.status !== true || !response.data) {
                        $('#errorDetailSop').text('Data detail SOP tidak tersedia.').show();
                        return;
                    }

                    var d = response.data;
                    setText('#dJudul', d.judul_sop);
                    setText('#dNomor', d.nomor_sop);
                    setText('#dPembuatan', d.tanggal_pembuatan);
                    setText('#dRevisi', d.tanggal_revisi);
                    setText('#dEfektif', d.tanggal_efektif);
                    setText('#dPelaksana', d.pelaksana);
                    setText('#dKeterkaitan', d.keterkaitan);
                    setText('#dPeringatan', d.peringatan_catatan);
                    setText('#dKualifikasi', d.kualifikasi_pelaksana);
                    setText('#dPeralatan', d.peralatan_perlengkapan);
                    setText('#dPencatatan', d.pencatatan_pendataan);
                    setText('#dHalaman', d.halaman_sumber);

                    var tbody = $('#tabelTahapanSop tbody');
                    tbody.empty();

                    if (d.tahapan && d.tahapan.length) {
                        $.each(d.tahapan, function (i, step) {
                            var tr = $('<tr>');
                            $('<td>').addClass('text-center').text(safeText(step.nomor_urutan)).appendTo(tr);

                            var activityCell = $('<td>');
                            $('<div>').addClass('sop-activity-text').text(safeText(step.aktivitas)).appendTo(activityCell);
                            if (step.pelaksana) {
                                $('<div>').addClass('sop-actor-label').text('Pelaksana: ' + step.pelaksana).appendTo(activityCell);
                            }
                            activityCell.appendTo(tr);

                            $('<td>').addClass('sop-cell-multiline').text(safeText(step.persyaratan_perlengkapan)).appendTo(tr);
                            $('<td>').addClass('text-center').text(safeText(step.waktu)).appendTo(tr);
                            $('<td>').addClass('sop-cell-multiline').text(safeText(step.output)).appendTo(tr);
                            $('<td>').addClass('sop-cell-multiline').text(safeText(step.keterangan)).appendTo(tr);
                            tbody.append(tr);
                        });
                    } else {
                        tbody.append('<tr><td colspan="6" class="text-center">Tahapan belum tersedia.</td></tr>');
                    }

                    $('#dCatatanTahapan').empty();
                    if (d.catatan_tahapan) {
                        $('<div>').addClass('alert alert-secondary mb-0')
                            .append($('<b>').text('Penjelasan pada kolom keterangan: '))
                            .append(document.createTextNode(d.catatan_tahapan))
                            .appendTo('#dCatatanTahapan');
                    }

                    $('#isiDetailSop').show();
                },
                error: function (xhr) {
                    $('#loadingSop').hide();
                    var pesan = 'Terjadi kesalahan saat mengambil detail SOP.';
                    if (xhr.status === 404) pesan = 'Data SOP tidak ditemukan.';
                    $('#errorDetailSop').text(pesan).show();
                }
            });
        });
    });
})(jQuery);
</script>


<style>
#isiDetailSop td, #tabelTahapanSop td { vertical-align: top; white-space: pre-line; overflow-wrap: anywhere; line-height: 1.45; }
#tabelTahapanSop { table-layout: fixed; width: 100%; font-size: 12px; }
#tabelTahapanSop th { vertical-align: middle; }
.sop-activity-text { font-weight: 600; white-space: pre-line; }
.sop-actor-label { margin-top: 6px; padding: 4px 6px; background: #f3f6f9; border-left: 3px solid #6c757d; color: #495057; font-size: 11px; font-weight: 600; white-space: pre-line; }
.sop-cell-multiline { white-space: pre-line; }
</style>
