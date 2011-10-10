<style type="text/css">
.f {
    padding: 5px 0;
}
.f li{
padding-bottom: 5px;
    border-bottom: 1px solid #EEEEEE;
}
.f li:hover {background: none repeat scroll 0 0 #FFFCE7;}

.f #messages-subject {

font-size: 12px;
}

.f #messages-meta {
    font-size: 11px;
    color:#ccc;
}

</style>

<div id="red-content">

<?php #var_dump($data) ?>

<?php if (!empty($data['messages'])): ?>
	<ul class="f">
	<h2>Inbox</h2>
	<?php foreach ($data['messages'] as $message): ?>
		<a class="a" href="/messages?id=<?php echo $message['mid']; ?>"><li>
		<div id="messages-subject">
			<?php echo $message['subject']; ?>
		</div>
		<div id="messages-meta">
			<a class="u" href="/<?php echo $message['username']; ?>"><?php echo $message['name']; ?></a> <i>on</i> <?php echo $message['time_create'] ?>
		</div>
		</li></a>
	<?php endforeach ?>
	</ul>
<?php endif ?>

<?php if (!empty($data['archives'])): ?>
	<h2>Archives</h2>
	<ul class="f">
	<?php foreach ($data['archives'] as $archive): ?>
		<a class="a" href="/messages?id=<?php echo $archive['mid']; ?>"><li>
		<div id="messages-subject">
			<?php echo $archive['subject']; ?>
		</div>
		<div id="messages-meta">
			<a class="u" href="/<?php echo $archive['username']; ?>"><?php echo $archive['name']; ?></a> <i>on</i> <?php echo $archive['time_create'] ?>
		</div>
		</li></a>
	<?php endforeach ?>
	</ul>
<?php endif ?>

</div>