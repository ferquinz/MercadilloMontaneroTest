<?php
class Productos extends CI_Model {

	var $table = 'productos';
	var $table_imagenes = 'productos_imagenes';
	
	public function __construct() {
		$this -> load -> database();
	}

	public function get_products($slug, $filter, $id = 0) {

		$qc = "SELECT A.id, A.title, A.place, A.price, A.contact, A.description, A.sold, A.visitas, A.password, A.category, A.fbchecked, A.fbname,  GROUP_CONCAT(A.files) AS files FROM
	                							(SELECT productos.Producto_id AS id, Titulo AS title, Lugar AS place, Precio AS price, Contacto AS contact, Descripcion AS description, Vendido AS sold, 
	                								Visitas AS visitas, Contraseña AS password, Categoria_id AS category,  productos_imagenes.Imagen_url AS files, FBChecked AS fbchecked, FBName AS fbname
													FROM productos
													LEFT JOIN productos_imagenes ON productos.Producto_id = productos_imagenes.Producto_id
													WHERE 1 AND VENDIDO = 0) A 
													WHERE 1 = 1 AND A.id > 0 ";
		if ($slug != 7){
			$qc .= " AND A.category = " . $slug . "";
		}
		if (!empty($filter)){
			$qc .= ' AND A.title LIKE concat("%'. $filter .'%") ';
		}
		$qc .= " GROUP BY A.id LIMIT 21 ";
		$query = $this->db->query($qc);
		return $query->result_array();
		
		/*if (!empty($filter)){
			
													
			$query = $this->db->query('SELECT A.id, A.title, A.place, A.price, A.contact, A.description, A.sold, A.stars, A.password, A.category,  GROUP_CONCAT(A.files) AS files FROM
	                							(SELECT productos.Producto_id AS id, Titulo AS title, Lugar AS place, Precio AS price, Contacto AS contact, Descripcion AS description, Vendido AS sold, 
	                								Estrellas AS stars, Contraseña AS password, Categoria_id AS category,  productos_imagenes.Imagen_url AS files
													FROM productos
													LEFT JOIN productos_imagenes ON productos.Producto_id = productos_imagenes.Producto_id
													WHERE 1) A
												WHERE A.category = ' . $slug . ' AND 1 = 1 AND A.title LIKE concat("%'. $filter .'%") 
												GROUP BY A.id');
			return $query->result_array();

			$query = $this->db->get_where('productos', array('slug' => $slug, 'filter' => $filter));
			return $query->row_array();
		} else{
			$query = $this->db->query('SELECT A.id, A.title, A.place, A.price, A.contact, A.description, A.sold, A.stars, A.password, A.category,  GROUP_CONCAT(A.files) AS files FROM
	                							(SELECT productos.Producto_id AS id, Titulo AS title, Lugar AS place, Precio AS price, Contacto AS contact, Descripcion AS description, Vendido AS sold, 
	                								Estrellas AS stars, Contraseña AS password, Categoria_id AS category,  productos_imagenes.Imagen_url AS files
													FROM productos
													LEFT JOIN productos_imagenes ON productos.Producto_id = productos_imagenes.Producto_id
													WHERE 1) A
												WHERE A.category = ' . $slug . ' AND 1 = 1 
												GROUP BY A.id');
			return $query->result_array();

			$query = $this->db->get_where('productos', array('slug' => $slug));
			return $query->row_array();
		}*/
		/*return $query->result_array();

		$query = $this->db->get_where('productos', array('slug' => $slug));
		return $query->row_array();*/
	}
	
