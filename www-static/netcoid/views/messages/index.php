<style type="text/css">
.h {
    padding: 5px 0;
}
.h li{
padding-bottom: 5px;
    border-bottom: 1px solid #EEEEEE;
}
.h li:hover {background: none repeat scroll 0 0 #FFFCE7;}

.h #messages-subject {

font-size: 12px;
}

.h #messages-meta {
    font-size: 11px;
    color:#ccc;
}

</style>

<div id="red-content">

<?php #var_dump($data) ?>

<?php if (!empty($data['messages'])): ?>
	<ul class="h">
	<h2>Inbox</h2>
	<?php foreach ($data['messages'] as $message): ?>
		<a class="bz" href="/messages?id=<?php echo $message['mid']; ?>"><li>
		<div id="messages-subject">
			<?php echo $message['subject']; ?>
		</div>
		<div id="messages-meta">
			<a class="u" href="/<?php echo $message['username']; ?>"><?php echo $message['name']; ?></a> <i>on</i> <?php echo $message['timecreate'] ?>
		</div>
		</li></a>
	<?php endforeach ?>
	</ul>
<?php endif ?>

<?php if (!empty($data['archives'])): ?>
	<h2>Archives</h2>
	<ul class="h">
	<?php foreach ($data['archives'] as $archive): ?>
		<a class="bz" href="/messages?id=<?php echo $archive['mid']; ?>"><li>
		<div id="messages-subject">
			<?php echo $archive['subject']; ?>
		</div>
		<div id="messages-meta">
			<a class="u" href="/<?php echo $archive['username']; ?>"><?php echo $archive['name']; ?></a> <i>on</i> <?php echo $archive['timecreate'] ?>
		</div>
		</li></a>
	<?php endforeach ?>
	</ul>
<?php endif ?>

</div>