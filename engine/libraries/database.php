<?php
namespace Engine\libraries;

if (! defined ( 'SECURE' ))
    exit ( 'Hello, security@networks.co.id' );
    
/**
 * DONOTEDIT, extend olny at /application/models
 * @version 100.20/3/2011
 * @package ENGINE/CORE
 * @author rama@networks.co.id
 * @tutorial wiki/missing.txt
 * @todo cacheing should be in models ?
 */
class Database {
	public $config;
	
	/**
	 * Dependency injectors and Class init
	 * final, fix ( not allowed create a construct at models )
	 */
	final function __construct() {

		if (isset ( $this->database )) {
			$database = new \Config\Database; 
			$this->config = $database->Master();
			$this->connect ();
		}
		
		if (! isset ( $this->database )) {
			throw new Exception ( "database on this model is not set" );
		}
	}
	
	/**
	 * DONOTEDIT, so that we can olny connect from here.
	 * @author rama@networks.co.id
	 * @tutorial wiki/missing.txt
	 */
	private function connect() {
		$this->start = new \PDO ( $this->config ['driver'] . ':host=' . $this->config ['host'] . ';dbname=' . $this->config ['name'], $this->config ['username'], $this->config ['password'], array (\PDO::ATTR_PERSISTENT => $this->config ['persistent'] ) );
		$this->start->setAttribute ( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );
	}
	
	/**
	 * basic insert function
	 * @param string $table
	 * @param array $data
	 * @author rama@networks.co.id
	 * @tutorial wiki/missing.txt
	 * @update http://stackoverflow.com/questions/6093655/problem-with-php-mysql-field-name-group
	 */
	public function insert($table, $data = array()) {
		$fieldnames = array_keys ( $data );
		$name = '( ' . '`' . implode('`, `', $fieldnames) . '`' . ' )';
		$value = '(:' . implode ( ', :', $fieldnames ) . ' )';
		$query = "INSERT INTO $table";
		$query .= $name . ' VALUES ' . $value;
		$insert = $this->start->prepare ( $query );
		
		return $insert->execute ( $data );
	}

	/**
	 * insert + lastid function
	 * @param string $table
	 * @param array $data
	 * @author rama@networks.co.id
	 * @tutorial wiki/missing.txt
	 */
    public function insertwithlastid($table, $data = array()){
        $fieldnames = array_keys($data);
        $name	= '( ' . implode(' ,', $fieldnames) . ' )';
        $value	= '(:' . implode(', :', $fieldnames) . ' )';
        $query 	= "INSERT INTO $table";
        $query .= $name.' VALUES '.$value;
        
        $insert = $this->start->prepare($query);
        $insert->execute($data);

        return $this->start->lastInsertId();
    }
	
	/**
	 * basic fetch function
	 * @param string $sql
	 * @param array $data
	 * @author rama@networks.co.id
	 * @tutorial wiki/missing.txt
	 */
	public function fetch($sql, $data = array()) {
		$fetch = $this->start->prepare ( $sql );
		$fetch->execute ( $data );
		
		return $fetch->fetch ( \PDO::FETCH_ASSOC );
	}
	
	/**
	 * basic query function
	 * @param string $sql
	 * @param array $data
	 * @author rama@networks.co.id
	 * @tutorial wiki/missing.txt
	 */
	public function query($sql, $data = array()) {
		$query = $this->start->prepare ( $sql );
		return $query->execute ( $data );
	}
	
	/**
	 * basic fetchAll function
	 * @param string $sql
	 * @param array $data
	 * @author rama@networks.co.id
	 * @tutorial wiki/missing.txt
	 */
	public function fetchAll($sql, $data = array()) {
		$fetch = $this->start->prepare ( $sql );
		$fetch->execute ( $data );
		
		return $fetch->fetchAll ( \PDO::FETCH_ASSOC );
	}
}
?>