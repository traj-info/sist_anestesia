<?php $this->load->view('header'); ?>
<?php $this->load->view('grupos_producoes'); ?>
<?php echo ($this->input->get('msg') && $this->input->get('msg_type'))? msg(urldecode(html_entity_decode($this->input->get('msg', TRUE))), urldecode(html_entity_decode($this->input->get('msg_type', TRUE)))) : ''; ?>
<h2><?php echo $title; ?></h2>
<h3>Referente a: <strong><?php echo $ref; ?></strong></h3>

<script type="text/javascript">
$(document).ready(function(){
	$('#seletor_producoes').change(function(){
		window.location.href = "<?php echo base_url('producoes/show'); ?>/" + $(this).val();
	});
});
</script>


<div id="container_seletor_producoes">
<select name='seletor_producoes' id='seletor_producoes'>
<option value=''>Meses anteriores...</option>
<?php
for($i = 1; $i < 11; $i++)
{
	$mes = date("Y-m", strtotime("-" . $i . " month")) . '-01'; // YYYY-MM-DD (dd sempre 01)';
	$opcao = traduz_mes($mes) . '/' . obter_ano($mes);	
		
	echo "<option value='$i'>$opcao</value>";
}
?>
</select>
</div>
<?php
if($p)
{
	echo "<table id='view_users' class='tabela1 tabela_estilo1'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>ID</th>";
	echo "<th>Nome</th>";
	echo "<th>Username</th>";
	echo "<th>Última edição</th>";
	echo "<th>Status</th>";
	echo "<th>Opções</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	
	foreach($p as $i => $u)
	{
		echo "<tr id='" . $u->id . "' class='" . $u->status_classe . "'>";
		echo "<td>" . $u->id . "</td>";
		echo "<td>" . $u->nome . "</td>";
		echo "<td>" . $u->username . "</td>";
		echo "<td>" . $u->modified_author_nome . " (" . $u->modified . ")</td>";
		echo "<td>" . $u->status . "</td>";
		echo "<td><ul class='view_opcoes'>";
		echo "<li class='op_editarproducao'><a title='Editar produção' href='" . base_url('producoes/edit/' . $u->id) . "'>Editar</a></li>";
		echo "</ul></td>";
		echo "</tr>";

	}
	echo "</table>";
}
else
{
	echo "<p>As produções solicitadas não foram encontradas no sistema.</p>";
}

?>
<?php $this->load->view('footer'); ?>