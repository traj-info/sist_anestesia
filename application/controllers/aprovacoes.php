<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aprovacoes extends CI_Controller {

	public function index()
	{
		$this->show();
	}

	// mostra uma lista das aprovações (pendentes ou todas) que o usuário logado deve aprovar
	public function mostrar()
	{
		$filtro = $this->uri->segment(3);
		$filtro = ($filtro == 'pendentes') ? 'pendentes' : 'todos';
		
		$data['a'] = NULL;
		
		// obtém aprovações associadas ao usuário logado
		$u = new User();
		$u->get_logged_user();
		if($filtro == 'pendentes') $u->aprovacao->get_pending();
		else if($filtro == 'todos') $u->aprovacao->get();
		
		if($u->aprovacao->result_count() > 0) // encontrou pelo menos 1 aprovação
		{
			$ap = array();
			foreach($u->aprovacao as $a)
			{
				$a->controle->get();
				$a->controle->user->get();
			
				// obtém dados usados pelo view
				$ap[$a->id] = array();
				$ap[$a->id]['id'] = $a->id;
				$ap[$a->id]['status'] = ($a->status_id == APROVADO) ? 'aprovado' : 'pendente';
				$ap[$a->id]['status_classe'] = ($a->status_id == APROVADO) ? 'aprovado' : 'pendente';
				$ap[$a->id]['referente_nome'] = $a->controle->user->nome;
				$ap[$a->id]['referente_username'] = $a->controle->user->wp_username;
				$ap[$a->id]['referente_mes'] = traduz_mes($a->controle->ref_mes) . '/' . obter_ano($a->controle->ref_mes);
				
			}
			$ap = arrayToObject($ap);
			$data['a'] = $ap;
		}
	
		$data['atribuida_nome'] = $u->nome;
		$data['atribuida_username'] = $u->wp_username;
		$data['title'] = 'Aprovações';
		$this->load->view('lista_aprovacoes', $data);
	}

	public function view()
	{
		// TODO: checar se usuário pode aprovar

		$id = $this->uri->segment(3);
		$ap = new Aprovacao($id);
		if($ap->result_count() > 0)
		{
			// retrieve data
			$ap->user->get();
			$ap->controle->get();
			$ap->controle->user->get();
			$ap->controle->producao->get();
			
			$total_0 = $ap->controle->producao->compl_plantoes_qtde_0 * $ap->controle->producao->compl_plantoes_valor_0;
			$total_1 = $ap->controle->producao->compl_plantoes_qtde_1 * $ap->controle->producao->compl_plantoes_valor_1;
			$total_2 = $ap->controle->producao->compl_plantoes_qtde_2 * $ap->controle->producao->compl_plantoes_valor_2;
			$total_3 = $ap->controle->producao->compl_plantoes_qtde_3 * $ap->controle->producao->compl_plantoes_valor_3;
			
			if(!$ap->controle->producao->compl_plantoes_qtde_0 || !$ap->controle->producao->compl_plantoes_valor_0) $total_0 = NULL;
			if(!$ap->controle->producao->compl_plantoes_qtde_1 || !$ap->controle->producao->compl_plantoes_valor_1) $total_1 = NULL;
			if(!$ap->controle->producao->compl_plantoes_qtde_2 || !$ap->controle->producao->compl_plantoes_valor_2) $total_2 = NULL;
			if(!$ap->controle->producao->compl_plantoes_qtde_3 || !$ap->controle->producao->compl_plantoes_valor_3) $total_3 = NULL;
			?>
			
			<p><strong>DETALHES DA APROVAÇÃO SOLICITADA</strong></p>
			<p>ID: <strong><?php echo $ap->id; ?></strong></p>
			<p>Referente ao(à) Dr(a).: <strong><?php echo $ap->controle->user->nome; ?></strong> (<?php echo $ap->controle->user->wp_username; ?>)</p>
			<p>Mês de referência: <strong><?php echo traduz_mes($ap->controle->ref_mes) . '/' . obter_ano($ap->controle->ref_mes); ?></strong></p>
			<hr>
			<p><strong>PRODUÇÃO</strong></p>
			<p>Carga horária prevista: <strong><?php echo $ap->controle->producao->ch_prevista; ?> horas</strong></p>
			<p>Carga horária cumprida: <strong><?php echo $ap->controle->producao->ch_cumprida; ?> horas</strong></p>
			<p>Saldo de horas: <strong><?php echo $ap->controle->producao->sh_mes; ?></strong> (<?php echo ($ap->controle->producao->sh_mes > 0) ? 'credora' : 'devedora'; ?>)</p>
			<p>Nível do assistente: <strong><?php echo $ap->controle->producao->nivel; ?></strong> 
			<?php 
			switch($ap->controle->producao->nivel)
			{
				case '1':
					echo "";
					break;
				case '2':
					echo "(mestrado com produção científica ativa*, TSA instrutor ou co-responsável no CET, coordenador de equipe)<br/>";
					echo "* produção científica ativa: mínimo de uma publicação com indexação MEDLINA no último biênio.";
					break;
				case '3':
					echo "(doutorado com produção científica ativa*, supervisor de equipe)<br/>";
					echo "* produção científica ativa: mínimo de uma publicação com indexação MEDLINA no último biênio.";
					break;
			}
			?>
			</p>
			<br />
			<p>Quantidade de plantões realizados no mês de referência: <strong><?php echo $ap->controle->producao->qtde_plantoes; ?></strong></p>
			<p>Complemento dos plantões:</p>
			
			<?php if($total_0 > 0) : ?>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $ap->controle->producao->compl_plantoes_qtde_0; ?> plantões a R$ <?php echo number_format($ap->controle->producao->compl_plantoes_valor_0, 2, ",", ""); ?> = <strong>R$ <?php echo number_format($total_0, 2, ",", ""); ?></strong></p>
			<?php endif; ?>
			
			<?php if($total_1 > 0) : ?>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $ap->controle->producao->compl_plantoes_qtde_1; ?> plantões a R$ <?php echo number_format($ap->controle->producao->compl_plantoes_valor_1, 2, ",", ""); ?> = <strong>R$ <?php echo number_format($total_1, 2, ",", ""); ?></strong></p>
			<?php endif; ?>
			
			<?php if($total_2 > 0) : ?>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $ap->controle->producao->compl_plantoes_qtde_2; ?> plantões a R$ <?php echo number_format($ap->controle->producao->compl_plantoes_valor_2, 2, ",", ""); ?> = <strong>R$ <?php echo number_format($total_2, 2, ",", ""); ?></strong></p>
			<?php endif; ?>
			
			<?php if($total_3 > 0) : ?>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $ap->controle->producao->compl_plantoes_qtde_3; ?> plantões a R$ <?php echo number_format($ap->controle->producao->compl_plantoes_valor_3, 2, ",", ""); ?> = R$ <strong><?php echo number_format($total_3, 2, ",", ""); ?></strong></p>
			<?php endif; ?>
			
			<hr>
			<p><strong>AVALIAÇÃO DE METAS ASSISTENCIAS</strong></p>
			<p>Pontuação total: <strong><?php echo $ap->controle->pontuacao; ?> pontos</strong></p>
			<div class="detalhes_pontuacao_ajax">
				<p>Detalhamento do cálculo da pontuação:</p>
				<table class="tab_det_pont">
				<tr>
					<td>Tipo</td>
					<td>Autor</td>
					<td>Pontuação</td>
				</tr>
				<?php
				foreach($ap->controle->respostas as $r)
				{
					$r->author->get();
					?>
				<tr>
					<td><?php echo traduz_open_as($r->open_as); ?></td>
					<td><?php echo $r->author->nome; ?></td>
					<td><?php //echo calcula_pontuacao_resposta(); ?></td>
				</tr>
					<?php
				}
				?>
				<tr>
					<td colspan="3">Cálculo da pontuação:<br/>
					
					<?php
					
					?>
					
					</td>
				</tr>
				
				</table>
			</div>
			<p>Valor da hora: <strong>R$ <?php echo number_format($ap->controle->valor_hora, 2, ",", ""); ?></strong></p>
			<p>(A) Valor da jornada: <strong>R$ <?php echo number_format($ap->controle->valor_jornada, 2, ",", ""); ?></strong></p>
			<p>(B) Valor dos plantões: <strong>R$ <?php echo number_format($ap->controle->valor_plantoes, 2, ",", ""); ?></strong></p>
			<p>Valor TOTAL: <strong>R$ <?php echo number_format($ap->controle->valor_total, 2, ",", ""); ?></strong></p>
			<br/>
			
			
			<?php
		}
		else
		{
			echo "ERRO: Aprovação com ID $id não encontrada.";
		}
	}
	
	public function aprovar()
	{
		echo "RODOU --> id: " . $this->uri->segment(3);
		
		// TODO: checar se usuário pode aprovar
		$id = $this->uri->segment(3);
		$ap = new Aprovacao($id);
		if($ap->result_count() > 0)
		{
			
		}
		else
		{
			echo "ERRO: Aprovação com ID $id não encontrada.";
		}
	}
	
	public function detalhes_aprovacao()
	{
	
	}
}


