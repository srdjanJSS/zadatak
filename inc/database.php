<?php 
	// PDO Database Class
	require_once ("config/config.php");

	Class Database {
		private $host = DB_HOST;
		private $user = DB_USER;
		Private $pass = DB_PASS;
		private $dbname = DB_NAME;

		private $connection;
		private $error;
		private $stmt;
		private $dbconnected = false;

		public function __construct() {
			// Set Connection
			$dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
			$options = array (
				PDO::ATTR_PERSISTENT => true, 
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);
			
			// Create a new PDO instance		
			try {
				$this->connection = new PDO ($dsn, $this->user, $this->pass, $options);
				$this->dbconnected = true;

			} //Catch any errors
			catch (PDOException $e) {
				$this->error = $e->getMessage().PHP_EOL;
			}
		}

		// Get Error Message
		public function getError() {
			return $this->error;
		}

		// Check Database Connection
		public function isConnected() {
			return $this->dbconnected;
		}

		// Prepare Statement with query
		public function query($query) {
			$this->stmt = $this->connection->prepare($query);
		}

		// Execute Prepared Statement
		public function execute() {
			return $this->stmt->execute();
		}

		// Get Results as Array of Objects
		public function resultset() {
			$this->execute();
			return $this->stmt->fetchAll(PDO::FETCH_OBJ);
		}

		// Get Single Result as Objects
		public function single() {
			$this->execute();
			return $this->stmt->fetch(PDO::FETCH_OBJ);
		}

		// Get Row Count
		public function rowCount() {
			return $this->stmt->rowCount();
		}

		// Bind Values
		public function bind($param, $value, $type = null) {
			if (is_null ($type)) {
				switch (true) {
					case is_int ($value) :
						$type = PDO::PARAM_INT;
						break;
					case is_bool ($value) :
						$type = PDO::PARAM_BOOL;
						break;
					case is_null ($value) :
						$type = PDO::PARAM_NULL;
						break;
					default:
						$type = PDO::PARAM_STR;
						break;
				}
			}
			$this->stmt->bindValue($param, $value, $type);
		}
	}
?>