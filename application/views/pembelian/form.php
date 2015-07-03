<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	
	tampil_data();
	
	function tampil_data(){
		var kode = $("#kode_beli").val();
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/pembelian/DataDetail",
			data	: "kode="+kode,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
			}
		});
		//return false();
	}
	
	$("#tgl").datepicker({
			dateFormat:"dd-mm-yy"
    });
	
	$("#kode_brg").focus();
	$("#kode_brg").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	$("#kode_brg").focus(function(e){
		var isi = $(e.target).val();
		CariBarang();
	});
	
	$("#kode_brg").keyup(function(){
		CariBarang();
		
	});
	
	function CariBarang(){
		var kode = $("#kode_brg").val();
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoBarang",
			data	: "kode="+kode,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#nama_brg").val(data.nama_barang);
				$("#satuan").val(data.satuan);
				$("#harga").val(data.harga_beli);
			}
		});
	};
	$("#harga").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) {
			return false;
		}
	});
	$("#jml").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) {
			return false;
		}
	});
	
	function hitung(){
		var jml = $("#jml").val();
		var harga = $("#harga").val();
		
		var total = parseInt(jml)*parseInt(harga);
		$("#total").val(total);
	}
	$("#jml").keyup(function(){
		hitung();
	});
	$("#harga").keyup(function(){
		hitung();
	});
	
	$("#simpan").click(function(){
		var kode	= $("#kode_beli").val();
		var tgl		= $("#tgl").val();
		var supplier	= $("#supplier").val();
		var kode_brg	= $("#kode_brg").val();
		var jml	= $("#jml").val();
		var total		= $("#total").val();
		
		var string = $("#form").serialize();
		
		if(kode.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Kode Beli tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#kode").focus();
			return false();
		}
		if(tgl.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Tanggal tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#tgl").focus();
			return false();
		}
		if(supplier.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Supplier tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#supplier").focus();
			return false();
		}
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
		if(jml.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, jumlah tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#jml").focus();
			return false();
		}
		if(total<=0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, jumlah tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#jml").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/pembelian/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				tampil_data();
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
	
	$("#tambah_data").click(function(){
		$(".detail").val('');
		$("#kode_brg").val('');
		$("#kode_brg").focus();
	});
	
	$("#cetak").click(function(){
		var kode	= $("#kode_beli").val();
		window.open('<?php echo site_url();?>/pembelian/cetak/'+kode);
		return false();
	});
	
	$("#cari_barang").click(function(){
		AmbilDaftarBarang();
		$("#dlg").dialog('open');
	});
	
	$("#text_cari").keyup(function(){
		AmbilDaftarBarang();
		//$("#dlg").dialog('open');
	});
	
	function AmbilDaftarBarang(){
		var cari = $("#text_cari").val();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataBarang",
			data	: "cari="+cari,
			cache	: false,
			success	: function(data){
				$("#daftar_barang").html(data);
			}
		});
	}
});	
</script>
<form name="form" id="form">
<table width="100%">
<tr>
<td valign="top" width="50%">
    <fieldset>
    <table width="100%">
    <tr>    
        <td width="150">Kode Pembelian</td>
        <td width="5">:</td>
        <td><input type="text" name="kode_beli" id="kode_beli" size="12" maxlength="12" readonly="readonly" value="<?php echo $kode_beli;?>" /></td>
    </tr>
    <tr>    
        <td>Tanggal Beli</td>
        <td>:</td>
        <td><input type="text" name="tgl" id="tgl"  size="15" maxlength="15" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $tgl_beli;?>"/></td>
    </tr>
    <tr>    
        <td>Supplier</td>
        <td>:</td>
        <td>
        <select name="supplier" id="supplier">
        <?php 
		if(empty($supplier)){
		?>
        <option value="">-PILIH-</option>
        <?php
		}
		foreach($l_supp->result() as $t){
			if($supplier==$t->kode_supplier){
		?>
        <option value="<?php echo $t->kode_supplier;?>" selected="selected"><?php echo $t->kode_supplier;?> - <?php echo $t->nama_supplier;?></option>
        <?php }else { ?>
        <option value="<?php echo $t->kode_supplier;?>"><?php echo $t->kode_supplier;?> - <?php echo $t->nama_supplier;?></option>
        <?php }
		} ?>
        </select>
        </td>
    </tr>
    </table>
    </fieldset>
</td>
<td valign="top" width="50%">
    <fieldset class="atas">
    <table width="100%">
    <tr>    
        <td width="150">Kode Barang</td>
        <td width="5">:</td>
        <td><input type="text" name="kode_brg" id="kode_brg" size="12" maxlength="12" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" />
        <button type="button" name="cari_barang" id="cari_barang" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>
        </td>
    </tr>
    <tr>    
        <td>Nama Barang</td>
        <td>:</td>
        <td><input type="text" name="nama_brg" id="nama_brg"  size="50" class="detail" maxlength="50" readonly="readonly"/></td>
    </tr>
    <tr>    
        <td>Satuan</td>
        <td>:</td>
        <td><input type="text" name="satuan" id="satuan"  size="20" class="detail" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr>    
        <td>Harga</td>
        <td>:</td>
        <td><input type="text" name="harga" id="harga"  size="20"class="detail" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr>    
        <td>Jumlah</td>
        <td>:</td>
        <td><input type="text" name="jml" id="jml"  size="20" class="detail" maxlength="20"/></td>
    </tr>
    <tr>    
        <td>Total</td>
        <td>:</td>
        <td><input type="text" name="total" id="total" class="detail" size="20" maxlength="20" readonly="readonly"/></td>
    </tr>
    </table>
    </fieldset>
</td>
</tr>
</table>    
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">CETAK</button>
    <a href="<?php echo base_url();?>index.php/pembelian/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-logout'">TUTUP</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>

<fieldset>
<div id="tampil_data"></div>
</fieldset>
<div id="dlg" class="easyui-dialog" title="Daftar Barang" style="width:900px;height:400px; padding:5px;" data-options="closed:true">
	Cari : <input type="text" name="text_cari" id="text_cari" size="50" />
	<div id="daftar_barang"></div>
</div>