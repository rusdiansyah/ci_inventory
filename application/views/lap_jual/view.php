<script type="text/javascript">
$(function() {
	$("#dataTable tr:even").addClass("stripe1");
	$("#dataTable tr:odd").addClass("stripe2");
	$("#dataTable tr").hover(
		function() {
			$(this).toggleClass("highlight");
		},
		function() {
			$(this).toggleClass("highlight");
		}
	);
});
</script>
<style type="text/css">
.stripe1 {
    background-color:#FBEC88;
}
.stripe2 {
    background-color:#FFF;
}
.highlight {
	-moz-box-shadow: 1px 1px 2px #fff inset;
	-webkit-box-shadow: 1px 1px 2px #fff inset;
	box-shadow: 1px 1px 2px #fff inset;		  
	border:             #aaa solid 1px;
	background-color: #fece2f;
}
</style>
<table id="dataTable" width="100%">
<tr>
	<th>No</th>
    <th>Kode Beli</th>
    <th>Tanggal</th>
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Satuan</th>
    <th>Jumlah</th>
    <th>Harga</th>
    <th>Total</th>
</tr>
<?php
	if($data->num_rows()>0){
		$g_total = 0;
		$no =1;
		foreach($data->result_array() as $db){  
		$total = $db['jmljual']*$db['hargajual'];
		$tgl = $this->app_model->tgl_indo($db['tgljual']);
		?>    
    	<tr>
			<td align="center" width="20"><?php echo $no; ?></td>
            <td align="center" width="100" ><?php echo $db['kodejual']; ?></td>
            <td align="center" width="100"><?php echo $tgl; ?></td>
            <td align="center" width="100"><?php echo $db['kode_barang']; ?></td>
            <td ><?php echo $db['nama_barang']; ?></td>
            <td align="center" width="80" ><?php echo $db['satuan']; ?></td>
            <td align="center" width="80" ><?php echo number_format($db['jmljual']); ?></td>
            <td align="right" width="100" ><?php echo number_format($db['hargajual']); ?></td>
            <td align="right" width="100" ><?php echo number_format($total); ?></td>
    </tr>
    <?php
		$no++;
		$g_total =$g_total+$total;
		}
	}else{
		$g_total =0;
	?>
    	<tr>
        	<td colspan="9" align="center" >Tidak Ada Data</td>
        </tr>
    <?php	
	}
?>
<tr>
	<td colspan="8" align="center">TOTAL</td>
    <td align="right"><?php echo number_format($g_total);?></td>
</tr>    
</table>