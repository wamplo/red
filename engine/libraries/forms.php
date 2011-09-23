<?php
namespace Engine\libraries;

if (! defined ( 'SECURE' ))
    exit ( 'Hello, security@networks.co.id' );
    
class Forms
{
	# keliatan kalo divardump coba deh di atur
	private $config;
	private $secretname	= 'badan-intelijen-netcoid';
	private $secretkey 	= 'netcoid-police';
	private $secretsep 	= '414';
	private $humantime 	= 5; // 1s load, submit 1s, type 3s

	function __construct()
	{
		//$config = new \Config\Application;
		//$this->config = $config->registerConfig();
	}

	function openForm($name, $options = array()){

		$params = '';
		foreach ( $options as $key => $value ) {
			$params .= " $key = '$value'";
		}
		echo '<form id="form-'.$name.'"'.$params.' accept-charset="utf-8" method="post" autocomplete="off" >';
	}

	function closeForm(){
		// @todo namanya diganti aja
		echo '<input type="hidden" name="'.$this->secretname.'" value="'.md5($this->secretkey.time()).$this->secretsep.time().'" />';
		echo '</form>';	
	}

	function checkHumanPost($humantime = NULL){
		if (empty($humantime)) {
			$humantime = $this->humantime;
		}
		if ($_POST) {
			$vars = explode($this->secretsep, $_POST[$this->secretname]);
			if(md5($this->secretkey.$vars[1]) != $vars[0] || time() < $vars[1] + $humantime){
				die('hello! security@networks.co.id');
			}
			if(md5($this->secretkey.$vars[1]) == $vars[0] && time() > $vars[1] + $humantime){
				return true;
			}
		}
	}

	function password($name, $label, $options = array()) {
		
		$params = '';
		foreach ( $options as $key => $value ) {
			$params .= " $key = '$value'";
		}
		
		echo '<label for="' . $name . '">' . $label . '</label><input name="' . $name . '" type="password" ' . $params . ' autocomplete="off"/>';
	}
	
	function textinput($name, $label, $options = array()) {
		
		$params = '';
		foreach ( $options as $key => $value ) {
			$params .= " $key = '$value'";
		}
		
		echo '<label for="' . $name . '">' . $label . '</label><input name="' . $name . '" type="text" ' . $params . ' />';
	}
	
	function textarea($name, $label, $options = array()) {

		if (! isset ( $options ['value'] )) {
			$options ['value'] = NULL;
		}

		$params = '';
		foreach ( $options as $key => $value ) {
			if ($key !== 'value') {
				$params .= " $key = '$value'";
			}
		}

		echo '
		<label for="' . $name . '">' . $label . '</label>
		<textarea name="' . $name . '" ' . $params . ' >' . $options ['value'] . '</textarea>';
	}
	
	function fileinput($name, $label, $options = array()) {
		
		$params = '';
		foreach ( $options as $key => $value ) {
			$params .= " $key = '$value'";
		}
		
		echo '<label for="' . $name . '">' . $label . '</label>
		<input name="' . $name . '" type="file" ' . $params . ' />';
	}
}

?>