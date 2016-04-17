<?php
/**
 * User: Fernando
 * Date: 20/11/15
 * Time: 23:05
 */

class Inicio extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index() {

		/*if (isset($_GET['tipolistado'])) {
			$data["tipolistado"] = $_GET['tipolistado'];
		} else {*/
			$data["tipolistado"] = 0;
		//}

		$this -> load -> helper('url');
		$this -> load -> view("templates/header");
		$this -> load -> view("templates/menu", $data);
		$this -> load -> view("inicio");
		$this->load->view('templates/footer');
		$this->load->view('templates/fin');
	}

}
?>