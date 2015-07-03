<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#kode_brg").focus();
	$("#kode_brg").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		CariDataBarang();
	});
	function CariDataBarang(){
		var kode = $("#kode_brg").val()
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoBarang",
			data	: "kode="+kode,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#nama_brg").val(data.nama_barang);
				$("#satuan").val(data.satuan);
				$("#hrg_beli").val(data.harga_beli);
				$("#hrg_jual").val(data.harga_jual);
				$("#stok_awal").val(data.stok_awal);
			}
		});
	}
	$("#hrg_beli").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) {
			return false;
		}
	});
	$("#hrg_jual").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) {
			return false;
		}
	});
	$("#stok_awal").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) {
			return false;
		}
	});
	
	$("#simpan").click(function(){
		var kode_brg	= $("#kode_brg").val();
		var nama_brg	= $("#nama_brg").val();
		var satuan		= $("#satuan").val();
		
		var string = $("#form").serialize();
		
		if(kode_brg.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Kode Barang tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#kode_brg").focus();
			return false();
		}
		if(nama_brg.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Nama Barang tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#nama_brg").focus();
			return false();
		}
		if(satuan.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Satuan tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#satuan").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/barang/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				CariSimpanan();
			},
			error : function(xhr, teksStatus, kesalahan) {
				$.messager.show({
					title:'Info',
					msg: 'Server tidak merespon :'+kesalahan,
					timeout:2000,
					showType:'slide'
				});
			}
		});
		return false();		
	});
	
});	
</script>
<form name="form" id="form">
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150">Kode Barang</td>
    <td width="5">:</td>
    <td><input type="text" name="kode_brg" id="kode_brg" size="12" maxlength="12" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $kode_brg;?>" /></td>
</tr>
<tr>    
	<td>Nama Barang</td>
    <td>:</td>
    <td><input type="text" name="nama_brg" id="nama_brg"  size="50" maxlength="50" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $nama_brg;?>"/></td>
</tr>
<tr>    
	<td>Satuan</td>
    <td>:</td>
    <td><input type="text" name="satuan" id="satuan"  size="10" maxlength="10" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $satuan;?>"/></td>
</tr>
<tr>    
	<td>Harga Beli</td>
    <td>:</td>
    <td><input type="text" name="hrg_beli" id="hrg_beli"  size="20" maxlength="20" value="<?php echo $hrg_beli;?>" /></td>
</tr>
<tr>    
	<td>Harga Jual</td>
    <td>:</td>
    <td><input type="text" name="hrg_jual" id="hrg_jual"  size="20" maxlength="20" value="<?php echo $hrg_jual;?>"/></td>
</tr>
<tr>    
	<td>Stok Awal</td>
    <td>:</td>
    <td><input type="text" name="stok_awal" id="stok_awal"  size="10" maxlength="10" value="<?php echo $stok_awal;?>"/></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <a href="<?php echo base_url();?>index.php/barang/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
    </a>
    <a href="<?php echo base_url();?>index.php/barang/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>