<?php $this->load->view('header'); ?>
<?php $this->load->view('grupos_producoes'); ?>
<?php echo (isset($msg) && isset($msg_type) )? msg($msg, $msg_type) : ''; ?>
<h2><?php echo $title; ?></h2>
<div class="box1" id="box_producao">
Dr(a).: <strong><?php echo $nome; ?></strong> (username: <?php echo $username; ?>)<br/>
Dados referentes ao pagamento do mês de: <strong><?php echo $ref_pagto; ?></strong>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('.input_qtde_plantoes').mask('9?9');
	$('.input_valor_plantoes').mask('999,99');
	//$('.input_salario_hc').mask('9999,99');
	$('.ch').mask('9?999');

	$('.input_salario_hc').blur(function(){
	
		var intRegex = /^\d{2,4}(\,\d{2})$/;
		var valor = $(this).val();
		if(!intRegex.test(valor))
		{
			alert('Digite valores do tipo 9999,99');
			$(this).val('');
			$(this).focus();
		}
	});
	
	$('#txtSaldoHoras').change(function(){
		var saldo = $(this).val();
		var texto = (saldo > 0) ? '(credora)' : '(devedora)';
		texto = (saldo == 0) ? '' : texto;
		$('#res_saldo').text(texto);	
	});
	
	
	$('div.plantoes input').change(function(){
		var qtde = $(this).parent('div').children('.input_qtde_plantoes').val();
		var valor = $(this).parent('div').children('.input_valor_plantoes').val();
		
		valor = valor.replace(",", ".");
		
		var total = qtde * valor;
		total = total.toFixed(2);
		total = total.toString();
		total = total.replace(".", ",");
		
		$(this).parent('div').children('span').text(total);
	});
	
});

function calcularPlantoes()
{
	
}
	
</script>
<?php
$attributes = array('class' => 'traj_form', 'id' => 'frmEditProducao', 'name' => 'frmEditProducao');

echo validation_errors();

