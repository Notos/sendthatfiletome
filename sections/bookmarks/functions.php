<?

function can_bookmark($Type) {
	return in_array($Type, array('torrent', 'artist', 'collage', 'request'));
}

// Recommended usage:
// list($Table, $Col) = bookmark_schema('torrent');
function bookmark_schema($Type) {
	switch ($Type) {
		case 'torrent':
			return array('bookmarks_torrents', 'GroupID');
			break;
		case 'artist':
			return array('bookmarks_artists', 'ArtistID');
			break;
		case 'collage':
			return array('bookmarks_collages', 'CollageID');
			break;
		case 'request':
			return array('bookmarks_requests', 'RequestID');
			break;			
		default:
			die('HAX');
	}
}

function has_bookmarked($Type, $ID) {
	return in_array($ID, all_bookmarks($Type));
}

function all_bookmarks($Type, $UserID = false) {
	global $DB, $Cache, $LoggedUser;
	if ($UserID === false) { $UserID = $LoggedUser['ID']; }
	$CacheKey = 'bookmarks_'.$Type.'_'.$UserID;
	if(($Bookmarks = $Cache->get_value($CacheKey)) === FALSE) {
		list($Table, $Col) = bookmark_schema($Type);
		$DB->query("SELECT $Col FROM $Table WHERE UserID = '$UserID'");
		$Bookmarks = $DB->collect($Col);
		$Cache->cache_value($CacheKey, $Bookmarks, 0);
	}
	return $Bookmarks;
}


/// -------------- Functions by TomBombadil

   function pt($table) {
     echo "<table border=1>";
     $rn = 1;
     foreach($table as $index=>$row) {
       echo "<tr>";
       echo "<td>".$rn++."</td>";
       foreach($row as $field=>$value) {
         echo "<td>" . $value . "</td>";
       }
       echo "</tr>";
     }
     echo "</table>";
   }

?>
