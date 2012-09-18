<?php


require(SERVER_ROOT.'/sections/torrents/functions.php');

include(SERVER_ROOT.'/classes/class_text.php'); // Text formatting class
$Text = new TEXT;

$GroupAllowed = array('WikiBody', 'WikiImage', 'ID', 'Name', 'Year', 'RecordLabel', 'CatalogueNumber', 'ReleaseType', 'CategoryID', 'Time', 'VanityHouse');
$TorrentAllowed = array('ID', 'Media', 'Format', 'Encoding', 'Remastered', 'RemasterYear', 'RemasterTitle', 'RemasterRecordLabel', 'RemasterCatalogueNumber', 'Scene', 'HasLog', 'HasCue', 'LogScore', 'FileCount', 'Size', 'Seeders', 'Leechers', 'Snatched', 'FreeTorrent', 'Time', 'Description', 'FileList', 'FilePath', 'UserID', 'Username');

$GroupID = (int)$_GET['id'];

if ($GroupID == 0) { error('bad id parameter', true); }

$TorrentCache = get_group_info($GroupID, true, 0);

// http://stackoverflow.com/questions/4260086/php-how-to-use-array-filter-to-filter-array-keys
function filter_by_key($input, $keys) { return array_intersect_key($input, array_flip($keys)); }

$TorrentDetails = filter_by_key($TorrentCache[0][0], $GroupAllowed);

$ArtistForm = get_artist($GroupID);
if($TorrentDetails['CategoryID'] == 0) {
	$CategoryName = "Unknown";
} else {
	$CategoryName = $Categories[$TorrentDetails['CategoryID'] - 1];
}
$JsonMusicInfo = array();
if ($CategoryName == "Music") {
	$JsonMusicInfo = array(
		'composers' => $ArtistForm[4] == null ? array() : pullmediainfo($ArtistForm[4]),
		'dj' => $ArtistForm[6] == null ? array() : pullmediainfo($ArtistForm[6]),
		'artists' => $ArtistForm[1] == null ? array() : pullmediainfo($ArtistForm[1]),
		'with' => $ArtistForm[2] == null ? array() : pullmediainfo($ArtistForm[2]),
		'conductor' => $ArtistForm[5] == null ? array() : pullmediainfo($ArtistForm[5]),
		'remixedBy' => $ArtistForm[3] == null ? array() : pullmediainfo($ArtistForm[3]),
		'producer' => $ArtistForm[7] == null ? array() : pullmediainfo($ArtistForm[7])
	);
}
else {
	$JsonMusicInfo = NULL;
}

$JsonTorrentDetails = array(
	'wikiBody' => $Text->full_format($TorrentDetails['WikiBody']),
	'wikiImage' => $TorrentDetails['WikiImage'],
	'id' => (int) $TorrentDetails['ID'],
	'name' => $TorrentDetails['Name'],
	'year' => (int) $TorrentDetails['Year'],
	'recordLabel' => $TorrentDetails['RecordLabel'],
	'catalogueNumber' => $TorrentDetails['CatalogueNumber'],
	'releaseType' => (int) $TorrentDetails['ReleaseType'],
	'categoryId' => (int) $TorrentDetails['CategoryID'],
	'categoryName' => $CategoryName,
	'time' => $TorrentDetails['Time'],
	'vanityHouse' => $TorrentDetails['VanityHouse'] == 1,
	'musicInfo' => $JsonMusicInfo
);
$TorrentList = array();
foreach ($TorrentCache[1] as $Torrent) {
	$TorrentList[] = filter_by_key($Torrent, $TorrentAllowed);
}
$JsonTorrentList = array();
foreach ($TorrentList as $Torrent) {
	$JsonTorrentList[] = array(
		'id' => (int) $Torrent['ID'],
		'media' => $Torrent['Media'],
		'format' => $Torrent['Format'],
		'encoding' => $Torrent['Encoding'],
		'remastered' => $Torrent['Remastered'] == 1,
		'remasterYear' => (int) $Torrent['RemasterYear'],
		'remasterTitle' => $Torrent['RemasterTitle'],
		'remasterRecordLabel' => $Torrent['RemasterRecordLabel'],
		'remasterCatalogueNumber' => $Torrent['RemasterCatalogueNumber'],
		'scene' => $Torrent['Scene'] == 1,
		'hasLog' => $Torrent['HasLog'] == 1,
		'hasCue' => $Torrent['HasCue'] == 1,
		'logScore' => (int) $Torrent['LogScore'],
		'fileCount' => (int) $Torrent['FileCount'],
		'size' => (int) $Torrent['Size'],
		'seeders' => (int) $Torrent['Seeders'],
		'leechers' => (int) $Torrent['Leechers'],
		'snatched' => (int) $Torrent['Snatched'],
		'freeTorrent' => $Torrent['FreeTorrent'] == 1,
		'time' => $Torrent['Time'],
		'description' => $Torrent['Description'],
		'fileList' => $Torrent['FileList'],
		'filePath' => $Torrent['FilePath'],
		'userId' => (int) $Torrent['UserID'],
		'username' => $Torrent['Username']
	);
}

print json_encode(array('status' => 'success', 'response' => array('group' => $JsonTorrentDetails, 'torrents' => $JsonTorrentList)));
