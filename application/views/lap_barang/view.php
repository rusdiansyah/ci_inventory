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
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Satuan</th>
    <th>Harga Beli</th>
    <th>Harga Jual</th>
    <th>Stok Awal</th>
    <th>Jml Beli</th>
    <th>Jml Jual</th>
    <th>Stok Akhir</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1;
		foreach($data->result_array() as $db){  
		$awal = $this->app_model->CariStokAwal($db['kode_barang']);
		$beli = $this->app_model->CariJmlBeli($db['kode_barang']);
		$jual = $this->app_model->CariJmlJual($db['kode_barang']);
		$stok = $this->app_model->CariStokAkhir($db['kode_barang']);
		?>    
    	<tr>
			<td align="center" width="20"><?php echo $no; ?></td>
            <td align="center" width="100" ><?php echo $db['kode_barang']; ?></td>
            <td ><?php echo $db['nama_barang']; ?></td>
            <td align="center" width="80" ><?php echo $db['satuan']; ?></td>
            <td align="right" width="100" ><?php echo number_format($db['harga_beli']); ?></td>
            <td align="right" width="100" ><?php echo number_format($db['harga_jual']); ?></td>
            <td align="center" width="80" ><?php echo $awal; ?></td>
            <td align="center" width="80" ><?php echo $beli; ?></td>
            <td align="center" width="80" ><?php echo $jual; ?></td>
            <td align="center" width="80" ><?php echo $stok; ?></td>
    </tr>
    <?php
		$no++;
		}
	}else{
	?>
    	<tr>
        	<td colspan="7" align="center" >Tidak Ada Data</td>
        </tr>
    <?php	
	}
?>
</table>