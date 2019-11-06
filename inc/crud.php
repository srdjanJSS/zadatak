<?php 

	require_once("database.php");

	class Crud {
		private $db;

		public function __construct() {
			$this->db = new Database;
		}

		// Get Row Number
		public function getRowNumber() {
			$this->db->query('SELECT * from zadatak1');
			$results = $this->db->resultset();
			$results = $this->db->rowCount();

			return $results;
		}

		// Get All Posts
		public function getPosts() {
			$this->db->query('SELECT * from zadatak1');
			$results = $this->db->resultset();

			return $results;
		}

		// Get Post By ID
		public function getPostById($id) {
			$this->db->query("SELECT * from zadatak1 WHERE id = :id");

			$this->db->bind(':id', $id);

			$row = $this->db->single();

			return $row;
		}

		// Add Post
		public function addPost($data) {
			// Prepare Query
			$this->db->query('INSERT INTO zadatak1 (element, id, ime, prezime, poeni, kategorija, red, tip) VALUES (:element, :id, :ime, :prezime, :poeni, :kategorija, :red, :tip)');
			
			// Bind Values
			$this->db->bind(':element', 	$data['element']);
			$this->db->bind(':id', 			$data['id']);
			$this->db->bind(':ime', 		$data['ime']);
			$this->db->bind(':prezime', 	$data['prezime']);
			$this->db->bind(':poeni', 		$data['poeni']);
			$this->db->bind(':kategorija', 	$data['kategorija']);
			$this->db->bind(':red', 		$data['red']);
			$this->db->bind(':tip', 		$data['tip']);

			// Execute
			if ($this->db->execute()) {
				return true;
			} else {
				return false;
			}
		}

		// Update Post
		public function updatePost($data) {
			// Prepare Query
			$this->db->query('UPDATE zadatak1 SET element = :element, ime = :ime, prezime = :prezime, poeni = :poeni, kategorija = :kategorija, red = :red, tip = :tip WHERE id = :id');

			// Bind Values
			$this->db->bind(':element', 	$data['element']);
			$this->db->bind(':id', 			$data['id']);
			$this->db->bind(':ime', 		$data['ime']);
			$this->db->bind(':prezime', 	$data['prezime']);
			$this->db->bind(':poeni', 		$data['poeni']);
			$this->db->bind(':kategorija', 	$data['kategorija']);
			$this->db->bind(':red', 		$data['red']);
			$this->db->bind(':tip', 		$data['tip']);

			// Execute
			if ($this->db->execute()) {
				return true;
			} else {
				return false;
			}
		}
	
    // Check if post exist
		public function postExist($id) {
			
			$this->db->query("SELECT * FROM zadatak1 WHERE id = :id");
			$this->db->bind(':id', $id);
			$this->db->execute();

			if($this->db->rowCount() > 0){
   			return "exist";
			} else { 
  			return "notExist";
			}
		}

		// Delete Post
		public function deletePost($id) {
			// Prepare Query
			$this->db->query('DELETE FROM zadatak1 WHERE id = :id');

			// Bind Values
			$this->db->bind(':id', $id);

			// Execute
			if ($this->db->execute()) {
				return true;
			} else {
				return false;
			}
		}

		// Delete All
		public function deleteAll() {
			// Prepare Query
			$this->db->query('TRUNCATE TABLE zadatak1');

			// Execute
			if ($this->db->execute()) {
				return true;
			} else {
				return false;
			}
		}
	}
?>