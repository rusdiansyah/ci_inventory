<style type="text/css">
*{
font-family: Arial;
margin:0px;
padding:0px;
}
@page {
 margin-left:3cm 2cm 2cm 2cm;
}
table.grid{
width:20.99cm ;
font-size: 12px;
border-collapse:collapse;
}
table.grid th{
	padding:5px;
}
table.grid th{
background: #F0F0F0;
border-top: 0.2mm solid #000;
border-bottom: 0.2mm solid #000;
text-align:center;
border:1px solid #000;
}
table.grid tr td{
	padding:2px;
	border-bottom:0.2mm solid #000;
	border:1px solid #000;
}
h1{
font-size: 18px;
}
h2{
font-size: 14px;
}
h3{
font-size: 12px;
}
p {
font-size: 10px;
}
center {
	padding:8px;
}
.atas{
display: block;
width:20.99cm ;
margin:0px;
padding:0px;
}
.kanan tr td{
	font-size:12px;
}
.attr{
font-size:9pt;
width: 100%;
padding-top:2pt;
padding-bottom:2pt;
border-top: 0.2mm solid #000;
border-bottom: 0.2mm solid #000;
}
.pagebreak {
width:20.99cm ;
page-break-after: always;
margin-bottom:10px;
}
.akhir {
width:20.99cm ;
font-size:13px;
}
.page {
width:20.99cm ;
font-size:12px;
padding:10px;
}
table.footer{
width:20.99cm ;
font-size: 12px;
border-collapse:collapse;
}
</style>
<?php

$kiri = '<h1>'.$instansi.'</h1>';
$kiri .= '<p>'.$alamat_instansi.'</p>';

$kanan = "<table class='kanan' width='100%'>
		  <tr>
		  	<td>Filter By</td>
			<td width='5'>:</td>
			<td><b>$filter</b></td>
		  </tr>
		  </table>";
function myheader($kiri,$kanan,$judul){
?>
<div class="atas">
<table width="100%">
<tr>
	<td width="60%" valign="top">
   		<?php echo $kiri;?>
    </td>
	<td width="40%" valign="top">
    	<?php echo $kanan;?>
    </td>
</tr>    
</table>
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
}
function myfooter(){	
	echo "</table>";
}
	$no=1;
	$page =1;
	foreach($data->result_array() as $r){
	$awal = $this->app_model->CariStokAwal($r['kode_barang']);
	$beli = $this->app_model->CariJmlBeli($r['kode_barang']);
	$jual = $this->app_model->CariJmlJual($r['kode_barang']);	
	$stok = $this->app_model->CariStokAkhir($r['kode_barang']);
	if(($no%25) == 1){
   	if($no > 1){
        myfooter();
        echo "<div class=\"pagebreak\" align='right'>
		<div class='page' align='center'>Hal - $page</div>
		</div>";
		$page++;
  	}
   	myheader($kiri,$kanan,$judul);
	}
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
myfooter();	
	echo "</table>";
?>
<div style="padding:10px"></div>
<table width="100%" class="footer">
<tr>
	<td width="70%"></td>
	<td width="30%" valign="top" align="center">
    Serang, <?php echo $this->app_model->tgl_indo(date('Y-m-d'));?>
    <br /><br /><br /><br />
    <b><u><?php echo $this->session->userdata('username');?></u></b>
    </td>
</tr>
</table>    
<div class="page" align="center">Hal - <?php echo $page;?></div>