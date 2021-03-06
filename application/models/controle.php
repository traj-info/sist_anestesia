<?php

/**
 * Controle DataMapper Model
 *
 */
class Controle extends DataMapper {

	var $model = 'controle';
	var $table = 'controles';

	// Insert related models that Controle can have just one of.
	var $has_one = array('user', 'producao');

	// Insert related models that Controle can have more than one of.
	var $has_many = array('aprovacao', 'resposta');

	// --------------------------------------------------------------------
	// Validation
	//   Add validation requirements, such as 'required', for your fields.
	// --------------------------------------------------------------------

	var $validation = array(
	);

	// --------------------------------------------------------------------
	// Default Ordering
	//   Uncomment this to always sort by 'name', then by
	//   id descending (unless overridden)
	// --------------------------------------------------------------------

	// var $default_order_by = array('name', 'id' => 'desc');

	// --------------------------------------------------------------------

	/**
	 * Constructor: calls parent constructor
	 */
    function __construct($id = NULL)
	{
		parent::__construct($id);
    }

	// --------------------------------------------------------------------
	// Post Model Initialisation
	//   Add your own custom initialisation code to the Model
	// The parameter indicates if the current config was loaded from cache or not
	// --------------------------------------------------------------------
	function post_model_init($from_cache = FALSE)
	{
	}

	// --------------------------------------------------------------------
	// Custom Methods
	//   Add your own custom methods here to enhance the model.
	// --------------------------------------------------------------------

	/* Example Custom Method
	function get_open_controles()
	{
		return $this->where('status <>', 'closed')->get();
	}
	*/
	
	// retorna os controles referentes aos meses anteriores. Por padr�o, a 1 m�s anterior.
	function get_previous($dif_meses = 1)
	{
		$previous_month = date("Y-m", strtotime("-" . $dif_meses . " month")) . '-01'; // YYYY-MM-DD (dd sempre 01)
		return $this->where('ref_mes', $previous_month)->get();
	}

	
	// retorna TRUE se todas as aprova��es estiverem com o status APROVADO, i.e., se n�o houver nenhuma aprova��o com o status NAO_APROVADO
	function todas_aprovacoes_finalizadas()
	{
		return ($this->aprovacao->where('status_id', NAO_APROVADO)->count() == 0);
	}
	
	// --------------------------------------------------------------------
	// Custom Validation Rules
	//   Add custom validation rules for this model here.
	// --------------------------------------------------------------------

	/* Example Rule
	function _convert_written_numbers($field, $parameter)
	{
	 	$nums = array('one' => 1, 'two' => 2, 'three' => 3);
	 	if(in_array($this->{$field}, $nums))
		{
			$this->{$field} = $nums[$this->{$field}];
	 	}
	}
	*/
}

/* End of file controle.php */
/* Location: ./application/models/controle.php */
