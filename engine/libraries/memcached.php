<?php
namespace Engine\libraries;

if (! defined ( 'SECURE' ))
	exit ( 'Hello, security@networks.co.id' );

class Memcached {
	private $connect;
	private $config;

	/**
	 * Dependency injectors and Class init
	 */
	function __construct($switch = 'Master') {

		$this->config = new \Config\Memcached(); 

		# Get Function
		$server = 'Register'.$switch;

		if (!method_exists($this->config,$server)) {
			throw new \Exception('Config Function Error at /Config/Memcached->'.$server);
		}

		$config = $this->config->$server();
		$memcached = new \Memcache ();
		$memcached->connect ( $config['host'], $config['port'] );
		$this->connect = $memcached;
	}
	
	/**
	 * basic add function
	 * @param string $key
	 * @param array $value
	 * @param int $ttl
	 * @author rama@networks.co.id
	 * @tutorial wiki/missing.txt
	 */
	public function add($key, $value, $ttl = 60) {
		$this->connect->add ( $key, $value, $ttl );
		return true;
	}
	
	/**
	 * basic get function
	 * @param string $key
	 * @author rama@networks.co.id
	 * @tutorial wiki/missing.txt
	 */
	public function get($key) {
		return $this->connect->get ( $key );
	}

	/**
	 * basic flush function
	 * @author rama@networks.co.id
	 * @tutorial wiki/missing.txt
	 */
	public function flush(){
		return $this->connect->flush();
	}
}

?>