<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=lap_pembelian_barang.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<center><h1><?php echo $judul;?></h1></center>
</div>
<table class="grid" width="100%">
	<tr>
    	<th width="20">No</th>
        <th width="100">Kode Beli</th>
        <th width="200">Tanggal</th>
        <th width="100">Kode Supplier</th>
        <th width="400">Nama Supplier</th>
        <th width="150">Kode Barang</th>
        <th width="400">Nama Barang</th>
        <th width="120">Satuan</th>
        <th width="50">Jumlah</th>
        <th width="150">Harga</th>
        <th width="150">Total</th>
	</tr>        
<?php
	$g_total=0;
	$no=1;
	$page =1;
	foreach($data->result_array() as $r){
	$total = $r['jmlbeli']*$r['hargabeli'];
	$tgl = $this->app_model->tgl_indo($r['tglbeli']);
	?>
    <tr>
    	<td align="center"><?php echo $no;?></td>
        <td align="center"><?php echo $r['kodebeli'];?></td>
    	<td align="center"><?php echo $tgl;?></td>        
        <td align="center"><?php echo $r['kode_supplier'];?></td>
        <td ><?php echo $r['nama_supplier'];?></td>
        <td align="center"><?php echo $r['kode_barang'];?></td>
        <td ><?php echo $r['nama_barang'];?></td>
        <td align="center"><?php echo $r['satuan'];?></td>
        <td align="center"><?php echo $r['jmlbeli'];?></td>
        <td align="right"><?php echo number_format($r['hargabeli']);?></td>
        <td align="right"><?php echo number_format($total);?></td>
    </tr>
    <?php
	$no++;
	$g_total = $g_total+$total;
	}
?>
</table>