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
<table  id="dataTable" width="70%">
<tr>
	<th>Harga Beli</th>
    <th>Harga Jual</th>
    <th>Profit</th>
</tr>
<tr>
	<td align="right"><?php echo number_format($total_beli);?></td>
    <td align="right"><?php echo number_format($total_jual);?></td>
    <td align="right"><?php echo number_format($total);?></td>
</tr>    
</table>