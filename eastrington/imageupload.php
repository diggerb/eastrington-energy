<?php
require_once 'core/init.php';

$user = new user();

if(!$user->hasPermission('admin')){
	redirect::to(404);
	die();
} else {


// INSERT PAGE VALIDATION HERE
// CHECK IF SESSIONED ALPHA IS EQUAL TO UPLOADER ID OF ARTICLE


	if(!session::exists('alpha')){
		echo 'Something went wrong.';
		die();
	} else {
		if(session::get('imagenum') == article::imgurl(session::get('article'), session::get('alpha'), true)){
			if(db::getInstance()->update('articles', array('showing' => 1), array('alpha', '=', session::get('alpha')))){
				redirect::to('article.php?alpha=' . session::get('alpha'));
			} else{
				echo 'oh dear';
			}
		} else {
			if(session::get('i') == 0){
				session::put('i', 1);
				?>

<!DOCTYPE html>
<html>
<head>
	<title>Eastrington Energy</title>
	
	<meta name="description" content=""><!-- put the page description in here-->
	<meta name="keywords" content=""><!-- put the keywords in here-->
	<meta name="author" content="James Briant">
	<meta charset="iso-8859-1">
	<!-- <meta http-equiv="refresh" content="300"> -->
	
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	
</head>
<body>

<div><h2>DO NOT CLICK BACK.</h2> You can edit everything later if you need.</div><br>

<form action="imageupload.php" method="post" enctype="multipart/form-data">
	<fieldset>
		<legend>Main Image Upload</legend>
		
		<p>This is the image that will be the preview to the article. For example it will be the background image on the home page.</p>
	
		<input type="file" name="image">
		<br/><br/>
		<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
		<?php echo session::get('alpha'); ?>
		<input type="submit" value="Submit">
		
	</fieldset>
</form>

</body>
</html>

				<?php
			}elseif(session::get('i') == 1){
				session::put('i', 2);
				$image = image::construct($_FILES, session::get('imagenum'), session::get('alpha'), 'articles');
				if($image->moveimg()){
					if(!$image->upload()){
						echo '<br>error 2';
						echo '<br>';

						foreach($image->errors() as $error){
							echo $error;
							echo '<br>';
						}
					} else {
						redirect::to('imageupload.php');
					}
				} else {
					echo 'error 1';
					echo '<br>';

					foreach($image->errors() as $error){
						echo $error;
						echo '<br>';
					}
				}
			}elseif(session::get('i') == 2){
				session::put('i', 3);
				?>


<!DOCTYPE html>
<html>
<head>
	<title>Eastrington Energy</title>
	
	<meta name="description" content=""><!-- put the page description in here-->
	<meta name="keywords" content=""><!-- put the keywords in here-->
	<meta name="author" content="James Briant">
	<meta charset="iso-8859-1">
	<!-- <meta http-equiv="refresh" content="300"> -->
	
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	
	<script src="js/jcrop/jquery.min.js"></script>
	<script src="js/jcrop/jquery.Jcrop.min.js"></script>
	<link rel="stylesheet" href="css/jcrop/jquery.Jcrop.css" type="text/css" />
	
<script>
 
//JCrop Bits
  $(function(){
	  
    $('#jcrop_target').Jcrop({
      aspectRatio: 16 / 9,
      onSelect: updateCoords
    });

  });

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function checkCoords(){
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  }; 
//End JCrop Bits

</script>
	
</head>
<body>

<div><h2>DO NOT CLICK BACK.</h2> You can edit everything later if you need.</div><br>

<div id="CroppingContainer" style="width:800px; max-height:600px; background-color:#FFF; position:relative; overflow:hidden; border:2px #666 solid; margin:50px auto; z-index:2001; padding-bottom:0px;">  
    
        <div id="CroppingArea" style="width:500px; max-height:400px; position:relative; overflow:hidden; margin:40px 0px 40px 40px; border:2px #666 solid; float:left;">	
            <img src="<?php echo image::get('articles', session::get('alpha'), true); ?>" border="0" id="jcrop_target" style="border:0px #990000 solid; position:relative; margin:0px 0px 0px 0px; padding:0px; " />
        </div>  
        <div id="InfoArea" style="width:180px; height:300px; position:relative; overflow:hidden; margin:40px 0px 0px 40px; border:0px #666 solid; float:left;">	
           <p style="margin:0px; padding:0px; color:#444; font-size:18px;">          
                <b>Crop Image</b><br /><br />
                <span style="font-size:14px;">
                    Use this tool to crop / resize your image. <br /><br />
                    Once you are happy with the image then please click crop image below. <br /><br />
					The image is locked to a 16/9 aspect ratio!
                </span>
           </p>
        </div>  
        <br />
            <div id="CropImageForm" style="width:100px; height:30px; float:left; margin:10px 0px 0px 40px;" >  
                <form action="imageupload.php" method="post" onsubmit="return checkCoords();">
                    <input type="hidden" id="x" name="x" />
                    <input type="hidden" id="y" name="y" />
                    <input type="hidden" id="w" name="w" />
                    <input type="hidden" id="h" name="h" />
                    <input type="submit" value="Crop Image" style="width:100px; height:30px;"   />
                </form>
            </div>     
    </div>

</body>
</html>


				<?php
				
			} elseif(session::get('i') == 3){
				$x = input::get('x');
				$y = input::get('y');
				$w = input::get('w');
				$h = input::get('h');

				$ratio = '16/9';

				$image = image::construct($x, $y, $w, $h, $ratio);

				if($image->crop()){
					session::put('i', 0);
					session::put('imagenum', session::get('imagenum') + 1);
					redirect::to('imageupload.php');
				} else{
					echo 'oh no';
				}
			}
		}
	}
}