					<?php 
						error_reporting(0);
						$b=$brg->row_array();
						$satuan=$b['barang_satuan'];
					?>
					<table>
						<tr>
		                    <th style="width:200px;"></th>
		                    <th>Nama Barang/Keterangan</th>
		                    <th>Satuan</th>
		                    <th>Jumlah Beli</th>
		                    <th>Harga Beli</th>
		                </tr>
						<tr>
							<td style="width:200px;"></td>
							<td><input type="text" name="nabar" id="nabar" value="<?php echo htmlspecialchars($b['barang_nama']);?>" style="width:400px;margin-right:5px;" class="form-control input-sm" required></td>
		                    <td>
							<select name="satuan" style="width:120px;margin-right:5px;" class="form-control input-sm" required>
								<?php foreach ($units->result_array() as $units1) {
								$units_name=$units1['units_name'];
								$short_name=$units1['short_name'];
								if($short_name==$satuan)
									echo "<option value='$short_name' selected>$units_name ($short_name)</option>";
								else
									echo "<option value='$short_name'>$units_name ($short_name) </option>";
								}
							?>        
							</select>
							</td>
		                    <td><input type="text" name="jumlah" id="jumlah" style="width:90px;margin-right:5px;text-align:right;" class="form-control input-sm"  required></td>
							<td><input type="text" name="harbel" id="harbel" style="width:130px;margin-right:5px;text-align:right;" class="form-control input-sm" required></td>
		                    <td style="padding-right: 3px;"><button type="submit" class="btn btn-sm btn-primary">Ok</button></td>
							<td style="text-align:center;"><a href="#" class="btn btn-sm btn-primary" onclick="hideAndResetInput()"></span> Batal</a></td>
						</tr>
					</table>



<script type="text/javascript">	
$(document).ready(function() {
	$(document).on('input', 'input[name^="jumlah"]', function(e) {
		var inputValue = e.target.value;
		var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
		e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
	});
	$(document).on('input', 'input[name^="harbel"]', function(e) {
		var inputValue = e.target.value;
		var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
		e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
	});
	
	$('#harbel').blur(function() {
        var hargabeli = parseFloat($('#harbel').val().replace(/[^\d.,]/g, '')) || 0;
		var formattedHb = hargabeli.toLocaleString('id-ID');
		$('#harbel').val(formattedHb);
        //alert('Elemen kehilangan fokus.');
    });

});
</script>

<script type="text/javascript">
    function hideAndResetInput() {
        $('#detail_barang').hide();
		$("#kode_brg").focus();
    }
</script>

