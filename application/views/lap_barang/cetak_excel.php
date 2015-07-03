<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=lap_barang.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<center><h1><?php echo $judul;?></h1></center>
</div>
<table class="grid" width="100%">
	<tr>
    	<th width="20">No</th>
        <th width="150">Kode Barang</th>
        <th width="400">Nama Barang</th>
        <th width="80">Satuan</th>
        <th width="150">Harga Beli</th>
        <th width="150">Harga Jual</th>
        <th width="80">Stok Awal</th>
        <th width="80">Jml Beli</th>
        <th width="80">Jml Jual</th>
        <th width="80">Stok Akhir</th>
	</tr>        
<?php
	$no=1;
	foreach($data->result_array() as $r){
	$awal = $this->app_model->CariStokAwal($r['kode_barang']);
	$beli = $this->app_model->CariJmlBeli($r['kode_barang']);
	$jual = $this->app_model->CariJmlJual($r['kode_barang']);	
	$stok = $this->app_model->CariStokAkhir($r['kode_barang']);
	?>
    <tr>
    	<td align="center"><?php echo $no;?></td>
        <td align="center"><?php echo $r['kode_barang'];?></td>
        <td ><?php echo $r['nama_barang'];?></td>
        <td align="center"><?php echo $r['satuan'];?></td>
        <td align="right"><?php echo number_format($r['harga_beli']);?></td>
        <td align="right"><?php echo number_format($r['harga_jual']);?></td>
        <td align="center"><?php echo number_format($awal);?></td>
        <td align="center"><?php echo number_format($beli);?></td>
        <td align="center"><?php echo number_format($jual);?></td>
        <td align="center"><?php echo number_format($stok);?></td>
    </tr>
    <?php
	$no++;
	}
?>
</table>