<style type="text/css">
.ay{
	margin-bottom: 10px;
}
.cw {
    font-size: 11px;
}
li.cx{
	
}
</style>

<div class="clearfix" id="red-content">

		<?php 

		$i = 1;	
		echo '<div class="dq" style="width:320px">';
		foreach ($data['g'] as $value) {

			echo '<ul id="cat-'.$value['GID'].'" class="ay">';
			echo '<li class="cat-title"><h3>'.$value['name'].'</h3></li>';

			if (isset($value['children'])) {
				foreach ($value['children'] as $children) {
					echo '<li class="cx"><a data-pjax="#rr-2" href="/group?id='.$children['GID'].'" class="a">'.$children['name'].'</a></li>';

					if (isset($children['children'])) {
						foreach ($children['children'] as $children) {
							echo '<span class="cw"><a data-pjax="#rr-2" href="/group?id='.$children['GID'].'">'.$children['name'].'</a></span> ';
						}
					}
				}
			}

			echo '</ul>';

			if ($i % 3 == 0 ) {
				echo '</div><div class="dq" style="width:320px">';
			}
			$i++;
		}
		echo '</div>';
		
		?>
</div>