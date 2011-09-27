<?php
namespace Apps\Netcoid\Models;

if (! defined ( 'SECURE' ))
	exit ( 'Hello, security@networks.co.id' );

class Groups extends \Engine\libraries\Database {

	public $database = 'Master';
	
	function setGroup($data) {
		$data = $this->insert ( 'groups', $data );
		return $data;
	}

	function getSearch(){
		$data = $this->fetchAll ( 'SELECT GID, name, parent_GID FROM groups');
		return $data;		
	}

	function getGroups( $status = 0 ) {
		$data = $this->fetchAll ( 'SELECT GID, name, description, GROUP_CONCAT(DISTINCT tag ORDER BY tag) AS tags FROM groups WHERE status = :status GROUP BY name ORDER BY `tag` ',array(
			'status' => $status ));
		return $data;
	}

	function getGidbyTag($tag){
		$return = $this->fetch('SELECT GID FROM groups WHERE tag = :tag LIMIT 1', 
		array('tag' => $tag ));
		return $return['GID'];
	}

	function getGIDbyName($name){
		$return = $this->fetch('SELECT GID FROM groups WHERE name = :name LIMIT 1', 
		array('name' => $name ));		
		return $return['GID'];		
	}

	function getGroup($gid){
		$return = $this->fetch('SELECT name, description, description_html FROM groups WHERE gid = :gid LIMIT 1', 
		array('gid' => $gid ));
		return $return;		
	}

	# status
	# 0 = category
	# 1 = groups admin post
	# 2 = groups all post ( trade + posts )
	# 3 = groups all post ( posts )
	# 4 = groups all post ( trade )
	# 5 = groups disabled
	function getStatusbyGID($gid){
		$return = $this->fetch('SELECT status FROM groups WHERE gid = :gid LIMIT 1', 
		array('gid' => $gid ));		
		return $return['status'];			
	}

	# BUKAN YANG SUDAH DIFOLLOW
	function getFollowingGroups($uid, $limit = 20) {
		$data = $this->fetchAll ( 
		"SELECT posts.PID, posts.post_GID, groups.name as groupname, posts.title, posts.status, users.name, users.username
		FROM posts
		INNER JOIN groups ON groups.GID = posts.post_GID
		INNER JOIN follow ON follow.target_GID = posts.post_GID
		INNER JOIN users ON users.UID = posts.post_UID AND users.UID != :uid
		WHERE follow.follow_UID = :uid AND users.UID NOT IN
    	(
		    SELECT follow.target_UID FROM follow
		    WHERE follow.follow_UID = :uid
    	) 
    	
    	ORDER BY posts.time_create DESC LIMIT 25", array ('uid' => $uid ) );
		return $data;
	}
}

?>