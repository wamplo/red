<style type="text/css">
.az{
	margin-bottom: 10px;
}
.de {
    font-size: 11px;
}
li.df{
	
}
</style>

<div class="o" id="red-content">

		<?php 

		$i = 1;	
		echo '<div class="dz" style="width:320px">';
		foreach ($data['g'] as $value) {

			echo '<ul id="cat-'.$value['GID'].'" class="az">';
			echo '<li class="cat-title"><h3>'.$value['name'].'</h3></li>';

			if (isset($value['children'])) {
				foreach ($value['children'] as $children) {
					echo '<li class="df"><a href="/group?id='.$children['GID'].'" class="di">'.$children['name'].'</a></li>';

					if (isset($children['children'])) {
						foreach ($children['children'] as $children) {
							echo '<span class="de"><a href="/group?id='.$children['GID'].'">'.$children['name'].'</a></span> ';
						}
					}
				}
			}

			echo '</ul>';

			if ($i % 3 == 0 ) {
				echo '</div><div class="dz" style="width:320px">';
			}
			$i++;
		}
		echo '</div>';
		
		?>
</div>