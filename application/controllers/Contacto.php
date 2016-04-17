<?php
/**
 * User: Fernando
 * Date: 20/11/15
 * Time: 23:05
 */

class Contacto extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> helper('url_helper');
		$this -> load -> helper('date');
		$this -> load -> library('image_lib');
		$this -> load -> library('session');
	}

	public function index($param = '') {

		//if (isset($_GET['tipolistado'])) {
			$data["tipolistado"] = 8;
			$data["pagina"] = "Contacto";

			$this -> session -> set_userdata(array('tipolistado' => $data["tipolistado"], 'pagina' => $data["pagina"]));

		/*} else if ($param <> '') {
			$data["tipolistado"] = $this -> session -> userdata('tipolistado');
			$data["pagina"] = $this -> session -> userdata('pagina');

		} else {
			show_404();
		}*/

		//$this -> load -> helper('url');
		$this -> load -> view("templates/header");
		$this -> load -> view("templates/menu", $data);
		$this -> load -> view("contacto", $data);
		$this -> load -> view('templates/footer');
		$this -> load -> view('templates/scroll');
		$this -> load -> view('templates/fin');
	}

	public function contactvalidate() {
		//$this -> load -> library('form_validation');

		//if ($this -> input -> post()) {
			$nombre = $this -> input -> post('nombre');
			$email = $this -> input -> post('email');
			$asunto = $this -> input -> post('asunto');
			$mensaje = $this -> input -> post('mensaje');
			/*$this -> form_validation -> set_rules('nombre', 'name', 'required');
			$this -> form_validation -> set_rules('email', 'mail', 'required|valid_email');
			$this -> form_validation -> set_rules('asunto', 'subject');
			$this -> form_validation -> set_rules('mensaje', 'message');*/
		//}
		//if ($this -> form_validation -> run() === true) {
			//Send the email

			if ($this -> sendemail($nombre, $email, $asunto, $mensaje)) {
				//If successful load the appropriate view
				//$data["pagina"] = $this -> session -> userdata('pagina');
				$datos = "OK";//$this -> load -> view("contacto", $data);
				
			}
		//} 
		else {
			//If page exists load all necessary views
			//$this -> load -> view('general/view_header');
			//$this -> load -> view('page/view_contact');
			//$this -> load -> view('general/view_footer');
			//redirect('/Contacto?tipolistado=8');
			$datos = "ERROR";
		}
		echo json_encode(array("status" => 'OK', "data" => $datos));
	}

	private function sendemail($nombre, $email, $asunto, $mensaje) {

		//Load the email library
		$this -> load -> library('email');

		//Initialise the email helper and set the "from"
		$this -> email -> initialize(array("mailtype" => "html"));
		$this -> email -> from($email, $nombre);

		//Set the recipient, subject and message based on the page
		$this -> email -> to('mercadillomontanero@gmail.com');
		$this -> email -> subject('Sugerencia - '.$asunto);
		$this -> email -> message($mensaje);

		//If the email is sent
		if ($this -> email -> send()) {
			return true;
		} else {
			return false;
		}

	}

}
?>