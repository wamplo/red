<?php
namespace Engine\libraries;

if (! defined ( 'SECURE' ))
	exit ( 'Hello, security@networks.co.id' );
/**
 * SESSIONS library
 * @author DAMS
 * SET
 * GET
 * DEL
 * FLUSH
 */

class Sessions {

	public function set($key, $value) {
		if (isset ( $_SESSION [$key] )) {
			return false;
		}
		
		if (! isset ( $_SESSION [$key] )) {
			$_SESSION [$key] = $value;
			return true;
		}
	}
	
	public function get($key) {
		if (! isset ( $_SESSION [$key] )) {
			return false;
		}
		
		if (isset ( $_SESSION [$key] )) {
			return $_SESSION [$key];
		}
	}
	
	public function del($key) {
		if (! isset ( $_SESSION [$key] )) {
			return false;
		}
		if (isset ( $_SESSION [$key] )) {
			unset ( $_SESSION [$key] );
			return true;
		}
	}
	
	public function flush() {
		// do we still need this?
		$_SESSION = array ();
		session_destroy ();
		$this->refresh ();
	}
	
	public function refresh() {
		session_regenerate_id ( true );
	}
	
	function __construct() {
		$dependency = new \Config\Sessions; 
		$config = $dependency->registerConfig();

		ini_set ( 'session.name', $config ['session_name'] );
		ini_set ( 'session.gc_probability', $config ['gc_probability'] );
		ini_set ( 'session.gc_divisor', $config ['gc_divisor'] );
		ini_set ( 'session.hash_function', $config ['hash_function'] );
		ini_set ( 'session.gc_maxlifetime', $config ['gc_maxlifetime'] );
		# start the engine
		session_start ();
	}
}
?>