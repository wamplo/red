
<style type="text/css">
.v{}
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

<?php  
	echo $this->getView('netcoid','users/topnav.php');
?>

<?php $data['validation']->getErrors(); ?>

<div id="rr-2-2">
	<div class="clearfix" id="red-content">

		<div class="users-left50 dq de" id="red-wmd"><?php $data['forms']->openForm('red-wmd'); ?>
			<ul>
				<li id="form-header"><h3><strong>Profile</strong> <a style="font-size:12px;margin-left:10px" class="s" href="/<?php echo $data['username']; ?>">See Profile</a></h3></li>
				<!-- INFORMATIONBOX -->

				<li class="form-child">
				<label for="information">Kotak Informasi</label>
				<div id="html-enabled" style="
				    background: #eee;
				    width: 450px;
				    padding: 5px;
				    margin: -5px 5px 0;
				    position: relative;
				    top: 11px;
				    border: 1px solid #aaa;
				    text-align: center;
				">HTML enabled</div>
				<textarea name="information" data-error="Username Anda Harus Berformat 6-20 Huruf atau Angka" class="dk" id="wmd-input" style="width: 450px; height: 250px;"><?php echo $data['data']['information']; ?></textarea>
				</li>
				<li><input type="hidden" name="information_html" id="wmd-content-html" value=""/></li>
				<li class="form-button"><input type="submit" id="button" value="Edit"></li>
			</ul>
		<?php $data['forms']->closeForm('red-wmd'); ?></div>	

		<div class="dt users-right50">
			<div id="howto-informationbox">Informasi yang anda masukan akan dimuat pada halaman depan profil anda</div>
		</div>
	</div>
</div>