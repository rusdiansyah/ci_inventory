<form name="form" id="form" method="post" action="<?php echo site_url();?>/foto/simpan" enctype="multipart/form-data">
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150">Foto</td>
    <td width="5">:</td>
    <td><input type="file" name="foto" id="foto" size="20" maxlength="20"  /></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="submit" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    </td>
</tr>
</table>  
</fieldset>   
</form>