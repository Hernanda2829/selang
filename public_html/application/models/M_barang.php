<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_barang extends CI_Model{


	function getStokByCabang($requestData)	{
		$coid = $this->session->userdata('coid');
		$daftar_cabang = $this->db->where('reg_co_id', $coid)->get('regions')->result();

		$select_columns = 'b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama';
		$select_columns .= ", IFNULL(SUM(CASE WHEN s.stok_coid = '" . $daftar_cabang[0]->reg_co_id . "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
							SUM(CASE WHEN s.stok_coid = '" . $daftar_cabang[0]->reg_co_id . "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) AS stok_global";

		foreach ($daftar_cabang as $cabang) {
			$select_columns .= ", IFNULL(SUM(CASE WHEN s.stok_regid = '" . $cabang->reg_id . "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
							SUM(CASE WHEN s.stok_regid = '" . $cabang->reg_id . "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) AS stok_cabang_" . $cabang->reg_id;
		}

		$this->db->select($select_columns);
		$this->db->from('tbl_barang b');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $coid);
		//$this->db->limit($requestData['length'], $requestData['start']);
		$this->db->group_by('b.barang_id');
		$data = $this->db->get()->result();

		$no = $requestData['start'] + 1; // Hitung nomor urut
		foreach ($data as &$row) {
			$row->no = $no;
			$no++;
		}

		return $data;
	}

	function hitungTotalData() {
		return $this->db->count_all_results('tbl_barang');
	}

	function hitungFilteredData($requestData) {
		$this->db->select('COUNT(*) as count');
		$this->db->from('tbl_barang b');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $this->session->userdata('coid'));

		// Sesuaikan kondisi filter berdasarkan permintaan dari DataTables
		if (!empty($requestData['search']['value'])) {
			$this->db->group_start();
			$this->db->like('b.barang_id', $requestData['search']['value']);
			$this->db->or_like('b.barang_nama', $requestData['search']['value']);
			// Tambahkan kolom lain yang ingin Anda cari di sini
			$this->db->group_end();
		}

		$query = $this->db->get();
		return $query->row()->count;
	}


	function get_stok_cabang($idbrg) {
		//$daftar_cabang = $this->db->get('regions')->result();
		$coid=$this->session->userdata('coid');
		$daftar_cabang = $this->db->where('reg_co_id', $coid)->get('regions')->result();
		$select_columns = 'b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama, b.barang_kategori_id';
		//Tambahkan kolom stok_global di luar loop cabang
		$select_columns .= ", 
			IFNULL(
				SUM(CASE WHEN s.stok_coid = '" . $daftar_cabang[0]->reg_co_id . "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
				SUM(CASE WHEN s.stok_coid = '" . $daftar_cabang[0]->reg_co_id . "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
			AS stok_global";

		foreach ($daftar_cabang as $cabang) {
			$select_columns .= ", 
				IFNULL(
					SUM(CASE WHEN s.stok_regid = '" . $cabang->reg_id . "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
					SUM(CASE WHEN s.stok_regid = '" . $cabang->reg_id . "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
				AS stok_cabang_" . $cabang->reg_id;
		}

		$this->db->select($select_columns);
		$this->db->from('tbl_barang b');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		//$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		$this->db->where('b.barang_id', $idbrg);
		$this->db->group_by('b.barang_id');
		return $this->db->get()->result();
	}

	function hapus_barang($kode){
		$hsl=$this->db->query("DELETE FROM tbl_barang where barang_id='$kode'");
		$hsl=$this->db->query("DELETE FROM tbl_stok where brg_id='$kode'");
		return $hsl;
	}

	function update_barang($kobar,$nabar,$diskon,$kat,$satuan,$harpok,$harjul,$stok_data){
		$user_id=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$coid=$this->session->userdata('coid');
		$katnama = ($result = $this->db->where('kategori_id', $kat)->get('tbl_kategori')->result()) ? $result[0]->kategori_nama : "null";
		$this->db->set('barang_nama', $nabar);
		$this->db->set('barang_disc_id', ($diskon == 0) ? null : $diskon);
		$this->db->set('barang_satuan', $satuan);
		$this->db->set('barang_harpok', $harpok);
		$this->db->set('barang_harjul', $harjul);
		$this->db->set('barang_tgl_last_update', date('Y-m-d H:i:s'));
		$this->db->set('barang_kategori_id', $kat);
		$this->db->set('barang_kategori_nama', $katnama);
		$this->db->set('barang_user_id', $user_id);
		$this->db->set('updated_by', $user_nama);
		$this->db->set('updated_at', 'NOW()', false);
		$this->db->where('barang_id', $kobar);
		$hsl = $this->db->update('tbl_barang');
		//return $hsl;
		$stok_no = $this->get_stokno();
		//--insert tbl_stok
		foreach ($stok_data as $reg_id => $stok_info) {
		//Menyimpan pada tbl_stok jika nilai tidak 0 atau null
		if (!empty($stok_info['stok_value']) && $stok_info['stok_value'] != 0) {
			$stok_edit = array(
				'stok_no'       =>	$stok_no,
				'stok_ket'      =>	'Edit_Brg',
				'stok_status'   =>	$stok_info['stok_stat'],
				'stok_tgl'		=>	date('Y-m-d H:i:s'),
				'brg_id'        =>	$kobar,
				'brg_nama'      =>	$nabar,
				'brg_sat'       =>	$satuan,
				'brg_kat'       =>	$katnama,
				'stok_in'       =>	$stok_info['stok_in'], 
				'stok_out'      =>	$stok_info['stok_out'],
				'stok_user_id'  =>	$user_id,
				'stok_regid'    =>	$reg_id,
				'stok_coid'     =>	$coid,
				'created_by'    =>	$user_nama,
				'created_at'    =>	date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_stok', $stok_edit);
		}
		}
		return true;
	}

	function tambahbarang($kobar,$nabar,$diskon,$kat,$satuan,$harpok,$harjul,$stok_data){
		$user_id=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$coid=$this->session->userdata('coid');
		$katnama = ($result = $this->db->where('kategori_id', $kat)->get('tbl_kategori')->result()) ? $result[0]->kategori_nama : "null";
		$data = array(
			'barang_id' => $kobar,
			'barang_nama' => $nabar,
			'barang_disc_id' => ($diskon == 0) ? null : $diskon,
			'barang_satuan' => $satuan,
			'barang_harpok' => $harpok,
			'barang_harjul' => $harjul,
			'barang_tgl_input' => date('Y-m-d H:i:s'),
			'barang_kategori_id' => $kat,
			'barang_kategori_nama' => $katnama,
			'barang_user_id' => $user_id,
			'barang_co_id' => $coid,
			'created_by' => $user_nama,
			'created_at' => date('Y-m-d H:i:s')
		);
		$this->db->insert('tbl_barang', $data);
		//--add tbl_stok
		$stok_no = $this->get_stokno();
		foreach ($stok_data as $reg_id => $stok_value) {
        // Menyimpan pada tbl_stok jika nilai tidak 0 atau null
        //if (!empty($stok_value)) {
		if (!empty($stok_value) && $stok_value != 0) {
            $stok_in = array(
                'stok_no'       =>	$stok_no,
                'stok_ket'      =>	'Add_Brg',
                'stok_status'   =>	'in',
				'stok_tgl'		=>	date('Y-m-d H:i:s'),
                'brg_id'        =>	$kobar,
                'brg_nama'      =>	$nabar,
                'brg_sat'       =>	$satuan,
                'brg_kat'       =>	$katnama,
                'stok_in'       =>	$stok_value,
                'stok_out'      =>	0,
                'stok_user_id'  =>	$user_id,
				'stok_regid'    =>	$reg_id,
                'stok_coid'     =>	$coid,
                'created_by'    =>	$user_nama,
                'created_at'    =>	date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_stok', $stok_in);
        }
    	}
		//--------------
		return true;
	}


	function tampil_barang(){
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
		$select_columns = 'b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama';
		$select_columns .= ", 
			IFNULL(
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
			AS stok_cabang";
		
		$this->db->select($select_columns);
		$this->db->from('tbl_barang b');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		$this->db->group_by('b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama');
		return $this->db->get();
	}

	function tampil_diskon(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT disc_id,disc_rate FROM tbl_discount where disc_co_id='$coid'");
		return $hsl;
	}

	function tampil_regions(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT reg_id,nick_name,reg_name FROM regions where reg_co_id='$coid' order by reg_id asc");
		return $hsl;
	}

	function tampil_units(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT units_id,units_name,short_name FROM units where units_co_id='$coid'");
		return $hsl;
	}

	function get_barang($kobar){
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
		$select_columns = 'b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama';
		$select_columns .= ", 
			IFNULL(
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
			AS stok_cabang";
		
		$this->db->select($select_columns);
		$this->db->from('tbl_barang b');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		$this->db->where('b.barang_id', $kobar); // Tambahkan kondisi where untuk barang_id yang diinginkan
		$this->db->group_by('b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama');
		return $this->db->get();
	}

	function cekkobar($kobar) {
    $query = $this->db->query("SELECT barang_id FROM tbl_barang WHERE barang_id='$kobar'");
    return $query->num_rows();
	}


	function get_discount($disc_id){
		$hsl=$this->db->query("SELECT * FROM tbl_discount where disc_id='$disc_id'");
		return $hsl;
	}

	function get_stokno(){
		$q = $this->db->query("SELECT MAX(RIGHT(stok_no,6)) AS kd_max FROM tbl_stok WHERE DATE(stok_tgl)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        //return date('dmy').$kd;
		return "B".date('dmy').$kd;
	}

}