if(true)
{
	echo form_open('producoes/edit', $attributes);
	echo "<div class='fields_holder'>";

	echo "<p>Carga horária referente a: <strong>" . $ref . "</strong></p>";
	
	echo "<div class='field_holder'>";
	echo form_label('Carga horária prevista: ', 'txtCHprevista');
	echo '<input type="text" size="5" name="txtCHprevista" id="txtCHprevista" class="ch" value="' . $ch_prevista . '"  />';
	echo "</div>";

	echo "<div class='field_holder'>";
	echo form_label('Carga horária cumprida: ', 'txtCHcumprida');
	echo '<input type="text" size="5" name="txtCHcumprida" id="txtCHcumprida" class="ch" value="' . $ch_cumprida . '"  />';
	echo "</div>";
	
	echo "<div class='field_holder'>";
	echo form_label('Saldo de horas: ', 'txtSaldoHoras');
	echo '<input type="text" size="5" name="txtSaldoHoras" id="txtSaldoHoras" class="ch" value="' . $saldo_horas . '"  />';
	echo " <span id='res_saldo'>" . $resultado_saldo_horas . "</span>";
	echo "</div>";

	echo "<div class='field_holder'>";
	echo form_label('Quantidade de plantões realizados: ', 'txtQtdePlantoes');
	echo '<input type="text" size="5" name="txtQtdePlantoes" id="txtQtdePlantoes" class="ch" value="' . $qtde_plantoes . '"  />';
	echo "</div>";
	
	echo "<p>Complementos dos plantões:</p>";
	
	echo "<div class='field_holder plantoes' id='grupo0'>";
	echo '<input type="text" size="5" name="txtPlantoes[]" id="txtPlantoes[0]" class="input_qtde_plantoes" value="' . $qtde_plantoes_0 . '"  /> plantões a R$ ';
	echo '<input type="text" size="5" name="txtValorPlantoes[]" id="txtValorPlantoes[0]" class="input_valor_plantoes" value="' . $valor_plantoes_0 . '"  /> = R$ <span id="totalPlantoes[0]">' . $total_plantoes_0 . '</span>';
	echo "</div>";

	echo "<div class='field_holder plantoes' id='grupo1'>";
	echo '<input type="text" size="5" name="txtPlantoes[]" id="txtPlantoes[1]" class="input_qtde_plantoes" value="' . $qtde_plantoes_1 . '"  /> plantões a R$ ';
	echo '<input type="text" size="5" name="txtValorPlantoes[]" id="txtValorPlantoes[1]" class="input_valor_plantoes" value="' . $valor_plantoes_1 . '"  /> = R$ <span id="totalPlantoes[1]">' . $total_plantoes_1 . '</span>';
	echo "</div>";
	
	echo "<div class='field_holder plantoes' id='grupo2'>";
	echo '<input type="text" size="5" name="txtPlantoes[]" id="txtPlantoes[2]" class="input_qtde_plantoes" value="' . $qtde_plantoes_2 . '"  /> plantões a R$ ';
	echo '<input type="text" size="5" name="txtValorPlantoes[]" id="txtValorPlantoes[2]" class="input_valor_plantoes" value="' . $valor_plantoes_2 . '"  /> = R$ <span id="totalPlantoes[2]">' . $total_plantoes_2 . '</span>';
	echo "</div>";
	
	echo "<div class='field_holder plantoes' id='grupo3'>";
	echo '<input type="text" size="5" name="txtPlantoes[]" id="txtPlantoes[3]" class="input_qtde_plantoes" value="' . $qtde_plantoes_3 . '"  /> plantões a R$ ';
	echo '<input type="text" size="5" name="txtValorPlantoes[]" id="txtValorPlantoes[3]" class="input_valor_plantoes" value="' . $valor_plantoes_3 . '"  /> = R$ <span id="totalPlantoes[3]">' . $total_plantoes_3	 . '</span>';
	echo "</div>";
	
	
	echo "<div class='field_holder niveis'>";
	echo form_label('Nível do assistente: ', 'radNivel');
	echo "<br/>";
	echo form_radio('radNivel', '1', $nivel_1) . " <strong>Nível 1</strong><br/>";
	echo form_radio('radNivel', '2', $nivel_2) . " <strong>Nível 2</strong> (mestrado com produção científica ativa*, TSA instrutor ou co-responsável no CET, coordenador de equipe)<br/>";
	echo form_radio('radNivel', '3', $nivel_3) . " <strong>Nível 3</strong> (doutorado com produção científica ativa*, supervisor de equipe)<br/>";
	echo "<strong>* produção científica ativa:</strong> mínimo de uma publicação com indexação MEDLINE no último biênio.";
	echo "</div>";
	
	echo "<div class='field_holder'>";
	echo form_label('Salário HC: R$ ', 'txtSalarioHC');
	echo '<input type="text" size="5" name="txtSalarioHC" id="txtSalarioHC" class="input_salario_hc" value="' . $salario_hc . '"  />';
	echo "</div>";
	
	echo "<div class='field_holder'>";
	echo form_label('Descontos salariais: R$ ', 'txtDesconto');
	echo '<input type="text" size="5" name="txtDesconto" id="txtDesconto" class="input_salario_hc" value="' . $desconto . '"  />';
	echo "</div>";
	
	echo "<div class='field_holder'>";
	echo form_label('Anotações adicionais: ', 'txtObs');
	echo "<br/><textarea name='txtObs' id='txtObs' rows='6' cols='100'>" . $obs . "</textarea>";
	echo "</div>";

	echo "<p id='obs_pontuacao'>A pontuação referente às metas assistenciais é calculada pelo sistema após o preenchimento das avaliações.</p>";
	
	echo "<div class='bt_holder'>";
	echo div_clear();
	echo form_hidden('hidden_producao_id', $id);
	echo form_submit('submit', 'Salvar alterações');
	echo "</div>"; // bt_holder
	echo "</div>"; // fields_holder
	echo "</form>";

} // end if users
?>
<?php $this->load->view('footer'); ?>