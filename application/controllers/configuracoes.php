<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuracoes extends CI_Controller {

	public function index()
	{
		redirect("/configuracoes/email/");
	}
	
	public function email()
	{
		// TODO: checar permissoes de acesso
	
		if($this->input->post('submit')) // form submitted
		{
			$post = $this->input->post(NULL, TRUE); // returns all POST items with XSS filter 
					
			$set = new Setting();
			$set->where('param', 'email_host')->update('value', $post['host']);
			$set->where('param', 'email_username')->update('value', $post['username']);
			$set->where('param', 'email_password')->update('value', $post['password']);
			$set->where('param', 'email_fromName')->update('value', $post['fromName']);
			$set->where('param', 'email_port')->update('value', $post['port']);
			$set->where('param', 'email_SMTPSecure')->update('value', $post['SMTPSecure']);
			$set->where('param', 'email_SMTPAuth')->update('value', $post['SMTPAuth']);
			
			redirect("");
			return;
		}
		else  // form wasnt submitted
		{
			$set = new Setting();
			$set->like('param', '%email_%')->get();
			if($set->result_count() > 0) // encontrado!
			{
				$dad = array();
				foreach($set as $s)
				{
					$dad[$s->param] = $s->value;
				}
				$dad = arrayToObject($dad);
				$data['set'] = $dad;
			}
			else
			{
				$data['set'] = NULL;
			}

			$data['title'] = 'Editar configurações do e-mail do sistema';
			$this->load->view('edit_email', $data);	
		}
	
	}
	
	public function salario()
	{
		// TODO: checar permissoes de acesso
	
		if($this->input->post('submit')) // form submitted
		{
			$post = $this->input->post(NULL, TRUE); // returns all POST items with XSS filter 
			$salarios = serialize($post['sal']);
			
			$set = new Setting();
			$set->where('param', 'tabela_salarios')->update('value', $salarios);
			
			redirect("");
			return;
		}
		else  // form wasnt submitted
		{
			$set = new Setting();
			$set->where('param', 'tabela_salarios')->get();
			if($set->result_count() > 0) // encontrado!
			{
				if(!empty($set->value))
				{
					$data['sal'] = unserialize($set->value);
				}
				else
				{
					$data['sal'] = NULL;
				}
			}
			else
			{
				$data['sal'] = NULL;
			}

			$data['title'] = 'Editar tabela de salários';
			$this->load->view('edit_salario', $data);	
		}
	}
}

