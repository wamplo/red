<div id="red-content">

<?php #var_dump($data['messages']) ?>

<?php if (!empty($data['messages'])): ?>
	<?php foreach ($data['messages'] as $messages): ?>
		<a href="#"><li><?php echo $messages['subject']; ?></li></a>
	<?php endforeach ?>
<?php endif ?>

</div>