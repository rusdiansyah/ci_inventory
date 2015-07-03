<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	

	$("#tgl_1").datepicker({
			dateFormat:"dd-mm-yy"
    });
	$("#tgl_2").datepicker({
			dateFormat:"dd-mm-yy"
    });
	
	$("#cari").click(function(){
		var tgl1 = $("#tgl_1").val();
		var tgl2 = $("#tgl_2").val();
		
		var string = "tgl1="+tgl1+"&tgl2="+tgl2;
		
		 $("#tampil_data").html('');
		 $.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/profit/lihat",
			data	: string,
			cache	: false,
			success	: function(data){
				var win = $.messager.progress({
				title:'Please waiting',
				msg:'Loading data...'
				});
				setTimeout(function(){
					$.messager.progress('close');
					$("#tampil_data").html(data);
				},2800)
			}		
		});
		return false();	
	});
	
	$("#cari_detail").click(function(){
		var tgl1 = $("#tgl_1").val();
		var tgl2 = $("#tgl_2").val();
		
		var string = "tgl1="+tgl1+"&tgl2="+tgl2;
		
		 $("#tampil_data").html('');
		 $.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/profit/lihat_detail",
			data	: string,
			cache	: false,
			success	: function(data){
				var win = $.messager.progress({
				title:'Please waiting',
				msg:'Loading data...'
				});
				setTimeout(function(){
					$.messager.progress('close');
					$("#tampil_data").html(data);
				},2800)
			}		
		});
		return false();	
	});
	
	$("#cetak").click(function(){
		var kode = $("#kode_brg").val();
		var tgl1 = $("#tgl_1").val();
		var tgl2 = $("#tgl_2").val();
		var supplier = $("#supplier").val();
		
		var	pilih	= $(".pilih:checked").val();
		var jml_pilih = $(".pilih:checked");
		
		//var string = pilih+"/"+kode+"/"+supplier+"/"+tgl;
		if(pilih=='all'){
			var string = pilih;
		}else if(pilih=='tgl'){
			var string = pilih+"/"+tgl1+"/"+tgl2;
		}else if(pilih=='supplier'){
			var string = pilih+"/"+supplier;	
		}else{
			var string = pilih+"/"+kode;
		}
		
		if(jml_pilih.length == 0){
           var error = true;
           alert("Maaf, Anda belum memilih");
		   return (false);
         }
		
		window.open('<?php echo site_url();?>/lap_beli/cetak/'+string);
		 
		return false();	
	});
	
});	
</script>
<fieldset class="atas">
<table width="100%">
<tr>    
    <td align="center">Tanggal 
    <input type="text" name="tgl_1" id="tgl_1" size="12" maxlength="12" />
    s.d <input type="text" name="tgl_2" id="tgl_2" size="12" maxlength="12" />
    </td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td align="center">
    <button type="button" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">CARI</button>
    <button type="button" name="cari_detail" id="cari_detail" class="easyui-linkbutton" data-options="iconCls:'icon-search'">CARI DETAIL</button>
    </td>
</tr>
</table>  
</fieldset>
<fieldset>
<div id="tampil_data"></div>
</fieldset>   