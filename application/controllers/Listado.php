<?php
/**
 * User: Fernando
 * Date: 20/11/15
 * Time: 23:05
 */

class Listado extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> model('productos', 'product');
		$this -> load -> helper('url_helper');
		$this -> load -> helper('date');
		$this -> load -> library('image_lib');
		$this -> load -> library('session');
	}

	public function index($param = '') {
		
		$tipolistado = $this->uri->segment(2);
		if(is_numeric($tipolistado)){
			if(0 < $tipolistado && $tipolistado < 8){	
				if (isset($tipolistado)) {
					$data["tipolistado"] = $tipolistado;
					if ($data["tipolistado"] == 7) {
						$data["pagina"] = "Novedades";
					} else {
						$data["pagina"] = $this -> product -> get_category_name($tipolistado);
					}
					$this -> session -> set_userdata(array('tipolistado' => $data["tipolistado"], 'pagina' => $data["pagina"]));
					$data['products'] = $this -> product -> get_products($data["tipolistado"], $param);
				} else if ($param <> '') {
					$data["tipolistado"] = $this -> session -> userdata('tipolistado');
					$data["pagina"] = $this -> session -> userdata('pagina');
					$data["products"] = $this -> product -> get_products($this -> session -> userdata('tipolistado'), $param);
		
				} else {
					show_404();
				}
			}
			else{
				show_404();
			}
		}
		else {
			show_404();
		}

		//$this -> load -> helper('url');
		$this -> load -> view("templates/header");
		$this -> load -> view("templates/menu", $data);
		$this -> load -> view("templates/acciones_listado", $data);
		$this -> load -> view("listado", $data);
		$this -> load -> view("templates/modal_product_form");
		$this -> load -> view('templates/footer');
		$this -> load -> view('templates/scroll');
		$this -> load -> view("templates/modal_delete");
		$this -> load -> view('templates/fin');
	}
	public function numero(){
		$valor = $this->uri->segment(2);
		if ($valor == 7) {
			$data["pagina"] = "Novedades";
		} else {
			$data["pagina"] = $this -> product -> get_category_name($valor);
		}
		$this -> session -> set_userdata(array('tipolistado' => $data["tipolistado"], 'pagina' => $data["pagina"]));		
	}

	public function ajax_get_data() {
		$id = $this -> input -> post('productid');
		$datos = $this->product->get_product_data($id);	
		echo json_encode(array("status" => "success", "datos" => $datos));
	}
	
	public function ajax_add() {
		$value = $this -> input -> post('facebook');
		$chek = 0;
		if ($value == TRUE) {
			$chek = 1;
		}
		$data = array('Titulo' => $this -> input -> post('title'), 'Lugar' => $this -> input -> post('place'), 'Categoria_id' => $this -> input -> post('category'), 'Precio' => $this -> input -> post('price'), 'Contacto' => $this -> input -> post('contact'), 'Contraseña' => md5($this -> input -> post('pass')), 'Descripcion' => $this -> input -> post('description'), 'Vendido' => 0, 'Visitas' => 0, 'FBChecked' => $chek, 'FBName' => $this -> input -> post('txtfbname'));	
		$insert = $this -> product -> save($data);
		
		$data_places = array('Producto_id' => $insert, 'Ciudad' => $this -> input -> post('ciudad'), 'Provincia' => $this -> input -> post('provincia'), 'Pais' => $this -> input -> post('pais'));
		$this->ajax_add_places($data_places);

		if (is_array($_FILES)) {
			/*Crear carpeta que almacena las imagenes visor*/
			$path_first = "img/images/" . $insert;
			mkdir($path_first, 0777);
			$path_thumb = "img/images/" . $insert . "/thumb";
			mkdir($path_thumb, 0777);
			$path = "img/images/" . $insert . "/basic";
			mkdir($path, 0777);
			
			foreach ($_FILES AS $index => $file) {
				// for easy access
				$fileName = $file['name'];
				// for easy access
				$fileTempName = $file['tmp_name'];
				// check if there is an error for particular entry in array
				if (!empty($file['error'][$index])) {
					// some error occurred with the file in index $index
					// yield an error here
					return false;
				}

				// check whether file has temporary path and whether it indeed is an uploaded file
				if (!empty($fileTempName) && is_uploaded_file($fileTempName)) {
					// move the file from the temporary directory to somewhere of your choosing
					move_uploaded_file($fileTempName, $path . "/" . $fileName);
					$data_img = array('Producto_id' => $insert, 'Imagen_url' => "../" . $path . "/" . $fileName);
					$this -> product -> save_img($data_img);

					$this->do_resize($path, $path_thumb, $fileName);
				}
			}
		}

		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_add_places($data){
		$this -> product -> save_places($data);
	}

	public function do_resize($path, $path_thumb, $filename) {
		//$this -> load -> library('image_lib');
		$source_path = './' . $path . '/' . $filename;
		$target_path = './' . $path_thumb;
		$config_manip = array(
			'image_library' => 'gd2', 
			'source_image' => $source_path, 
			'new_image' => $target_path, 
			'maintain_ratio' => TRUE, 
			'create_thumb' => TRUE, 
			'thumb_marker' => '', 
			'width' => 250, 
			'height' => 250
		);
		//$this->load->library('image_lib', $config_manip);
		$this->image_lib->initialize($config_manip);
		//$this -> load -> library('image_lib', $config_manip);
		if (!$this -> image_lib -> resize()) {
			echo $this -> image_lib -> display_errors();
		}
		// clear //
		$this -> image_lib -> clear();
	}

	public function ajax_delete() {
		$id = $this -> input -> post('productid');

		$result = $this -> product -> getpass($id);
		$status = 0;
		if ($result) {
			if (strcmp(md5($this -> input -> post('productpass')), $result) == 0) {
				/* ELIMINAMOS SOLO LA CARPETA PRINCIPAL DEJANDO LOS THUMBS (BORRADO LOGICO)*/
				$dir = "./img/images/" . $id . "/basic";
				/*$path = $this -> config -> base_url() . "img/images/" . $id;*/
				$this -> load -> helper("file");
				// load the helper
				delete_files($dir, true);
				rmdir($dir);
				$this -> product -> delete_by_id($id);

				$status = 1;

				$data["tipolistado"] = $this -> session -> userdata('tipolistado');
				$data["pagina"] = $this -> session -> userdata('pagina');
				$data["products"] = $this -> product -> get_products($this -> session -> userdata('tipolistado'), '');
				$datos = $this -> load -> view("listado", $data, TRUE);
			} else {
				$datos = $result;
			}
		} else {
			$datos = $result;
		}
		echo json_encode(array("status" => $status, "datos" => $datos));
	}

	public function deleteDirectory($dir) {
		if (!file_exists($dir))
			return true;
		if (!is_dir($dir) || is_link($dir))
			return unlink($dir);
		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..')
				continue;
			if (!deleteDirectory($dir . "/" . $item)) {
				chmod($dir . "/" . $item, 0777);
				if (!deleteDirectory($dir . "/" . $item))
					return false;
			};
		}
		return rmdir($dir);
	}

	public function ajax_filter($filtro = '') {

		$data["tipolistado"] = $this -> session -> userdata('tipolistado');
		$data["pagina"] = $this -> session -> userdata('pagina');
		$this -> session -> set_userdata(array('tipolistado' => $data["tipolistado"], 'pagina' => $data["pagina"], 'filtro' => $filtro));
		$data["products"] = $this -> product -> get_products($this -> session -> userdata('tipolistado'), $filtro);
		$this -> load -> view("listado", $data);

	}

	public function updatevisits() {
		$visitas = $_GET['visitas'] + 1;
		$this -> product -> update_visits($_GET['id'], $visitas);
	}
	
	public function loadMore()
    {
        sleep(3);
        if($this->input->is_ajax_request() && $this->input->post("lastId"))
        {
            $nuevos_datos = $this->product->cargar_mas($this -> session -> userdata('tipolistado'), $this -> session -> userdata('filtro'), (int)$this->input->post("lastId"));
            if($nuevos_datos !== FALSE)
            {
                echo json_encode(array("res" => "success", "users" => $nuevos_datos));
            }
            else
            {
                echo json_encode(array("res" => "empty"));
            }
        }
    }

}
?>