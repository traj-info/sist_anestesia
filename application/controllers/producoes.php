<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producoes extends CI_Controller {

	public function index()
	{
		$this->show();
	}

	public function show()
	{
		$data['ref'] = '';
		
		$dif_meses = $this->uri->segment(3) ? trim($this->uri->segment(3)) : 1;
		$dif_meses = is_numeric($dif_meses) ? $dif_meses : 1;
		if ($dif_meses > 12) $dif_meses = 1;
		
		$controles = new Controle();
		$controles->get_previous($dif_meses);
		
		$mes = date("Y-m", strtotime("-" . $dif_meses . " month")) . '-01'; // YYYY-MM-DD (dd sempre 01)';
		$data['ref'] = traduz_mes($mes) . '/' . obter_ano($mes);		
		
		if($controles->result_count() > 0) // controles do mês anterior já foram criados
		{
			$p = array();
		
			foreach($controles as $c)
			{
				$c->user->get();
				$c->producao->get();
				$c->producao->modifier->get();
								
				$p[$c->producao->id] = array();
				
				$p[$c->producao->id]['id'] 			= $c->producao->id;
				$p[$c->producao->id]['nome'] 		= $c->user->nome;
				$p[$c->producao->id]['username'] 	= $c->user->wp_username;
				$p[$c->producao->id]['status'] 		= ($c->producao->modified == NULL) ? 'não iniciado' : 'iniciado';
				$p[$c->producao->id]['modified'] 	= ($c->producao->modified == NULL) ? '-' : FormatDate($c->producao->modified);
				$p[$c->producao->id]['modified_author_nome'] = $c->producao->modifier->nome;
				$p[$c->producao->id]['status_classe']	= ($c->producao->modified == NULL) ? 'naoiniciado' : 'iniciado';
			}
			
			$p = arrayToObject($p);
			$data['p'] = $p;
		}
		else // ainda não foram criados os controles referentes ao mês anterior
		{
			$data['p'] = NULL;
		}
		
		$data['title'] = 'Produções';
		$this->load->view('lista_producao', $data);
	}

	public function edit()
	{
		$post = $this->input->post(NULL, TRUE);
		$flag_erro = '';
		if($post['submit'])	// form submitted
		{
			$p = new Producao();
			$p->get_by_id($post['hidden_producao_id']);
			if($p->result_count() > 0)	//produção encontrada
			{
				$obs = $post['txtObs'];
				$ch_cumprida = $post['txtCHcumprida'];
				$ch_prevista = $post['txtCHprevista'];
				$sh_mes = $post['txtSaldoHoras'];
				$nivel = isset($post['radNivel']) ? $post['radNivel'] : '';
				$qtde_plantoes = $post['txtQtdePlantoes'];
				$compl_plantoes_qtde_0 = $post['txtPlantoes'][0];
				$compl_plantoes_valor_0 = $post['txtValorPlantoes'][0];
				$compl_plantoes_qtde_1 = $post['txtPlantoes'][1];
				$compl_plantoes_valor_1 = $post['txtValorPlantoes'][1];
				$compl_plantoes_qtde_2 = $post['txtPlantoes'][2];
				$compl_plantoes_valor_2 = $post['txtValorPlantoes'][2];
				$compl_plantoes_qtde_3 = $post['txtPlantoes'][3];
				$compl_plantoes_valor_3 = $post['txtValorPlantoes'][3];
				$salario_hc = $post['txtSalarioHC'];
				$desconto = $post['txtDesconto'];
				
				// algum campo obrigatório deixado em branco:
				// Não usamos o recurso de validação do model Produção porque o controlador já cria os registros
				// iniciais em branco. Se a validação fosse definida ao nível do model, não seria possível essa abordagem.
				if (empty($ch_cumprida) || empty($ch_prevista) || empty($sh_mes) || empty($nivel) || empty($qtde_plantoes))
				{
					$flag_erro = 'validation_error'; 
					$msg_erro_validacao = "<p><strong>Todos os campos obrigatórios precidam ser preenchidos:</strong></p>";
					$msg_erro_validacao .= "Carga horária prevista, carga horária cumprida, saldo de horas, quantidade de plantões, nível do assistente.</p>";
					
					// prepare data to be displayed again in the form
					$data['ch_prevista'] = $ch_prevista;
					$data['ch_cumprida'] = $ch_cumprida;
					$data['saldo_horas'] = $sh_mes;
					$data['resultado_saldo_horas'] = ($data['saldo_horas'] > 0) ? '(credora)' : '(devedora)';
					$data['resultado_saldo_horas'] = ($data['saldo_horas'] == 0) ? '' : $data['resultado_saldo_horas'];
					$data['qtde_plantoes'] = $qtde_plantoes;
					
					$data['qtde_plantoes_0'] = $compl_plantoes_qtde_0;
					$data['valor_plantoes_0'] = $compl_plantoes_valor_0;
					$total_0 = str_replace(",", ".", $data['valor_plantoes_0']);
					$total_0 = $total_0 * (int)$compl_plantoes_qtde_0;
					$total_0 = number_format($total_0, 2, ",", "");
					$data['total_plantoes_0'] = $total_0;
					
					$data['qtde_plantoes_1'] = $compl_plantoes_qtde_1;
					$data['valor_plantoes_1'] = $compl_plantoes_valor_1;
					$total_1 = str_replace(",", ".", $data['valor_plantoes_1']);
					$total_1 = $total_1 * (int)$compl_plantoes_qtde_1;
					$total_1 = number_format($total_1, 2, ",", "");
					$data['total_plantoes_1'] = $total_1;
					
					$data['qtde_plantoes_2'] = $compl_plantoes_qtde_2;
					$data['valor_plantoes_2'] = $compl_plantoes_valor_2;
					$total_2 = str_replace(",", ".", $data['valor_plantoes_2']);
					$total_2 = $total_2 * (int)$compl_plantoes_qtde_2;
					$total_2 = number_format($total_2, 2, ",", "");
					$data['total_plantoes_2'] = $total_2;
					
					$data['qtde_plantoes_3'] = $compl_plantoes_qtde_3;
					$data['valor_plantoes_3'] = $compl_plantoes_valor_3;
					$total_3 = str_replace(",", ".", $data['valor_plantoes_3']);
					$total_3 = $total_3 * (int)$compl_plantoes_qtde_3;
					$total_3 = number_format($total_3, 2, ",", "");
					$data['total_plantoes_3'] = $total_3;
					
					$data['nivel_1'] = ($nivel == '1');
					$data['nivel_2'] = ($nivel == '2');
					$data['nivel_3'] = ($nivel == '3');
					
					$data['obs'] = $obs;
					$data['salario_hc'] = $salario_hc;
					$data['desconto'] = $desconto;
				}
				else
				{
					// prepare data to be recorded into database
					$compl_plantoes_qtde_0 		= empty($compl_plantoes_qtde_0) 	? NULL : (float)str_replace(",", DS, $compl_plantoes_qtde_0);
					$compl_plantoes_valor_0 	= empty($compl_plantoes_valor_0) 	? NULL : (float)str_replace(",", DS, $compl_plantoes_valor_0);
					$compl_plantoes_qtde_1 		= empty($compl_plantoes_qtde_1) 	? NULL : (float)str_replace(",", DS, $compl_plantoes_qtde_1);
					$compl_plantoes_valor_1 	= empty($compl_plantoes_valor_1) 	? NULL : (float)str_replace(",", DS, $compl_plantoes_valor_1);
					$compl_plantoes_qtde_2 		= empty($compl_plantoes_qtde_2) 	? NULL : (float)str_replace(",", DS, $compl_plantoes_qtde_2);
					$compl_plantoes_valor_2 	= empty($compl_plantoes_valor_2) 	? NULL : (float)str_replace(",", DS, $compl_plantoes_valor_2);
					$compl_plantoes_qtde_3 		= empty($compl_plantoes_qtde_3) 	? NULL : (float)str_replace(",", DS, $compl_plantoes_qtde_3);
					$compl_plantoes_valor_3 	= empty($compl_plantoes_valor_3) 	? NULL : (float)str_replace(",", DS, $compl_plantoes_valor_3);
					
					$salario_hc				 	= empty($salario_hc) 				? NULL : (float)str_replace(",", DS, $salario_hc);
					$desconto				 	= empty($desconto) 					? NULL : (float)str_replace(",", DS, $desconto);
					
					$nivel = empty($nivel) ? NULL : $nivel;
					$usuario_logado = new User();
					$usuario_logado->get_logged_user();
					
					$p->obs = $obs;
					$p->ch_cumprida = $ch_cumprida;
					$p->ch_prevista = $ch_prevista;
					$p->sh_mes = $sh_mes;
					$p->sh_acumulado = NULL; // TODO: calcular saldo de horas acumulado
					$p->nivel = $nivel;
					$p->qtde_plantoes = $qtde_plantoes;
					$p->compl_plantoes_qtde_0 = $compl_plantoes_qtde_0;
					$p->compl_plantoes_valor_0 = $compl_plantoes_valor_0;
					$p->compl_plantoes_qtde_1 = $compl_plantoes_qtde_1;
					$p->compl_plantoes_valor_1 = $compl_plantoes_valor_1;
					$p->compl_plantoes_qtde_2 = $compl_plantoes_qtde_2;
					$p->compl_plantoes_valor_2 = $compl_plantoes_valor_2;
					$p->compl_plantoes_qtde_3 = $compl_plantoes_qtde_3;
					$p->compl_plantoes_valor_3 = $compl_plantoes_valor_3;
					$p->salario_hc = $salario_hc;
					$p->desconto = $desconto;
				}
				
				// Save all
				if(!$flag_erro && !$p->save(array(
					'modifier' => $usuario_logado
				))) // error on save
				{
					if ( $p->valid ) // validation ok; database error on insert or update
					{
						$flag_erro = 'db_error';
					} 
				}
				
				if($flag_erro == '') // success
				{
					$msg = urlencode(htmlentities("<strong>Produção editada com sucesso!</strong>"));
					$msg_type = urlencode('success');
					redirect("/producoes/?msg=$msg&msg_type=$msg_type");
					return;
				}
				else if($flag_erro == 'db_error')
				{
					$data['msg'] = '<strong>Erro na gravação no banco de dados.</strong><br />Tente novamente e, se o problema persistir, notifique o administrador do sistema.';
					$data['msg_type'] = 'error';
				}
				else if($flag_erro == 'validation_error')
				{
					$data['msg'] = '<strong>Erro de validação de dados.</strong><br />' . $msg_erro_validacao;
					$data['msg_type'] = 'error';
				}
				
			}
			else	// grupo não encontrado
			{
				$data['msg'] = '<strong>Grupo não encontrado.</strong>';
				$data['msg_type'] = 'error';
			}

		}

		// obter produção a ser editada
		$id = ($post['hidden_producao_id']) ? $post['hidden_producao_id'] : $this->uri->segment(3);
		$data['id'] = $id;
		
		$p = new Producao();
		$p->get_by_id($id);
		if($p->result_count() > 0) // produção encontrada
		{
			// TODO: checar se usuário pode editar essa produção
		
			$p->controle->get();
			$p->controle->user->get();
			
			// erro = TRUE se o form. for renderizado após já ter sido submetido mas terem sido detectados erros de validação
			$erro = ($flag_erro == 'validation_error');
			
			$data['nome'] = $p->controle->user->nome;
			$data['username'] = $p->controle->user->wp_username;
			$data['ref'] = traduz_mes($p->controle->ref_mes) . '/' . obter_ano($p->controle->ref_mes);
			$proximo_mes = explode("-", $p->controle->ref_mes);
			$proximo_mes = $proximo_mes[0] . '-' . ($proximo_mes[1] + 1) . '-' . $proximo_mes[2];
			$data['ref_pagto'] = traduz_mes($proximo_mes) . '/' . obter_ano($proximo_mes);
			
			$data['ch_prevista'] = ($erro) ? $data['ch_prevista'] : $p->ch_prevista;
			$data['ch_cumprida'] = ($erro) ? $data['ch_cumprida'] : $p->ch_cumprida;
			$data['saldo_horas'] = ($erro) ? $data['saldo_horas'] : $p->sh_mes;
			$data['resultado_saldo_horas'] = ($data['saldo_horas'] > 0) ? '(credora)' : '(devedora)';
			$data['resultado_saldo_horas'] = ($data['saldo_horas'] == 0) ? '' : $data['resultado_saldo_horas'];
			$data['qtde_plantoes'] = ($erro) ? $data['qtde_plantoes'] : $p->qtde_plantoes;
			
			$data['salario_hc'] = ($erro) ? $data['salario_hc'] : number_format($p->salario_hc, 2, ",", "");
			$data['desconto'] = ($erro) ? $data['desconto'] : number_format($p->desconto, 2, ",", "");
			
			$data['qtde_plantoes_0'] = ($erro) ? $data['qtde_plantoes_0'] : $p->compl_plantoes_qtde_0;
			$data['valor_plantoes_0'] = ($erro) ? $data['valor_plantoes_0'] : number_format($p->compl_plantoes_valor_0, 2, ",", "");
			
			if(! $erro)
			{
				$total_0 = $p->compl_plantoes_qtde_0 * $p->compl_plantoes_valor_0;
				$total_0 = number_format($total_0, 2, ",", "");
			}
			$data['total_plantoes_0'] = ($erro) ? $data['total_plantoes_0'] : $total_0;
			
			
			$data['qtde_plantoes_1'] = ($erro) ? $data['qtde_plantoes_1'] : $p->compl_plantoes_qtde_1;
			$data['valor_plantoes_1'] = ($erro) ? $data['valor_plantoes_1'] : number_format($p->compl_plantoes_valor_1, 2, ",", "");
			if(! $erro)
			{
				$total_1 = $p->compl_plantoes_qtde_1 * $p->compl_plantoes_valor_1;
				$total_1 = number_format($total_1, 2, ",", "");
			}
			$data['total_plantoes_1'] = ($erro) ? $data['total_plantoes_1'] : $total_1;
			
			
			$data['qtde_plantoes_2'] = ($erro) ? $data['qtde_plantoes_2'] : $p->compl_plantoes_qtde_2;
			$data['valor_plantoes_2'] = ($erro) ? $data['valor_plantoes_2'] : number_format($p->compl_plantoes_valor_2, 2, ",", "");
			if(! $erro)
			{
				$total_2 = $p->compl_plantoes_qtde_2 * $p->compl_plantoes_valor_2;
				$total_2 = number_format($total_2, 2, ",", "");
			}
			$data['total_plantoes_2'] = ($erro) ? $data['total_plantoes_2'] : $total_2;
			
			
			$data['qtde_plantoes_3'] = ($erro) ? $data['qtde_plantoes_3'] : $p->compl_plantoes_qtde_3;
			$data['valor_plantoes_3'] = ($erro) ? $data['valor_plantoes_3'] : number_format($p->compl_plantoes_valor_3, 2, ",", "");
			if(! $erro)
			{
				$total_3 = $p->compl_plantoes_qtde_3 * $p->compl_plantoes_valor_3;
				$total_3 = number_format($total_3, 2, ",", "");
			}
			$data['total_plantoes_3'] = ($erro) ? $data['total_plantoes_3'] : $total_3;
			
			
			$data['nivel_1'] = ($erro) ? $data['nivel_1'] : ($p->nivel == '1');
			$data['nivel_2'] = ($erro) ? $data['nivel_2'] : ($p->nivel == '2');
			$data['nivel_3'] = ($erro) ? $data['nivel_3'] : ($p->nivel == '3');
			
			$data['obs'] = ($erro) ? $data['obs'] : $p->obs;
		}
		else	// produção não encontrada
		{
			$data['msg'] = '<strong>Produção não encontrada.</strong>';
			$data['msg_type'] = 'error';
		}
	
		$data['title'] = 'Editar produção';
		$this->load->view('edit_producao', $data);	
	}
		
}

