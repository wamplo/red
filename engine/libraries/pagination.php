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
class Pagination {

	public $curroffset; # current offset
 	public $maxperpage; #! max per page
	public $totalrow;	#! count total row
	public $currrow; 	#! count current row

	public function __construct(){
		$this->__getPage();
	}

	public function createHtml(){

		#var_dump($this->currrow,$this->totalrow,$this->maxperpage,$this->curroffset);

		# BACK
		if ($this->curroffset > 0) {

			$dataURL = parse_url($_SERVER['REQUEST_URI']); // $x = $dataURL['path'];
			$buildQuery = http_build_query( Array( 'offset' => $this->curroffset - 1 ) + $_GET );

			echo '<a id="arrow-link" href="'. $dataURL['path'] .'?'. $buildQuery .'" ><div id="pagination-to-back"><span class="arrow"><</span></div></a>';
		}

		# NEXT
		# @todo masih ada bug, kalo pas post pas di nextnya gak ada.
		if ($this->currrow == $this->maxperpage) {
			#var_dump($this);

			$dataURL = parse_url($_SERVER['REQUEST_URI']); // $x = $dataURL['path'];
			$buildQuery = http_build_query( Array( 'offset' => $this->curroffset + 1 ) + $_GET );

			echo '<a id="arrow-link" href="'. $dataURL['path'] .'?'. $buildQuery .'" ><div id="pagination-to-next"><span class="arrow">></span></div></a>';				
		}
	}

	public function creatHtmlInfo(){
		$pages = ceil($this->totalrow/$this->maxperpage);
		$currpage = $this->curroffset + 1;

		if ($pages > 0) {
			echo '<div style="position: relative; top: 20px; text-align: center; padding: 2px; background: none repeat scroll 0pt 0pt rgb(232, 232, 232); color: rgb(181, 181, 181);">'.$currpage.'/'.$pages.'</div>';
		}
	}
	/**
	 * createLinks
	 *
	 * @return HTML
	 * @author Adam Ramadhan
	 **/
	public function createHtml2(){
		$current = ( $this->curpage + 1 ) * $this->perpage;

		if ($current == 0) {
			$current = $this->perpage;
		}

		if ($current < $this->total ) {

			# @todo EFFICIENT FIX, we can use explode from ?, etc rather then parse url
			$this->page = $this->page + 1;
			$dataURL = parse_url($_SERVER['REQUEST_URI']); // $x = $dataURL['path'];
			$buildQuery = http_build_query( Array( 'offset' => $this->page ) + $_GET );

			echo '<a href="'. $dataURL['path'] .'?'. $buildQuery .'">Next</a>';
		}

		if ($current > $this->total ) {
			
			# @todo EFFICIENT FIX, we can use explode from ?, etc rather then parse url
			$this->page = $this->page - 1;
			$dataURL = parse_url($_SERVER['REQUEST_URI']); // $x = $dataURL['path'];
			$buildQuery = http_build_query( Array( 'offset' => $this->page ) + $_GET );

			echo '<a href="'. $dataURL['path'] .'?'. $buildQuery .'">Back</a>';
		}
	}

	/**
	 * getPage()
	 *
	 * @return current page
	 * @author Adam Ramadhan
	 **/
	private function __getPage(){
		if (!isset($_GET['offset'])) {
			$this->curroffset = 0;
		}

		if (isset($_GET['offset']) && is_numeric($_GET['offset'])) {
			$this->curroffset = $_GET['offset'];
		}
	}
}
?>