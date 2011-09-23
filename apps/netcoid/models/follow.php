<?php
namespace Apps\Netcoid\Models;

if (! defined ( 'SECURE' ))
	exit ( 'Hello, security@networks.co.id' );

class Follow extends \Engine\libraries\Database {

	public $database = 'Master';
	
	function set($data) {
		$data = $this->insert ( 'follow', $data );
		return $data;
	}

	function unfollowUID($data) {
		$status = $this->query ( 'DELETE FROM follow WHERE follow_uid = :follow_uid AND target_uid = :target_uid LIMIT 1', $data );
		return $status;
	}

	function unfollowGID($data) {
		$status = $this->query ( 'DELETE FROM follow WHERE follow_uid = :follow_uid AND target_gid = :target_gid LIMIT 1', $data );
		return $status;
	}

	function isFollowingUID($follower, $target) {
		$status = $this->fetch ( 'SELECT follow_uid FROM follow WHERE follow_uid = :follow_uid AND target_uid = :target_uid LIMIT 1', array ('follow_uid' => $follower, 'target_uid' => $target ) );
		return $status['follow_uid'];
	}

	function isFollowingGID($follower, $target) {
		$status = $this->fetch ( 'SELECT follow_uid FROM follow WHERE follow_uid = :follow_uid AND target_gid = :target_gid LIMIT 1', array ('follow_uid' => $follower, 'target_gid' => $target ) );
		return $status['follow_uid'];
	}
}

?>