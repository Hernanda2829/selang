					<?php 
						error_reporting(0);
						$b=$brg->row_array();
					?>
					<table id="tbl_detail">
						<tr>
		                    <th style="width:200px;"></th>
		                    <th>Nama Barang</th>
		                    <th>Satuan</th>
		                    <th>Harga Pokok(Rp)</th>
		                    <th>Jumlah</th>
		                    <th>Keterangan</th>
		                </tr>
						<tr>
							<td style="width:200px;"></td>
							<td><input type="text" name="nabar" value="<?php echo htmlspecialchars($b['barang_nama']);?>" style="width:300px;margin-right:5px;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" name="satuan" value="<?php echo $b['barang_satuan'];?>" style="width:80px;margin-right:5px;text-align:center;" class="form-control input-sm" readonly></td>
							<td><input type="text" name="harpok" value="<?php echo number_format($b['barang_harpok'],0, ',' ,'.');?>" style="width:120px;margin-right:5px;text-align:right;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" name="qty" id="qty" value="1" min="1" class="form-control input-sm" style="width:90px;margin-right:5px;text-align:right;" required></td>
		                    <td><input type="text" name="keterangan" id="keterangan" class="form-control input-sm" style="width:200px;margin-right:5px;" required></td>
		                    <td style="padding-right: 3px;"><button type="submit" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span> Retur</button></td>
							<td style="text-align:center;"><button type="button" name="batal" id="batal" class="btn btn-sm btn-info"><span class="fa fa-close"></span> Batal</button></td>
						</tr>
					</table>
					
<script type="text/javascript">	
$(document).on('input', 'input[name^="qty"]', function(e) {
    var inputValue = e.target.value;
    var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); 
    e.target.value = sanitizedValue;
});

// Aksi ketika tombol batal diklik
	$('#batal').on('click', function() {
		$('#tbl_detail').empty();
		$('input[name="kode_brg"]').focus();
	});
</script>