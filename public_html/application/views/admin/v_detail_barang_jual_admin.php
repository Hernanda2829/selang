					<?php 
						error_reporting(0);
						// error_reporting(E_ALL);
    					// ini_set('display_errors', 1);
						$b=$brg->row_array();
						$stok=$b['stok_cabang'];
						$d=$disc->row_array();
						//var_dump($d);

						//--------stok cabang-------//
						if (floor($stok) == $stok) {
							$formatted_stok = number_format($stok, 0, ',', '.');
						} else {
							$formatted_stok = number_format($stok, 2, ',', '.');
							$formatted_stok = rtrim($formatted_stok, '0');
							$formatted_stok = rtrim($formatted_stok, ',');
						}   
						//-------stok cabang
					?>
					<table id='tbl_detail'>
						<tr>
		                    <th style="width:200px;"></th>
		                    <th>Nama Barang</th>
		                    <th>Satuan</th>
		                    <th>Stok</th>
		                    <th>Harga(Rp)</th>
							<th>Diskon(%)</th>
		                    <th>Diskon(Rp)</th>
		                    <th>Jumlah(Qty)</th>
		                </tr>
						<tr>
							<td style="width:200px;"></td>
							<td><input type="text" name="nabar" value="<?php echo htmlspecialchars($b['barang_nama']);?>" style="width:300px;margin-right:5px;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" name="satuan" value="<?php echo $b['barang_satuan'];?>" style="width:80px;margin-right:5px;text-align:center;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" name="stok" value="<?php echo $formatted_stok;?>" style="width:80px;margin-right:5px;text-align:right;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" name="harjul" id="harjul" value="<?php echo number_format($b['barang_harjul'],0, ',' ,'.');?>" style="width:120px;margin-right:5px;text-align:right;" class="form-control input-sm" readonly></td>
							<td>	
								<select name="ratediskon" id="ratediskon" style="width:80px;margin-right:5px;" class="form-control input-sm">
                                        <?php 
										$list_disc=$d['disc_rate'];
										if (empty($list_disc)) {
											echo "<option>0</option>"; //menambahkan nilai 0 di urutan awal	
										}else{
											$lsdc = explode(';', $list_disc);
											$nilai_dict = [];
											// Mengisi array asosiatif dengan nilai dari string
											foreach ($lsdc as $array_pair) {
												list($key, $value) = explode(':', $array_pair);
													$nilai_dict[(int)$key] = (float)$value;
											}
											// Menampilkan nilai untuk kunci berurutan
											ksort($nilai_dict); // Mengurutkan array asosiatif berdasarkan kunci
											foreach ($nilai_dict as $key => $value) {	
												//echo "<option>$value</option>";
												$rtd=$value;
												if (floor($rtd) == $rtd) {
													$formatted_rtd = number_format($rtd, 0, ',', '.');
												} else {
													$formatted_rtd = number_format($rtd, 2, ',', '.');
													$formatted_rtd = rtrim($formatted_rtd, '0');
													$formatted_rtd = rtrim($formatted_rtd, ',');
												}
												echo "<option>$formatted_rtd</option>";
											}
											echo "<option>0</option>"; //menambahkan nilai 0 di urutan akhir jika tidak diberikan diskon	
										}
                                    ?>        
                                </select>
							</td>

							<td><input type="text" name="diskon" id="diskon" value="0" min="0" class="form-control input-sm" style="width:100px;margin-right:5px;text-align:right;" readonly></td>
		                    <td><input type="text" name="qty" id="qty" value="1" min="" max="<?php echo $stok;?>" class="form-control input-sm" style="width:90px;margin-right:5px;text-align:right;" required></td>
							<td style="padding-right: 3px;"><button type="submit" name="submit_ok" id="submit_ok" class="btn btn-sm btn-primary">Ok</button></td>
							<td style="text-align:center;"><button type="button" name="batal" id="batal" class="btn btn-sm btn-danger">Batal</button></td>	
							
						</tr>
					</table>



<script type="text/javascript">	
$(document).on('input', 'input[name^="qty"]', function(e) {
    var inputValue = e.target.value;
    var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); 
    e.target.value = sanitizedValue; 

	var harjul = parseFloat($('#harjul').val().replace(/[^\d,]/g, '')) || 0;
    var disc = parseFloat($('#ratediskon').val().replace(',', '.')) || 0; 
	var qty = parseFloat($('#qty').val().replace(',', '.')) || 0;
	var totalHarga = harjul * qty;
    var diskon = totalHarga * (disc / 100);
    var formattedHasil = Math.floor(diskon).toLocaleString('id-ID');
    $('#diskon').val(formattedHasil);

 });

	// Aksi ketika tombol batal diklik
	$('#batal').on('click', function() {
		$('#tbl_detail').empty();
		$('input[name="kode_brg"]').focus();
	});

	$('select[name="ratediskon"]').on('change', function() {
        var harjul = parseFloat($('#harjul').val().replace(/[^\d,]/g, '')) || 0;
		var disc = parseFloat($('#ratediskon').val().replace(',', '.')) || 0; 
		var qty = parseFloat($('#qty').val().replace(',', '.')) || 0;
		var totalHarga = harjul * qty;
		var diskon = totalHarga * (disc / 100);
		var formattedHasil = Math.floor(diskon).toLocaleString('id-ID');
		$('#diskon').val(formattedHasil);
        
    }); 
</script>