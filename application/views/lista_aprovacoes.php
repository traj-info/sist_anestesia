<?php $this->load->view('header'); ?>
<?php $this->load->view('grupos_aprovacoes'); ?>
<?php echo ($this->input->get('msg') && $this->input->get('msg_type'))? msg(urldecode(html_entity_decode($this->input->get('msg', TRUE))), urldecode(html_entity_decode($this->input->get('msg_type', TRUE)))) : ''; ?>
<h2><?php echo $title; ?></h2>
<h3>Atribuída a: <strong><?php echo $atribuida_nome; ?></strong> (<?php echo $atribuida_username; ?>)</h3>
<script type="text/javascript">
$(document).ready(function(){
	$('.detalhes_aprovacao td').hide();
	
	$('.op_aprovacaodetalhes a').click(function(){
		var id = $(this).attr('id');
		
		if($('#det_' + id).text() == '') // conteúdo em branco; carregar via ajax
		{
			$.ajax({
			  url: "<?php echo base_url('aprovacoes/view'); ?>/" + id,
			  cache: false,
			  dataType: "html"
			}).done(function(html) {
			  $('#det_' + id).html(html);
			});
		}

		$('#det_' + id).toggle();
		
	});

});
</script>
<?php
if($a)
{
	echo "<table id='view_aprovacoes' class='tabela1 tabela_estilo1'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>ID</th>";
	echo "<th>Referente a</th>";
	echo "<th>Mês</th>";
	echo "<th>Status</th>";
	echo "<th>Opções</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	
	foreach($a as $i => $u)
	{
		echo "<tr id='linha_" . $u->id . "' class='" . $u->status_classe . "'>";
		echo "<td>" . $u->id . "</td>";
		echo "<td>" . $u->referente_nome . " (" . $u->referente_username . ")</td>";
		echo "<td>" . $u->referente_mes . "</td>";
		echo "<td>" . $u->status . "</td>";
		echo "<td><ul class='view_opcoes'>";
		echo "<li class='op_aprovar'><a title='Aprovar' href='" . base_url('aprovacoes/aprovar/' . $u->id) . "'>Aprovar</a></li>";
		echo "<li class='op_aprovacaodetalhes'><a title='Detalhes' href='#' id='" . $u->id . "'>Detalhes</a></li>";
		echo "</ul></td>";
		echo "</tr>";
		echo "<tr class='detalhes_aprovacao'>";
		echo "<td colspan='5' id='det_" . $u->id  . "'></td>";
		echo "</tr>";

	}
	echo "</table>";
}
else
{
	echo "<p>Nenhuma aprovação encontrada.</p>";
}

?>
<?php $this->load->view('footer'); ?>