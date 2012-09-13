<?php $this->load->view('header'); ?>
<?php echo (isset($msg) && isset($msg_type) )? msg($msg, $msg_type) : ''; ?>
<h2><?php echo $title; ?></h2>

<?php
$attributes = array('class' => 'traj_form', 'id' => 'frmEditEmail', 'name' => 'frmEditEmail');

echo validation_errors();

if($set)
{
	echo form_open('configuracoes/email', $attributes);
	echo "<div class='fields_holder'>";

	echo "<div class='field_holder'>";
	echo form_label('Host', 'host');
	echo form_input('host', $set->email_host);
	echo "</div>";
	
	echo "<div class='field_holder'>";
	echo form_label('Email', 'username');
	echo form_input('username', $set->email_username);
	echo "</div>";
	
	echo "<div class='field_holder'>";
	echo form_label('Senha', 'password');
	echo form_password('password', $set->email_password);
	echo "</div>";
	
	echo "<div class='field_holder'>";
	echo form_label('Nome do destinatário', 'fromName');
	echo form_input('fromName', $set->email_fromName);
	echo "</div>";
	
	echo "<div class='field_holder'>";
	echo form_label('Porta', 'port');
	echo form_input('port', $set->email_port);
	echo "</div>";
	
	echo "<div class='field_holder'>";
	echo form_label('SMTP secure', 'SMTPSecure');
	echo form_input('SMTPSecure', $set->email_SMTPSecure);
	echo "</div>";
	
	echo "<div class='field_holder'>";
	echo form_label('SMTP auth', 'SMTPAuth');
	echo form_input('SMTPAuth', $set->email_SMTPAuth);
	echo "</div>";
	

	echo "<div class='bt_holder'>";
	echo div_clear();
	echo form_submit('submit', 'Salvar alterações');
	echo "</div>"; // bt_holder
	echo "</div>"; // fields_holder
	echo "</form>";
} // end if users
?>
<?php $this->load->view('footer'); ?>