	public function get_product_data($slug) {
		
		$query = $this->db->query('SELECT A.id, A.title, A.place, A.price, A.contact, A.description, A.sold, A.visitas, A.password, A.category, A.fbchecked, A.fbname,  GROUP_CONCAT(A.files) AS files FROM
	                							(SELECT productos.Producto_id AS id, Titulo AS title, Lugar AS place, Precio AS price, Contacto AS contact, Descripcion AS description, Vendido AS sold, 
	                								Visitas AS visitas, Contraseña AS password, Categoria_id AS category,  productos_imagenes.Imagen_url AS files, FBChecked AS fbchecked, FBName AS fbname
													FROM productos
													LEFT JOIN productos_imagenes ON productos.Producto_id = productos_imagenes.Producto_id
													WHERE 1 AND VENDIDO = 0 AND productos.Producto_id = '. $slug .') A');

		return $query->result_array();

		$query = $this->db->get_where('productos', array('slug' => $slug));
		return $query->row_array();
	}

	public function get_products_images($slug = FALSE) {
		if ($slug === FALSE) {
			$query = $this -> db -> get('productos_imagenes');
			return $query -> result_array();
		}

		$query = $this -> db -> get_where('productos_imagenes', array('slug' => $slug));
		return $query -> row_array();
	}

	public function save($data)
    {
    	$this->db->set('FechaModificacion', 'NOW()', FALSE);
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

	public function save_img($data)
	{
		$this->db->insert($this->table_imagenes, $data);
	}
	
	public function delete_by_id($id)
    {
    	$data = array('Vendido' => 1);
		$this->db->where('Producto_id', $id);
		$this->db->update($this->table, $data);
		
        /*$this->db->where('Producto_id', $id);
        $this->db->delete($this->table);*/
		$this->db->where('Producto_id', $id);
		$this->db->delete($this->table_imagenes);
    }

	public function getpass($productid)
	{  
	    //$this->db->where('Producto_id', $productid);
	    //$query = $this->db->get($this->table);
		$query = $this->db->get_where($this->table, array('Producto_id' => $productid));
	    //$query = $this->db->query('SELECT Contraseña FROM productos WHERE Producto_id = '. $productid .'');
	    /*if($query->num_rows > 0)
	    {
	        return $query->row();
	    }
	    return $query;*/
		
		$row = $query->row_array();

		if (isset($row)){
			return $row['Contraseña'];
		}
		return FALSE;
	}

	public function get_category_name($categoryid){
		$query = $this->db->query('SELECT Categoria FROM categorias WHERE Categoria_id = '. $categoryid .'');

		return $query->row()->Categoria;
	}
	
	public function update_visits($id, $visitas){
		
		$data = array('Visitas' => $visitas);

		$this->db->where('Producto_id', $id);
		$this->db->update($this->table, $data);
				
	}
	
	public function cargar_mas($tipolistado, $filter, $ultimo)
	{
		/*$this->db->where('id <',$ultimo);
		$this->db->order_by('id','desc');
		$query = $this->db->get('users', 4);*/
		
		$qc = "SELECT A.id, A.title, A.place, A.price, A.contact, A.description, A.sold, A.visitas, A.password, A.category, A.fbchecked, A.fbname,  GROUP_CONCAT(A.files) AS files FROM
	                							(SELECT productos.Producto_id AS id, Titulo AS title, Lugar AS place, Precio AS price, Contacto AS contact, Descripcion AS description, Vendido AS sold, 
	                								Visitas AS visitas, Contraseña AS password, Categoria_id AS category,  productos_imagenes.Imagen_url AS files, FBChecked AS fbchecked, FBName AS fbname
													FROM productos
													LEFT JOIN productos_imagenes ON productos.Producto_id = productos_imagenes.Producto_id
													WHERE 1 AND VENDIDO = 0) A 
													WHERE 1 = 1 AND A.id > " . $ultimo . "";
		if ($tipolistado != 7){
			$qc .= " AND A.category = " . $tipolistado . "";
		}
		if (!empty($filter)){
			$qc .= ' AND A.title LIKE concat("%'. $filter .'%") ';
		}
		$qc .= " GROUP BY A.id LIMIT 21 ";
		$query = $this->db->query($qc);
		//return $query->result_array();
		
		if($query->num_rows()>0)
		{
			return $query->result();
		}	
		return FALSE;	
	}
	
}
?>