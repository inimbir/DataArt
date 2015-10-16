<?php 
if( isset( $_GET['uploadfile'] ) ){
	header('Content-type: text/html; charset=utf-8');
	$varID = $_POST['id'];
    $error = false;
    $files = array();
	$cyr  = array('а','б','в','г','д','e','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у', 
	'ф','х','ц','ч','ш','щ','ъ','ь','ы','э', 'ю','я','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У',
	'Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь','Ы','Э', 'Ю','Я' );
	$lat = array( 'a','b','v','g','d','e','e','zh','z','i','y','k','l','m','n','o','p','r','s','t','u',
	'f' ,'h' ,'ts' ,'ch','sh' ,'sht' ,'a' ,'y' ,'y','e','yu' ,'ya','A','B','V','G','D','E','E','Zh',
	'Z','I','Y','K','L','M','N','O','P','R','S','T','U',
	'F' ,'H' ,'Ts' ,'Ch','Sh' ,'Sht' ,'A' ,'Y' ,'Y','E','Yu' ,'Ya' );
	$_FILES[0]['name']=str_replace($cyr, $lat, $_FILES[0]['name']);
 
    $uploaddir = 'photos/' . $varID . '/';
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname= "restaurantmanagerbd";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->query("SET CHARACTER SET 'utf8';");
	$conn->query("INSERT INTO photos (idR, filename)
				VALUES ({$varID}, '" . $_FILES[0]['name'] . "')");
	$conn->close();
    if(!is_dir( $uploaddir )) mkdir( $uploaddir, 0777);
    foreach( $_FILES as $file ){
        if( move_uploaded_file( $file['tmp_name'], $uploaddir . basename($file['name']) ) ){
            $files[] = realpath( $uploaddir . $file['name'] );
			echo $varID;
        }
        else{
            $error = true;
        }
    }

}
?>
