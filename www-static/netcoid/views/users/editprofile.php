
<style type="text/css">
.x{}
#red-menu-dashboard {
    background: none repeat scroll 0 0 #EEEEEE;
    height: 50px;
}
.users-right50{width:480px;}
.users-left50{width:480px;}
#howto-informationbox{    
	background: none repeat scroll 0 0 #8DD7E4;
    border: 1px solid #70BFCD;
    margin: 5px;
    padding: 5px;
}
</style>
<div id="red-menu-dashboard">
<ul class="m" style="width:960px;margin:0 auto;">
	<li class="dz" style="padding-top:17.5px"><a href="/dashboard"><?php $this->getIMG('netcoid','img/icons/user_menu_groups.png') ?></a></li>
	<li class="dz" style="padding-top:17.5px;margin-left:25px"><a href="/edit/profile"><?php $this->getIMG('netcoid','img/icons/edit.png') ?></a></li>
</ul>
</div>

<?php $data['validation']->getErrors(); ?>

<div class="m" id="red-content">

	<div class="users-left50 dz dm" id="red-wmd"><?php $data['forms']->openForm('red-wmd'); ?>
		<ul>
			<li id="form-header"><h3><strong>Profile</strong> <a style="font-size:12px;margin-left:10px" class="s" href="/<?php echo $data['username']; ?>">See Profile</a></h3></li>
			<div class="m" id="wmd-button-bar"></div>
			<!-- INFORMATIONBOX -->
			<li class="form-child"><?php $data['forms']->textarea('information',l('informationbox'), 
				array( 
					'data-error' => l('register_username_error'),
					'class' => 't',
					'id' => 'wmd-input',
					'style' => 'width: 450px; height: 250px;',
					'value'	=> $data['data']['information']
				)); 
			?></li>

			<li><input type="hidden" name="information_html" id="wmd-content-html" value=""/></li>
			<li class="form-button"><input type="submit" id="button" value="Edit"></li>
		</ul>
	<?php $data['forms']->closeForm('red-wmd'); ?></div>	

	<div class="ec users-right50">
		<div id="howto-informationbox">Informasi yang anda masukan akan dimuat pada halaman depan profil anda</div>
	</div>
</div>