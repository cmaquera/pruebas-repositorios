<?php
function miniAPIPost($foto){
  //$url ="https://gateway-a.watsonplatform.net/visual-recognition/api/v3/detect_faces?api_key=f28a7547bdfcfc8b210492aa578218f6ed2039c6&version=2016-05-17";
  
  $url ="https://gateway-a.watsonplatform.net/visual-recognition/api/v3/classify?api_key=f28a7547bdfcfc8b210492aa578218f6ed2039c6&version=2016-05-20";
  
  
  
  $tmpfile = $foto['tmp_name'];
  $filename = basename($foto['name']);
  $parametros ="parametros.json";
  
  $data = array(
	'images_file' => '@'.$tmpfile.';filename='.$filename,
	'classifier_ids' => '["Personas_2036167924", "default", "face_detection", "detect_faces"]',
  ); 
            
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
  $result = curl_exec($ch);
  curl_close($ch); 
  
  return json_decode($result, true);
}



?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP Starter Application</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
if( isset($_POST["submit"]) ){
    $asd = miniAPIPost($_FILES["foto"]);
    $resultado = $asd;
?>


<!--
<div><b>Edad:</b> <?php echo $resultado['age']["min"]; ?>-<?php echo $resultado['age']["max"]; ?> (score: <?php echo $resultado['age']["score"]; ?>)</div>
<div><b>Genero:</b> <?php echo $resultado['gender']["gender"]; ?> (score: <?php echo $resultado['gender']["score"]; ?>)</div>
<div><b>Identidad:</b> <?php echo $resultado['identity']["name"]; ?> (score: <?php echo $resultado['identity']["score"]; ?>)</div>
-->

<div class="center"><b>Tu eres  =></b> <?php echo $resultado ?></div>



<!--<div class="center"><b>Tu eres  =></b> <?php echo $resultado["classes"][1]["class"] ?></div>-->
<!--<div class="center"><b>Tu eres  =></b> <code> <?php print_r ($resultado) ?> </code> </div>-->

<?php }else{ ?>



<?php } ?>

<div class="center">
	<img id="uploadPreview" style="width: 50%; height: 50%;" />
</div>

<form class="center" action="" method="post" enctype="multipart/form-data">
    <input id="uploadImage" type="file" name="foto" onchange="PreviewImage();" />
    
    <button type="submit" name="submit">Enviar</button>
</form>


<script type="text/javascript">

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

</script>



</body>
</html>