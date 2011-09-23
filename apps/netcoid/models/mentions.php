<?php
namespace Apps\Netcoid\Models;

if (! defined ( 'SECURE' ))
	exit ( 'Hello, security@networks.co.id' );

class Mentions extends \Engine\libraries\Database {

	public $database = 'Master';
	
	function set($cid, $usernames) {

        # BUILD QUERY
        foreach ( $usernames as $username => $value ) {
            $query[] = '('. $value['uid'] .', '. $cid .', 0)';
        }

        # REAL QUERY
		$data = $this->query ( 'INSERT INTO mentions ( mention_UID, mention_CID, `read` ) VALUES ' . implode ( ',', $query ) );
		return $data;
	}

	function open($mid, $uid) {
		$status = $this->query ( "UPDATE mentions SET 
		`read` = 1 WHERE MID = :mid and mention_UID = :uid", array ('mid' => $mid, 'uid' => $uid ) );
		return $status;
	}
	
	function del($mid) {
		$status = $this->query ( "DELETE FROM mentions WHERE mid = :mid", array ('mid' => $mid ) );
		return $status;
	}
	
	function getDatafromCIDandUID($cid, $uid) {
		$data = $this->fetch ( "SELECT mention_UID, MID FROM mentions WHERE mention_CID = :cid and mention_UID = :uid", array ('cid' => $cid, 'uid' => $uid ) );
		return $data;
	}
}

?>