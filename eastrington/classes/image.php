<?php
class image {
	private $_name,
			$_num,
			$_tempname,
			$_imgwidth,
			$_imgheight,
			$_width,
			$_height,
			$_type,
			$_alpha,
			$_foldertarget,
			$_filetarget,
			$_newimg,
			$_imgcanvas,
			$_errors = array(),
			$_accept = array("png", "jpeg", "jpg", "gif", "pjepg"),

			$_x,
			$_y,
			$_w,
			$_h,
			$_ratio,
			$_dst,
			$_src,
			$_finalname;

	public static function get($where, $alpha, $desc = false){
		if(config::get('image/'.$where)){
			$location = config::get('image/'.$where);
			$dir = 'images/' . $location . '/' . $alpha;

			if(is_dir($dir)){
				if($desc === true){
					$list = scandir($dir, 1);
					return 'images/' . $location . '/' . $alpha . '/' . $list[0];
				} else {
					$list = scandir($dir);
					return 'images/' . $location . '/' . $alpha . '/' . $list[2];
				}
			} else {
				echo 'Directry doesn\'t exist';
				return false;
			}
		}

		return false;
	}

	public static function construct(){
		$args = func_get_args();

		if(func_num_args() == 4){
			$image = new image();
			call_user_func_array(array($image, "instance1"), $args);
			return $image;
		}

		if(func_num_args() == 5){
			$image = new image();
			call_user_func_array(array($image, "instance2"), $args);
			return $image;
		}

		return false;
	}

	public function instance1($files, $num, $alpha, $where){
		$this->_type = explode('/', $files['image']['type'])[1];
		$this->_name = $num . '_temp.' . $this->_type;
		$this->_num = $num;
		$this->_tempname = $files['image']['tmp_name'];
		$this->_alpha = $alpha;
		$this->_foldertarget = 'images/' . config::get('image/' . $where) . '/' . $this->_alpha . '/';
		$this->_filetarget = $this->_foldertarget . $this->_name;

		if(!in_array($this->_type, $this->_accept)){
			$this->adderror($this->_type . ' is not an accepted file type. Please upload a .png, .jpeg, .jpg or .gif');
			return false;
		}
	}

	public function moveimg(){
		if(!dir::exists($this->_foldertarget)){
			if(dir::create($this->_foldertarget)){
				if(move_uploaded_file($this->_tempname, $this->_filetarget) and chmod($this->_filetarget, 0777)){
					$this->_imgwidth = getimagesize($this->_filetarget)[0];
					$this->_imgheight = getimagesize($this->_filetarget)[1];

					return true;
				}
			}
		} elseif(dir::exists($this->_foldertarget)){
			if(move_uploaded_file($this->_tempname, $this->_filetarget) and chmod($this->_filetarget, 0777)){
				$this->_imgwidth = getimagesize($this->_filetarget)[0];
				$this->_imgheight = getimagesize($this->_filetarget)[1];

				return true;
			}
		}

		$this->adderror('For some reason the file wasn\'t uploaded to the correct destination.');
		return false;
	}

	public function upload(){
		if($this->_type == "png"){
			$this->_imgcanvas = imagecreatefrompng($this->_filetarget);
			$this->_name = $this->_num . '_temp2.' . $this->_type;
			$this->_filetarget = $this->_foldertarget . $this->_name;
		}elseif($this->_type == "gif"){
			$this->_imgcanvas = imagecreatefromgif($this->_filetarget);
			$this->_name = $this->_num . '_temp2.' . $this->_type;
			$this->_filetarget = $this->_foldertarget . $this->_name;
		}elseif($this->_type == "jpeg" || $this->_type == "jpg" || $this->_type == "pjpeg"){
			$this->_imgcanvas = imagecreatefromjpeg($this->_filetarget);
			$this->_name = $this->_num . '_temp2.' . $this->_type;
			$this->_filetarget = $this->_foldertarget . $this->_name;
		} else {
			$this->adderror('Something went horribly wrong. The image could not be uploaded.');
			return false;
		}

		foreach(array('_filetarget', '_type', '_num', '_foldertarget') as $item){
			session::put($item, $this->$item);
		}

		$this->_width = 500;
		$this->_height = $this->_imgheight / ($this->_imgwidth / $this->_width);

		$this->_resource = imagecreatetruecolor($this->_width, $this->_height);
		imagecopyresampled($this->_resource, $this->_imgcanvas, 0, 0, 0, 0, $this->_width, $this->_height, $this->_imgwidth, $this->_imgheight);

		if($this->_type == "png"){
			$this->_imgcanvas = imagepng($this->_resource, $this->_filetarget, 0);
			chmod($this->_filetarget, 0777);
		}elseif($this->_type == "gif"){
			$this->_imgcanvas = imagegif($this->_resource, $this->_filetarget);
			chmod($this->_filetarget, 0777);
		}elseif($this->_type == "jpeg" || $this->_type == "jpg" || $this->_type == "pjpeg"){
			$this->_imgcanvas = imagejpeg($this->_resource, $this->_filetarget, 100);
			chmod($this->_filetarget, 0777);
		} else {
			$this->adderror('Something went horribly wrong. The image could not be uploaded. 2');
			return false;
		}

		imagedestroy($this->_resource);
		@unlink($this->_foldertarget . $this->_num . '_temp.' . $this->_type);
		return true;
	}

	public function instance2($x, $y, $w, $h, $ratio){
		$this->_x = $x;
		$this->_y = $y;
		$this->_w = $w;
		$this->_h = $h;
		$this->_ratio = $ratio;
		$this->_type = session::get('_type');
		$this->_foldertarget = session::get('_foldertarget');
		$this->_filetarget = session::get('_filetarget');
		$this->_num = session::get('_num');

		$this->_finalname = $this->_foldertarget . $this->_num . '.' . $this->_type;

		if($this->_ratio == '16/9'){
			$this->_width = 500;
			$this->_height = $this->_width / 16 * 9;
		}

		if($this->_ratio == '1'){
			$this->_width = 150;
			$this->_height = $this->_width;
		}
	}

	public function crop(){
		$this->_dst = imagecreatetruecolor($this->_width, $this->_height);
		$this->_finalname = $this->_foldertarget . $this->_num . '.jpeg';

		if($this->_type == "png"){
			$this->_src = imagecreatefrompng($this->_filetarget);
			imagecopyresampled($this->_dst, $this->_src, 0, 0, $this->_x, $this->_y, $this->_width, $this->_height, $this->_w, $this->_h);
			imagejpeg($this->_dst, $this->_finalname, 100);
		} elseif($this->_type == "gif"){
			$this->_src = imagecreatefromgif($this->_filetarget);
			imagecopyresampled($this->_dst, $this->_src, 0, 0, $this->_x, $this->_y, $this->_width, $this->_height, $this->_w, $this->_h);
			imagejpeg($this->_dst, $this->_finalname, 100);
		} elseif($this->_type == "jpg" || $this->_type == "pjpeg" || $this->_type == "jpeg"){
			$this->_src = imagecreatefromjpeg($this->_filetarget);
			imagecopyresampled($this->_dst, $this->_src, 0, 0, $this->_x, $this->_y, $this->_width, $this->_height, $this->_w, $this->_h);
			imagejpeg($this->_dst, $this->_finalname, 100);
		} else{
			$this->adderror('The image could not be cropped.');
			return false;
		}

		imagedestroy($this->_src);
		@unlink($this->_filetarget);

		return true;
	}

	private function adderror($error){
		$this->_errors[] = $error;
	}

	public function errors(){
		return $this->_errors;
	}
}