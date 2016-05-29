<?php
/**
 * User: Fernando
 * Date: 20/11/15
 * Time: 23:05
 */

class Contacto extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url', 'url_helper', 'date'));
        //$this -> load -> helper('url_helper');
		//$this -> load -> helper('date');
		//$this -> load -> library('image_lib');
		$this->load->library(array('session', 'form_validation', 'image_lib', 'email'));
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
		$this -> load -> view("templates/header_chat");
		$this -> load -> view("templates/menu", $data);
		$this -> load -> view("contacto", $data);
		$this -> load -> view('templates/footer');
		$this -> load -> view('templates/scroll');
		$this -> load -> view('templates/fin');
	}

	public function contactvalidate() {

			$nombre = $this->input->post('nombre');
			$email = $this->input->post('email');
			$asunto = $this->input->post('asunto');
			$mensaje = $this->input->post('mensaje');

			if ($this -> sendemail($nombre, $email, $asunto, $mensaje)) {
				$datos = "OK";				
			}
			else {
				$datos = "ERROR";
			}
			
			echo json_encode(array("status" => 'OK', "data" => $datos));
	}

	private function sendemail($nombre, $email, $asunto, $mensaje) {

		//Load the email library
		$this->load->helper('email');
		$this -> load -> library('email');
		
		/*$config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '25';
        $config['smtp_user'] = 'mercadillomontanero@gmail.com';
        $config['smtp_pass'] = 'irwhghtthe';
        $config['mailtype'] = 'text'; // text or html
        $config['smtp_timeout'] = '7';
        $config['charset'] = 'iso-8859-1'; //utf-8
        $config['wordwrap'] = TRUE;
		$config['validation'] = TRUE; // bool whether to validate email or not  
        $config['newline'] = "\r\n"; //use double quotes*/
        //$this->load->library('email', $config);
        //$this->email->initialize($config);
		
		/*$config['protocol'] = "smtp";
        $config['smtp_host'] = "mx1.hostinger.es";
		$config['smtp_user'] = "mercadillomontanero@mercadillomontanero.esy.es";
		$config['smtp_pass'] = "irwhghtthe";
        $config['mailtype'] = 'text';
        $config['charset']  = 'utf-8';
        $config['newline']  = "\r\n";
        $config['wordwrap'] = TRUE;*/
		
		$config['imap_host'] = 'mx1.hostinger.es';
		$config['imap_user'] = 'mercadillomontanero@mercadillomontanero.esy.es';
		$config['imap_pass'] = 'irwhghtthe';
		$config['imap_port'] = '143';
		$config['imap_mailbox'] = 'INBOX';
		$config['imap_path'] = '';
		$config['imap_server_encoding'] = 'utf-8';
		$config['imap_attachemnt_dir'] = './tmp/';
		
		$this->email->initialize($config);
		
		//Initialise the email helper and set the "from"
		//$this -> email -> initialize(array("mailtype" => "html"));
		$this->email->from($email, $nombre);

		//Set the recipient, subject and message based on the page
		$this->email->to('mercadillomontanero@gmail.com');
		$this->email->subject('Sugerencia - '.$asunto);
		$this->email->message($mensaje);
		
		//If the email is sent
		if ($this -> email -> send()) {
			echo "<pre>".$this->email->print_debugger() ."</pre>";  
    		print_r($mensaje); 
			//return true;
		} else {
			echo "<pre>".$this->email->print_debugger() ."</pre>";  
        	print_r($mensaje); 
			//return false;
		}

	}

}
?>