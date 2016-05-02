<?php
/**
 * User: Fernando
 * Date: 20/11/15
 * Time: 23:05
 */

class FichaProducto extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		$this -> load -> model('productos', 'product');
		$this -> load -> helper('url_helper');
	}

	public function index() {

		if (isset($_GET['Producto_id'])) {
			$data["Producto_id"] = $_GET['Producto_id'];
			$data['product_data'] = $this->product->get_product_data($data["Producto_id"]);
		}else {
			show_404();
		}

		$this -> load -> helper('url');
		$this -> load -> view("templates/header");
		$this -> load -> view("fichaproducto", $data); 
		$this -> load -> view('templates/fin');
	}	
}

?>
	