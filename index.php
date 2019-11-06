<?php
require_once('inc/header.php');
require_once('inc/crud.php');

$posts = new Crud();

if ( isset($_POST["submit"]) ) { // if condition

  set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
  include 'PHPExcel/IOFactory.php';

  // This is the file path and onsubmit upload file to be uploaded.(.xlsx)
  $filename = $_FILES["file"]["name"];
  move_uploaded_file($_FILES["file"]["tmp_name"],  $filename);
  $inputFileName = $filename; 

  //$inputFileName = 'directfilename.xlsx'; 
  try {
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
  } catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
  }
  $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
  $arrayCount = count($allDataInSheet);  // totel count

  for($i=2;$i<=$arrayCount;$i++){
    $data['element']    = trim($allDataInSheet[$i]["A"]);
    $data['id']         = trim($allDataInSheet[$i]["B"]);
    $data['ime']        = trim($allDataInSheet[$i]["C"]);
    $data['prezime']    = trim($allDataInSheet[$i]["D"]);
    $data['poeni']      = trim($allDataInSheet[$i]["E"]);
    $data['kategorija'] = trim($allDataInSheet[$i]["F"]);
    $data['red']        = trim($allDataInSheet[$i]["G"]);
    $data['tip']        = trim($allDataInSheet[$i]["H"]);

    $rowNumber=$posts->getRowNumber();
    $existElement = $posts->postExist($data['id']);
    

    if ($rowNumber==0 || $existElement=="notExist" ) {
      $posts->addPost($data);
    } else {
    	$current = $posts->getPostById($data['id'])->poeni;
			if ($current > $data['poeni']) {
				$posts->updatePost($data);
			}
    }
  }
} // if condition

?>
<div class="row m-5">
	<div class="col-md-6">
<form  action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
  <input type="file"  name="file" id="file">
  <input class="btn btn-dark" type= "submit" name="submit" value ="Upload" >
</form>
</div>
</div>

<div class="col-md-6">
<table class="table table-striped table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Element</th>
      <th scope="col">Id</th>
      <th scope="col">Ime</th>
      <th scope="col">Prezime</th>
      <th scope="col">Poeni</th>
      <th scope="col">Kategorija</th>
      <th scope="col">Red</th>
      <th scope="col">Tip</th>
    </tr>
  </thead>
  <tbody>
  <?php
	foreach($posts->getPosts() as $post)
		{ ?>
		<tr>
      <th scope="col"><?php echo $post->element; ?></th>
      <th scope="col"><?php echo $post->id; ?></th>
      <th scope="col"><?php echo $post->ime; ?></th>
      <th scope="col"><?php echo $post->prezime; ?></th>
      <th scope="col"><?php echo $post->poeni; ?></th>
      <th scope="col"><?php echo $post->kategorija; ?></th>
      <th scope="col"><?php echo $post->red; ?></th>
      <th scope="col"><?php echo $post->tip; ?></th>
    </tr>
	<?php } ?>
  </tbody>
</table>
</div>
<?php
require_once('inc/footer.php');
?>