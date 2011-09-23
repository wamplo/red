<?php
namespace Engine\libraries;

if (! defined ( 'SECURE' ))
    exit ( 'Hello, security@networks.co.id' );

    
class Assets
{
	public $config;

	function __construct()
	{
		$config = new \Config\Engine;
		$this->config = $config->register();
	}

	/**
	 * place a string for class css in views
	 * @author rama@networks.co.id
	 * @tutorial wiki/missing.txt
	 */
	public function ActiveCSS() {
		$url = $_SERVER ["REQUEST_URI"];
		$url = htmlspecialchars ( $url );
		$class = str_replace ( '/', '-', $url );
		$class = substr ( $class, 1 );
		
		$vowels = array ("@", "?" );
		$pieces['request'] = str_replace ( $vowels, "", $class );
		if (empty($pieces['request'])) {
			$pieces['request'] = 'home';
		}
		
		$pieces['version'] = 'v1';
		$activecss = implode (' ', $pieces );
		echo $activecss;
	}


	/**
	 * Returns the path to assets
	 * @param array $files
	 * @author rama@networks.co.id
	 */	
	function getPath($app, $src){

		# DEVELOPMENT FOLDER
		if ($this->config['development']) {
			return '/apps' . DS . $app . DS . 'assets' . DS . $src;
		}

		# PRODUCTION BUILD FOLDER
		if (!$this->config['development']) {
			return '/www-static' . DS . $app . DS . 'assets' . DS . $src;
		}
	}

	public function getView( $app, $file, $data = NULL ){

		ob_start(array ($this, 'compressor' ));

		# DEVELOPMENT FOLDER
		if ($this->config['development']) {
			include strtolower('apps' . DS . $app . DS . 'views' . DS . $file);
		}

		if (!$this->config['development']) {
			include strtolower('www-static' . DS . $app . DS . 'views' . DS . $file);
		}

		$html = ob_get_clean();

		# NOT REALLY GOOD? munkin return aja cukup cuma agak berantakan karena
		# banyak komentarnya
		return $this->compressor($html);
	}

	/**
	 * echos a <img> from the folders
	 * @param string $path
	 * @param array $options
	 * @author rama@networks.co.id
	 */
	public function getIMG($app, $src, $options = NULL) {

		$app = strtolower($app);
		var_dump($app);
		if (! file_exists ( 'apps' . DS . $app . DS . 'assets' . DS . $src )) {
			throw new \Exception ( "No such img as $path" );
		}

		$data = getimagesize( 'apps' . DS . $app . DS . 'assets' . DS . $src );
		
		echo '<img height="'.$data['1'].'px" width="'.$data['0'].'px" ' . $options . ' src="/' . 'apps' . DS . $app . DS . 'assets' . DS . $src . '" />';
	}

	/**
	 * echos a <a> for href or linking
	 * @param string $link
	 * @param string $language
	 * @author rama@networks.co.id
	 * @tutorial wiki/missing.txt
	 */
	public function href($link, $language) {
		echo "<a title='$language' href='$link'>$language</a>";
	}

	public function compressor($buffer) {
		$search = array ('/<!--(.|\s)*?-->/' ); //strip html comments
		# another search
		
		$replace = array ('');
		# another replace

		$buffer = preg_replace ( $search, $replace, $buffer );
		$buffer = trim ( $buffer );
		# https://github.com/tylerhall/html-compressor/blob/master/html-compressor.php#L138
		$buffer = str_replace ( ">\n<", '><', $buffer );
		# gak bisa dipake karena blm full to p
		#$buffer = preg_replace('/\s\s+/', ' ', $buffer);
		return $buffer;
	}
}

?>