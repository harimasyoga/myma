<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu SOP Kepaniteraan Pidana - CodeIgniter 3
 * File: application/controllers/Sop_pidana.php
 * Mengikuti pola controller SOP Kepaniteraan Hukum.
 */
class Sop_pidana extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('Login'));
        }
    }

    public function index()
    {
        $this->List();
    }

    public function List()
    {
        $data = array('judul' => 'SOP Kepaniteraan Pidana');

        $this->load->view('header', $data);
        $this->load->view('Sop_pidana/v_sop_pidana', $data);
        $this->load->view('footer');
    }

    public function load_data()
    {
        $this->output->set_content_type('application/json');

        $rows = $this->db
            ->select('id_sop, nomor_sop, judul_sop, halaman_sumber')
            ->from('sop_pidana')
            ->where('aktif', 1)
            ->order_by('urutan', 'ASC')
            ->get()->result();

        $data = array();
        $no = 1;

        foreach ($rows as $row) {
            $data[] = array(
                'no' => $no++,
                'id_sop' => (int) $row->id_sop,
                'nomor_sop' => $row->nomor_sop,
                'judul_sop' => $row->judul_sop,
                'halaman_sumber' => $row->halaman_sumber
            );
        }

        echo json_encode(array('data' => $data));
    }

    public function detail($id = null)
    {
        $this->output->set_content_type('application/json');

        if (!is_numeric($id) || (int) $id < 1) {
            $this->output->set_status_header(400);
            echo json_encode(array('status' => false, 'message' => 'ID SOP tidak valid.'));
            return;
        }

        $sop = $this->db
            ->where('id_sop', (int) $id)
            ->where('aktif', 1)
            ->get('sop_pidana')
            ->row_array();

        if (!$sop) {
            $this->output->set_status_header(404);
            echo json_encode(array('status' => false, 'message' => 'SOP tidak ditemukan.'));
            return;
        }

        $sop['tahapan'] = $this->db
            ->where('id_sop', (int) $id)
            ->order_by('nomor_urutan', 'ASC')
            ->get('sop_pidana_tahapan')
            ->result_array();

        echo json_encode(array('status' => true, 'data' => $sop));
    }
}
