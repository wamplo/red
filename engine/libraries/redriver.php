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
	public $branch;


	function start(){

		echo '
	<script type="text/javascript" src="'.$this->getPath('default', 'js/jquery-1.6.2.js').'"></script>
	<script type="text/javascript" src="'.$this->getPath('default', 'js/redriver.js').'?'.rand().'"></script>';
	}

	function branch($params, $status = 1){
		if ($status == 0) {
			$this->start();
		}

		# SET DEFAULT PARAMS
		isset($params['cache']) ? $params['cache'] : $params['cache'] = 1;
		isset($params['callback']) ? $params['callback'] : $params['callback'] = '';
		isset($params['js']) ? $params['js'] : $params['js'] = '';
		isset($params['css']) ? $params['css'] : $params['css'] = '';

		$o['cache'] = $params['cache'];
		$o['js'] = $params['js'];
		$o['css'] = $params['css'];
		$o['src']['id'] = $params['src']['id'];
		$o['src']['html'] = $params['src']['html'];

		# SET PLACER
		echo '
	<div id="'.$params['src']['id'].'"></div>';

		# BOOTSTRAPING BRANCH
		$branch = '
	<script>$.redriver.branch({js:'.json_encode($o['js'],JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP).',css:'.json_encode($o['css'],JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP).',src:'.json_encode($o['src'],JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP).',cache:'.json_encode($o['cache']).' });</script>';

		# BRANCH PUSH
		$this->branch[] = $branch;

		if ($status == 2) {
			foreach ($this->branch as $branch) {
				echo $branch;
			}
		}
	}
}
?>