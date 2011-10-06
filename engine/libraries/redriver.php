<?php
namespace Engine\libraries;

if (! defined ( 'SECURE' ))
    exit ( 'Hello, security@networks.co.id' );
    
# public $loadedcss = array();
# public $loadedjs = array();

class RedRiver extends Assets
{
	public $start = FALSE;
	public $end = FALSE;
	public $ajax = FALSE;
	private $dev = FALSE;

	function start(){

		# JQUERY
		echo "\n\t" . '<script type="text/javascript" src="'.$this->getPath('default', 'js/jquery-1.6.2.js').'"></script>';

		if ($this->ajax) {
			# REDRIVER
			echo "\n\t" . '<script type="text/javascript" src="'.$this->getPath('default', 'js/redriver.js').'?_='.rand().'"></script>';	
		}
			# PJAX
			echo "\n\t" . '<script type="text/javascript" src="/engine/vendors/github/defunkt-jquery-pjax-7d9841e/jquery.pjax.js"></script>';

			echo "\n\t" . '<script type="text/javascript" src="/engine/vendors/github/defunkt-jquery-pjax-7d9841e/netcoid.pjax.js?'.rand().'"></script>';
	
	}

	function branch($params, $status = 1){

		if ($this->ajax) {
			$this->withAjax($params, $status);
		}

		if (!$this->ajax) {
			$this->noAjax($params, $status);
		}
	}

	public function withAjax($params, $status){

		# LOAD OLNY ON THE START
		if ($status == 0) {
			$this->start();
		}

		# SET DEFAULT PARAMS
		isset($params['cache']) ? $params['cache'] : $params['cache'] = 1;
		isset($params['callback']) ? $params['callback'] : $params['callback'] = '';
		isset($params['js']) ? $params['js'] : $params['js'] = '';
		isset($params['css']) ? $params['css'] : $params['css'] = '';

		# BOOTSTRAP
		$o['cache'] = $params['cache'];
		$o['js'] = $params['js'];
		$o['css'] = $params['css'];
		$o['src']['id'] = $params['src']['id'];
		$o['src']['html'] = $params['src']['html'];

		# SET PLACER
		echo "\n\t" . '<div id="'.$params['src']['id'].'"></div>';

		# BOOTSTRAPING BRANCH
		$branch = "\n\t" . '<script>$.redriver.branch({js:'.json_encode($o['js'],JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP).',css:'.json_encode($o['css'],JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP).',src:'.json_encode($o['src'],JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP).',cache:'.json_encode($o['cache']).' });</script>';

		echo $branch;
	}

	public $loadedcss = array();
	public $loadedjs  = array();

	public function noAjax($params, $status){

		# SET DEFAULT PARAMS
		isset($params['cache']) ? $params['cache'] : $params['cache'] = 1;
		isset($params['callback']) ? $params['callback'] : $params['callback'] = '';
		isset($params['js']) ? $params['js'] : $params['js'] = '';
		isset($params['css']) ? $params['css'] : $params['css'] = '';

		# LOAD ONLY OATN THE START
		if ($status == 0) {
			$this->start();
		}

		foreach ($params['css'] as $css) {

			# IS IT LOADED ?
			if (!in_array($css, $this->loadedcss)) {

				# CACHE ? 
				if ($params['cache'] == 0) {
					echo "\n\t" . '<link type="text/css" rel="stylesheet" href="'.$css.'?_='.rand().'">';
				}

				# NO CACHE ? 
				if ($params['cache'] == 1) {
					echo "\n\t" . '<link type="text/css" rel="stylesheet" href="'.$css.'">';
				}

				# PUSH TO LOADED CSS
				$this->loadedcss[] = $css;
			}
		}
		
		echo "\n\t" . '<div id="'.$params['src']['id'].'">'.$params['src']['html'].'</div>';

		#echo $params['src']['html'];
		
		# PREPARE JAVASCRIPT
		if (!empty($params['js'])) {
			foreach ($params['js'] as $jsstate) 
			{
				foreach ($jsstate as $js) {

					# IS IT LOADED ?
					if (!in_array($js, $this->loadedjs)) {

						# PUSH TO LOADED CSS
						$this->loadedjs[] = $js;
					}	
				}		
			}
		}

		# LOAD ONLY AT THE END
		if ($status == 2) {
			
			# ECHO JAVASCRIPT
			foreach ($this->loadedjs as $javascript) {
				
				# CACHE ? 
				if ($params['cache'] == 1) {
					echo '<script type="text/javascript" src="'.$javascript.'"></script>';
				}

				# NO CACHE ? 
				if ($params['cache'] == 0) {
					echo '<script type="text/javascript" src="'.$javascript.'"></script>';
				}
			}
		}
	}
}
?>