<?php //code for save_file.php (form action)
$uploadDirectory = "upload/"; //folder-ul in care se salveaza fisierul criptat
$fileName = $_FILES['fileToUpload']['name']; //numele fisierului
$tempFileName = $_FILES['fileToUpload']['tmp_name']; //copia temporara a fisierului
$error = $_FILES['fileToUpload']['error']; //ceva
$fileContentType = $_FILES['fileToUpload']['type']; //tipul fisierului
$fileSize = $_FILES['fileToUpload']['size']; //dimensiunea fisierului

if($error==UPLOAD_ERR_OK)
{
	$file = fopen($tempFileName,"r"); //deschiserea fisierului
	echo $file."<br>";
	$content = fread($file,filesize($tempFileName)); //citirea fisierului
	echo $content."<br>";
	$encryptedContent = base64_encode($content); //criptarea fisierului
	echo $encryptedContent."<br>";
	$encryptedFileSaveName = $uploadDirectory.md5($insert_id).".secret"; //salvarea unui fisier cu un nume criptat
	echo $encryptedFileSaveName."<br>";
	$encryptedFile = fopen($encryptedFileSaveName,'w'); //deschiderea noului fisier in fisier
	echo $encryptedFile."<br>";
	fwrite($encryptedFile,$encryptedContent); //srierea in fisier
	fclose($encryptedFile);
	echo $encryptedFile."<br>";
	print("Fisierul a fost criptat cu succes<br>");
}
else
{
	print("Eroare in timpul uploadarii......");
}

//if($_FILES["file"]["type"] == "image/gif")
//{
	
//}
//else
//{
	//echo '<a href="'.$encryptedFile.'" download>DOWNLOAD</a>';
//}

echo $fileContentType."<br>";
echo $fileSize."<br>";
echo $file."<br>";
echo $content."<br>";
echo $encryptedContent."<br>";
echo $encryptedFileSaveName."<br>";
echo '<a href="'.$encryptedFileSaveName.'" download>DOWNLOAD</a>';

?>