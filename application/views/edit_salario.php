<?php $this->load->view('header'); ?>
<?php $this->load->view('grupos_opcoes'); ?>
<?php echo (isset($msg) && isset($msg_type) )? msg($msg, $msg_type) : ''; ?>
<h2><?php echo $title; ?></h2>
<script type="text/javascript">
$(document).ready(function() {
	$('.txtSal').blur(function(){
	
		var intRegex = /^\d{2,3}(\,\d{2})$/;
		var valor = $(this).val();
		if(!intRegex.test(valor))
		{
			alert('Digite valores do tipo 999,99 ou 99,99');
			$(this).val('');
			$(this).focus();
		}
	});

});

</script>
<?php
$attributes = array('class' => 'traj_form', 'id' => 'frmEditSalario', 'name' => 'frmEditSalario');

echo validation_errors();

	echo form_open('configuracoes/salario', $attributes);
	echo "<div class='fields_holder'>";
	
	if(!$sal) $sal = array_fill(0, 18, "00,00");
	
	?>
	
	<table id="tabSalarios">
	<tr>
		<td colspan="4" class="tdBold tdCenter">DIVISÃO DE ANESTESIA DO HC<br/>Remuneração em R$/hora (incluso o salário HC) - 20 horas semanais</td>
	</tr>
	<tr>
		<td class="tdBold">Pontuação (meta atingida)</td>
		<td class="tdBold">assistente nível 1</td>
		<td class="tdBold">assistente nível 2</td>
		<td class="tdBold">assistente nível 3</td>
	</tr>
	<tr>
		<td class="tdBold">Até 350 pontos</td>
		<td>Salário HC<input type="hidden" name="sal[]" id="sal[]" value="salario_hc" /></td>
		<td>Salário HC<input type="hidden" name="sal[]" id="sal[]" value="salario_hc" /></td>
		<td>Salário HC<input type="hidden" name="sal[]" id="sal[]" value="salario_hc" /></td>
	</tr>
	<tr>
		<td class="tdBold">Entre 351 e 500 pontos</td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[3]; ?>" /></td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[4]; ?>" /></td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[5]; ?>" /></td>
	</tr>
	<tr>
		<td class="tdBold">Entre 501 e 650 pontos</td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[6]; ?>" /></td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[7]; ?>" /></td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[8]; ?>" /></td>
	</tr>	
	<tr>
		<td class="tdBold">Entre 651 e 800 pontos</td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[9]; ?>" /></td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[10]; ?>" /></td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[11]; ?>" /></td>
	</tr>	
	<tr>
		<td class="tdBold">Entre 801 e 950 pontos</td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[12]; ?>" /></td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[13]; ?>" /></td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[14]; ?>" /></td>
	</tr>	
	<tr>
		<td class="tdBold">Entre 951 e 1000 pontos</td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[15]; ?>" /></td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[16]; ?>" /></td>
		<td>R$ <input type="text" class="txtSal" name="sal[]" id="sal[]" value="<?php echo $sal[17]; ?>" /></td>
	</tr>	
	
	</table>
	<Br/>
	<?php
	
	echo div_clear();
	echo form_submit('submit', 'Salvar alterações');
	echo "</div>"; // bt_holder
	echo "</div>"; // fields_holder
	echo "</form>";

?>
<?php $this->load->view('footer'); ?>