<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controlador extends CI_Controller {

	public function index()
	{
			
	}
	
	// executado 1 vez por mês como cron job.
	// cria os controles iniciais referentes ao mês anterior e as respectivas dependências (produções e respostas às avaliações).
	// dispara avisos informando que já estão disponíveis os formulários de avaliações.
	public function setup()
	{
		// TODO: restringir acesso somente via cli (command-line interface) to prevent remote access attempt

		// get all users
		$u = new User();
		$u->where('status_id', STATUS_ACTIVE)->get();
		
		if($u->result_count() < 1) exit();
		foreach($u as $user)
		{
			// se já foi criado o registro de controle para o mês anterior E para este usuário, continue a execução.
			$user->controle->get_previous();
			if($user->controle->result_count() > 0) continue;
			
			// cria registro de controle
			$c = new Controle();
			$c->ref_mes = date("Y-m", strtotime("-1 month")) . '-01'; // YYYY-MM-DD (dd sempre 01)
			$c->obs = '';
			$c->status_id = STATUS_CONTROLE_INICIADO;
			
			// cria producao
			$prod = new Producao();
			// recupera valores da produção anterior para que a nova produção seja preenchida com alguns dados pré-populados
			$cont_ant = new Controle();
			$cont_ant->where('ref_mes', date("Y-m", strtotime("-2 month")) . '-01')->where('user_id', $user->id)->get();
			if($cont_ant->result_count() > 0)	// encontrou controle anterior
			{
				$cont_ant->producao->get();
				$prod->salario_hc = $cont_ant->producao->salario_hc;
				$prod->nivel = $cont_ant->producao->nivel;
				$prod->ch_prevista = $cont_ant->producao->ch_prevista;
				$prod->sh_acumulado = $cont_ant->producao->sh_acumulado;
			}
			$prod->save();

			// salva controle (por enquanto sem as respostas)
			if(! $c->save(array(
				'user' => $user,
				'producao' => $prod
			))) // error on save
			{
				exit('erro ao salvar controle');
			}
			
			// cria respostas de avaliações
			$user->group->get();
			$autopreenchimento = 0;
			
			if($user->group->result_count() > 0)	// usuário faz parte COMO ASSISTENTE de pelo menos 1 grupo
			{
				foreach($user->group as $g) // para cada grupo do qual este usuário É ASSISTENTE
				{
					$g->avaliacao->get();
					$g->supervisor->get();
					
					if($g->avaliacao->result_count() > 0)	// grupo possui avaliações associadas
					{
						foreach($g->avaliacao as $a)
						{
							if($a->target == ROLE_ASSISTENTE) // este modelo de avaliação aplica-se a assistentes
							{
								// auto-preenchimento (1 POR ASSISTENTE)
								if($autopreenchimento == 0)
								{
									$autopreenchimento++;
									$resp_auto = new Resposta();
									$resp_auto->status_id = RESP_NAOINICIADO;
									$resp_auto->open_as = OPENAS_AUTO;
									
									// Save all
									if(! $resp_auto->save(array(
										'ref_user' => $user,
										'avaliacao' => $a,
										'author' => $user,
										'controle' => $c
									))) // error on save
									{
										exit('erro auto assistente');
									}
								}

								// preenchimento pelo supervisor
								$resp_superv = new Resposta();
								$resp_superv->status_id = RESP_NAOINICIADO;
								$resp_superv->open_as = OPENAS_SUPERVISOR_ASSISTENTE;
								
								// Save all
								if(! $resp_superv->save(array(
									'ref_user' => $user,
									'avaliacao' => $a,
									'author' => $g->supervisor,
									'controle' => $c
								))) // error on save
								{
									exit('erro supervisor');
								}
							}
						}
					}
					else // grupo ainda não possui avaliações associadas
					{
					}
				}
			}
			
			// é coordenador de algum grupo?
			$autopreenchimento = 0;
			$user->group_coord->get();
			if($user->group_coord->result_count() > 0)
			{
				foreach($user->group_coord as $g) // para cada grupo do qual este usuário É COORDENADOR
				{
					$g->avaliacao->get();
					$g->supervisor->get();
					
					if($g->avaliacao->result_count() > 0)	// grupo possui avaliações associadas
					{
						foreach($g->avaliacao as $a)
						{
							if($a->target == ROLE_COORDENADOR_GRUPO) // este modelo de avaliação aplica-se a coordenadores
							{
								// auto-preenchimento (1 POR COORDENADOR)
								if($autopreenchimento == 0)
								{
									$autopreenchimento++;
									$resp_auto = new Resposta();
									$resp_auto->status_id = RESP_NAOINICIADO;
									$resp_auto->open_as = OPENAS_AUTO;
									
									// Save all
									if(! $resp_auto->save(array(
										'ref_user' => $user,
										'avaliacao' => $a,
										'author' => $user,
										'controle' => $c
									))) // error on save
									{
										exit('erro auto coordenador');
									}
								}

								// preenchimento pelo supervisor
								$resp_superv = new Resposta();
								$resp_superv->status_id = RESP_NAOINICIADO;
								$resp_superv->open_as = OPENAS_SUPERVISOR_COORDENADOR;
								
								// Save all
								if(! $resp_superv->save(array(
									'ref_user' => $user,
									'avaliacao' => $a,
									'author' => $g->supervisor,
									'controle' => $c
								))) // error on save
								{
									exit('erro supervisor do coordenador');
								}
								
								// preenchimento pelo chefe da disciplina
								$resp_chefe = new Resposta();
								$resp_chefe->status_id = RESP_NAOINICIADO;
								$resp_chefe->open_as = OPENAS_CHEFE_COORDENADOR;
								
								$settings = new Setting();
								// Save all
								if(! $resp_chefe->save(array(
									'ref_user' => $user,
									'avaliacao' => $a,
									'author' => $settings->get_chefe_disciplina(),
									'controle' => $c
								))) // error on save
								{
									exit('erro chefe da disciplina, coordenador');
								}
							}
						}
					}
					else // grupo ainda não possui avaliações associadas
					{
					}
				}
			}
			
			// é supervisor de algum grupo?
			$autopreenchimento = 0;
			$user->group_superv->get();
			if($user->group_superv->result_count() > 0)
			{
				foreach($user->group_superv as $g) // para cada grupo do qual este usuário É SUPERVISOR
				{
					$g->avaliacao->get();
					
					if($g->avaliacao->result_count() > 0)	// grupo possui avaliações associadas
					{
						foreach($g->avaliacao as $a)
						{
							if($a->target == ROLE_SUPERVISOR_GRUPO) // este modelo de avaliação aplica-se a supervisores
							{
								// auto-preenchimento (1 POR SUPERVISOR)
								if($autopreenchimento == 0)
								{
									$autopreenchimento++;
									$resp_auto = new Resposta();
									$resp_auto->status_id = RESP_NAOINICIADO;
									$resp_auto->open_as = OPENAS_AUTO;
									
									// Save all
									if(! $resp_auto->save(array(
										'ref_user' => $user,
										'avaliacao' => $a,
										'author' => $user,
										'controle' => $c
									))) // error on save
									{
										exit('erro auto supervisor');
									}
								}

								// preenchimento pelo chefe da disciplina
								$resp_chefe = new Resposta();
								$resp_chefe->status_id = RESP_NAOINICIADO;
								$resp_chefe->open_as = OPENAS_CHEFE_SUPERVISOR;
								
								$settings = new Setting();
								// Save all
								if(! $resp_chefe->save(array(
									'ref_user' => $user,
									'avaliacao' => $a,
									'author' => $settings->get_chefe_disciplina(),
									'controle' => $c
								))) // error on save
								{
									exit('erro chefe da disciplina, supervisor');
								}
							}
						}
					}
					else // grupo ainda não possui avaliações associadas
					{
					}
				}
			}

			// Notificação
			$m = new Message();
			$admin = new User();
			$admin->get_by_id(ADMIN_ID);
			$subject = "[Anestesiologia USP] Formulários disponíveis";
			$body = 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!';
			$body .= '<br/>Acesse o sistema para preenchê-los: <a href="' . base_url() . '">' . base_url() . '</a>';

			$m->new_message($admin, $user, $subject, $body);
			
			
		} // fim loop usuários
	} // fim funcao setup
//---------------------------------------------------------------------------------------------------------------------------
		
	// executado diariamente como cron job.
	// para cada usuário, checa se há pendências (preenchimento de avaliações) e dispara
	// os lembretes correspondentes.
	// quando todas as avaliações e a produção tiverem sido preenchidas, faz os cálculos finais (pontuação e valor_total) para
	// cada usuário e cria as aprovações necessárias.
	public function daily()
	{
		// TODO: restringir acesso somente via cli (command-line interface) to prevent remote access attempt
		
		
		$cont = new Controle();
		$cont->get_previous();
		
		if($cont->result_count() > 0) // já foram criados os controles referentes ao mês anterior
		{
			foreach($cont as $i => $c) // para cada controle (1 por usuário)
			{
				$c->user->get();
				$c->producao->get();
				$c->aprovacao->get();
				$c->resposta->get();
				
				// verifica produção
				if($c->producao->modified = NULL) // produção ainda não editada
				{
					$producao_finalizada = FALSE;
				}
				else
				{
					$producao_finalizada = TRUE;
				}
				
				//echo "controle: " . $c->id . "<Br>";
				// verifica avaliações (respostas)
				if($c->resposta->result_count() > 0)
				{
					$avaliacoes_finalizadas = TRUE;
					foreach($c->resposta as $r) // para cada avaliação que precisa ser preenchida referente a este controle
					{
						if($r->status_id != RESP_FINALIZADO) // avaliação ainda não finalizada
						{
							$avaliacoes_finalizadas = FALSE;
							
							//echo "     resposta nao finalizada: " . $r->id . "<Br>";
							
							$r->avaliacao->get();
							$r->ref_user->get();
							$r->author->get();
						
							// lembrete
							$m = new Message();
							$admin = new User();
							$admin->get_by_id(ADMIN_ID);
							$user = $r->author;
							$subject = "[Anestesiologia USP] Lembrete do sistema: avaliação não finalizada";
							$body = 'A avaliação "' . $r->avaliacao->name . '", referente a ' . $r->ref_user->nome . ' (mês: ' . traduz_mes($c->ref_mes) . '/' . obter_ano($c->ref_mes) . ') encontra-se disponível no sistema.';
							$body .= '<br/>Acesse o sistema para preenchê-la: <a href="' . base_url() . '">' . base_url() . '</a>';

							$m->new_message($admin, $user, $subject, $body);
						}
					}

					if($avaliacoes_finalizadas && $producao_finalizada) // todas as avaliações e a produção foram finalizadas. Podemos fazer os cálculos do mês e criar as aprovações necessárias
					{
						if(!$c->pontuacao || !$c->valor_total) // ainda não foi calculada a pontuação ou o valor total
						{
							// pontuação:
							// ASSISTENTE --> pontuacao = auto-avaliacao[1] + media(soma(supervisores[9]))
							// COORDENADOR DE GRUPO --> pontuacao = auto_avaliacao[1] + chefe[3] + supervisor[6]
							// SUPERVISOR DE GRUPO --> pontuacao = auto_avaliacao[1] + chefe[9]
							// CHEFE --> não tem pontuacao

							$c->resposta->get();
							if($c->resposta->result_count() > 0)
							{
								$score_superv = 0;
								$score_auto = 0;
								$score_chefe = 0;
								
								$cont_superv = 0;
								
								foreach($c->resposta as $r)
								{
									switch($r->open_as)
									{
										case OPENAS_AUTO:
											$score_auto = $r->score;
											break;
											
										case OPENAS_COORDENADOR_ASSISTENTE:
											// não utilizado
											break;
											
										case OPENAS_SUPERVISOR_ASSISTENTE:
											$score_superv += $r->score;
											$cont_superv++;
											break;
											
										case OPENAS_SUPERVISOR_COORDENADOR:
											$score_superv += $r->score;
											break;
											
										case OPENAS_CHEFE_COORDENADOR:
											$score_chefe += $r->score;
											break;
											
										case OPENAS_CHEFE_SUPERVISOR:
											$score_chefe += $r->score;
											break;
									}
								}
								if($cont_superv > 1) $score_superv = $score_superv / $cont_superv; // calcula média dos scores dos supervisores do assistente
								$c->pontuacao = $score_auto + $score_superv + $score_chefe;
							}
							
							// obtém tabela de salários
							$s = new Setting();
							$s->where('param', 'tabela_salarios')->get();
							$sal = unserialize($s->value);
							
							// obtém produção
							$c->producao->get();
							
							// calcula valor plantões
							$valor_plantoes_0 = (!is_mumeric($c->producao->compl_plantoes_qtde_0) || !is_numeric($c->producao->compl_plantoes_valor_0)) ? 0 : $c->producao->compl_plantoes_qtde_0 * $c->producao->compl_plantoes_valor_0;
							$valor_plantoes_1 = (!is_mumeric($c->producao->compl_plantoes_qtde_1) || !is_numeric($c->producao->compl_plantoes_valor_1)) ? 0 : $c->producao->compl_plantoes_qtde_1 * $c->producao->compl_plantoes_valor_1;
							$valor_plantoes_2 = (!is_mumeric($c->producao->compl_plantoes_qtde_2) || !is_numeric($c->producao->compl_plantoes_valor_2)) ? 0 : $c->producao->compl_plantoes_qtde_2 * $c->producao->compl_plantoes_valor_2;
							$c->valor_plantoes = $valor_plantoes_0 + $valor_plantoes_1 + $valor_plantoes_2;
							
							// calcula valor / hora
							if($c->pontuacao <= 350)
							{
								$c->valor_hora = $c->producao->salario_hc;
							}
							else if($c->pontuacao <= 500)
							{
								$c->valor_hora = $sal[2 + $c->producao->nivel];
							}
							else if($c->pontuacao <= 650)
							{
								$c->valor_hora = $sal[5 + $c->producao->nivel];
							}
							else if($c->pontuacao <= 800)
							{
								$c->valor_hora = $sal[8 + $c->producao->nivel];
							}
							else if($c->pontuacao <= 950)
							{
								$c->valor_hora = $sal[11 + $c->producao->nivel];
							}
							else if($c->pontuacao <= 1000)
							{
								$c->valor_hora = $sal[14 + $c->producao->nivel];
							}
							
							// calcula valor jornada sem desconto
							$c->valor_jornada = $c->valor_hora * $c->producao->ch_cumprida;
							
							// calcula valor total = valor plantoes + valor jornada - desconto
							$c->valor_total = $c->valor_plantoes + $c->valor_jornada - $c->producao->desconto;
							
							// salva controle com os dados atualizados
							if(! $c->save()) // error on save
							{
								exit('erro ao salvar controle ID: ' . $c->id);
							}
						}
					
						if($c->aprovacao->result_count() < 1)	// ainda não foram adicionadas as aprovações necessárias
						{
							// ASSISTENTE --> todos os supervisores dos grupos a que o assistente pertence devem aprovar seu controle
							$c->user->group->get();
							
							if($c->user->group->result_count() > 0)	// usuário faz parte COMO ASSISTENTE de pelo menos 1 grupo
							{
								foreach($c->user->group as $g) // para cada grupo do qual este usuário É ASSISTENTE
								{
									$g->supervisor->get();
									
									$aprov = new Aprovacao();
									$aprov->status_id = NAO_APROVADO;
									
									// Save all
									if(! $aprov->save(array(
										'user' => $g->supervisor,
										'controle' => $c
									))) // error on save
									{
										exit('erro aprovacao supervisor de assistente');
									}
									else
									{
										echo "<br>salvou aprovacao supervidor de assistente: " . $aprov->id;
									}
								}
							}
							
							// COORDENADOR --> supervisor deverá aprovar seu controle
							$c->user->group_coord->get();
							if($c->user->group_coord->result_count() > 0)
							{
								foreach($c->user->group_coord as $g) // para cada grupo do qual este usuário É COORDENADOR
								{
									$g->supervisor->get();
									
									$aprov = new Aprovacao();
									$aprov->status_id = NAO_APROVADO;
									
									// Save all
									if(! $aprov->save(array(
										'user' => $g->supervisor,
										'controle' => $c
									))) // error on save
									{
										exit('erro aprovacao supervisor de coordenador');
									}
								}
							}

							// SUPERVISOR --> chefe da disciplina deverá aprovar seu controle
							$c->user->group_superv->get();
							if($c->user->group_superv->result_count() > 0)
							{
								foreach($c->user->group_superv as $g) // para cada grupo do qual este usuário É SUPERVISOR
								{
									$settings = new Setting();
								
									$aprov = new Aprovacao();
									$aprov->status_id = NAO_APROVADO;
									
									// Save all
									if(! $aprov->save(array(
										'user' => $settings->get_chefe_disciplina(),
										'controle' => $c
									))) // error on save
									{
										exit('erro aprovacao do chefe referente a supervisor');
									}	
								}
							}
							
							// CHEFE --> ninguém precisa aprovar
						}
						else // aprovações já haviam sido criadas
						{
							if($c->todas_aprovacoes_finalizadas()) // todas as aprovações já foram finalizadas com o status APROVADO. 
							{
								$c->status_id = STATUS_CONTROLE_FINALIZADO;
								if(! $c->save()) // muda status do controle
								{
									// notifica usuário
									$m = new Message();
									$admin = new User();
									$admin->get_by_id(ADMIN_ID);
									$user = $c->user;
									$subject = "[Anestesiologia USP] Avaliações finalizadas";
									$body = 'As avaliações e cálculos referentes às metas assistenciais e salário (ref.: ' . traduz_mes($c->ref_mes) . '/' . obter_ano($c->ref_mes) . ') encontram-se finalizadas.';
									$body .= '<br/>Acesse o sistema para visualizar: <a href="' . base_url() . '">' . base_url() . '</a>';

									$m->new_message($admin, $user, $subject, $body);
								}
								else
								{
									exit('erro mudança status controle');
								}
							}
							else // resta alguma aprovação pendente. Envia lembrete para cada uma delas.
							{
								$aprov = $c->aprovacao->where('status_id', NAO_APROVADO)->get();
								foreach($aprov as $a)
								{					
									$a->user->get();
								
									$m = new Message();
									
									$admin = new User();
									$admin->get_by_id(ADMIN_ID);
									$user = $a->user;
									$subject = "[Anestesiologia USP] Lembrete do sistema: aprovação pendente - " . $c->user->nome;
									$body = 'Há uma aprovação pendente no sistema (ref.: ' . traduz_mes($c->ref_mes) . '/' . obter_ano($c->ref_mes) . ').';
									$body .= '<br/>Referente a: <em>' . $c->user->nome . '</em>';
									$body .= '<br/>Acesse o sistema para visualizá-la: <a href="' . base_url() . '">' . base_url() . '</a>';

									$m->new_message($admin, $user, $subject, $body);								
								}
							}
						}
						
					}
					else // resta alguma avaliação ou produção não finalizada
					{
						// TODO: notifica admin se estiver chegando num dia predefinido
					}
				}
			}
		}
	} // fim funcao daily

//---------------------------------------------------------------------------------------------------------------------------	

	public function finish()
	{
		
		
	} // fim funcao finish
//---------------------------------------------------------------------------------------------------------------------------		
} // fim classe

