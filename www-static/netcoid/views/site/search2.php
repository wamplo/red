<style type="text/css">
.ba{
	margin-bottom: 10px;
}
.db {
    font-size: 11px;
}
li.dc{
	
}
</style>

<div class="m" id="red-content">

		<?php 

		$i = 1;	
		echo '<div class="dw" style="width:320px">';
		foreach ($data['g'] as $value) {

			echo '<ul id="cat-'.$value['GID'].'" class="ba">';
			echo '<li class="cat-title"><h3>'.$value['name'].'</h3></li>';

			if (isset($value['children'])) {
				foreach ($value['children'] as $children) {
					echo '<li class="dc"><a data-pjax="#rr-2" href="/group?id='.$children['GID'].'" class="dg">'.$children['name'].'</a></li>';

					if (isset($children['children'])) {
						foreach ($children['children'] as $children) {
							echo '<span class="db"><a data-pjax="#rr-2" href="/group?id='.$children['GID'].'">'.$children['name'].'</a></span> ';
						}
					}
				}
			}

			echo '</ul>';

			if ($i % 3 == 0 ) {
				echo '</div><div class="dw" style="width:320px">';
			}
			$i++;
		}
		echo '</div>';
		
		?>
</div>