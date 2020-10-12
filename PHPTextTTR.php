<?php
class PHPTextTTR
{
	/* Configs */
	private $text1 = "";
	private $text2 = "";
	private $font = "assets/fonts/abstract_slab.ttf";
	private $lowLim = 35;
	private $upLim = 50;
	private $use_frames = true;
	private $inline_img = false;
	private $tColor1 = array('r' => 0, 'g' => 0, 'b' => 0);
	private $tColor2 = array('r' => 0, 'g' => 0, 'b' => 0);
	private $bgColor = array('r' => 255, 'g' => 255, 'b' => 255);

	function __construct()
	{
		$this->font = realpath($this->font);
	}

	public function setText($t1, $t2 = "")
	{
		$this->text1 = $t1;
		$this->text2 = $t2;
	}

	public function setUseFrames($bool)
	{
		$this->use_frames = $bool;
	}

	public function setShowEmbed($bool)
	{
		$this->inline_img = $bool;
	}

	public function setColors($txc1 = "#000000", $bxg = "#ffffff")
	{
		$this->tColor1 = $this->hexToRgb($txc1);
		$this->tColor2 = $this->tColor1;
		$this->bgColor = $this->hexToRgb($bxg);
	}

	private function hexToRgb($hex)
	{
		$hex      = str_replace('#', '', $hex);
		$length   = strlen($hex);
		$rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
		$rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
		$rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
		return $rgb;
	}

	public function generateTTR($force_download = false)
	{
		if (strlen($this->text1) > 0) {
			$duo = true;
			if (strlen($this->text2) == 0) {
				$duo = false;
			}

			//Text Filter
			$fontSize = 350;

			$this->text1 = strtoupper($this->text1);
			if ($duo) {
				$this->text2 = strtoupper($this->text2);
			}


			if (strlen($this->text1) > $this->upLim) {
				$this->text1 = mb_substr($this->text1, 0, ($this->upLim) - 1);
			}
			if ($duo) {
				if (strlen($this->text2) > $this->upLim) {
					$this->text2 = mb_substr($this->text2, 0, ($this->upLim) - 1);
				}
			}

			/* Writing Text 1 */
			$w = 19999;
			$h = 500;

			//Create Base Image
			$image = imagecreatetruecolor($w, $h);
			imagealphablending($image, false);
			$bg_color = imagecolorallocatealpha($image, 255, 255, 255, 127);
			imagefill($image, 0, 0, $bg_color);
			imagesavealpha($image, true);

			//Calculate Text Dimensions And Write On Image
			$tcol = imagecolorallocate($image,  $this->tColor1['r'], $this->tColor1['g'], $this->tColor1['b']);
			$text_box = imagettfbbox($fontSize, 0, $this->font, $this->text1);
			$text_width = $text_box[2] - $text_box[0];
			$text_height = $text_box[7] - $text_box[1];
			$x = ($w / 2) - ($text_width / 2);
			$y = ($h / 2) - ($text_height / 2);
			$this->imagettftextAS($image, $fontSize, 0, $x, $y, $tcol, $this->font, $this->text1, 50);

			//Resize Child Image
			$nw = imagesx($image) / 11;
			$nh = imagesy($image) * 2.5;
			$res_img = imagecreatetruecolor($nw, $nh);
			imagealphablending($res_img, false);
			imagesavealpha($res_img, true);
			$tt = imagecolorallocatealpha($res_img, 255, 255, 255, 127);
			imagefill($res_img, 0, 0, $tt);
			imagecopyresampled($res_img, $image, 0, 0, 0, 0, $nw, $nh, $w, $h);
			imagedestroy($image);
			$image = $res_img;
			//Crop Extra Part Of Image
			$cropped = imagecropauto($image, IMG_CROP_DEFAULT);
			if ($cropped !== false) {
				imagedestroy($image);
				$image = $cropped;
			}

			if ($duo) {
				/* Writing Text 2 */
				$w = 19999;
				$h = 500;
				//Create Base Image
				$image2 = imagecreatetruecolor($w, $h);
				imagealphablending($image2, false);
				$bg_color = imagecolorallocatealpha($image2, 255, 255, 255, 127);
				imagefill($image2, 0, 0, $bg_color);
				imagesavealpha($image2, true);
				//Calculate Text Dimensions And Write On Image
				$tcol = imagecolorallocate($image2,  $this->tColor2['r'], $this->tColor2['g'], $this->tColor2['b']);
				$text_box = imagettfbbox($fontSize, 0, $this->font, $this->text2);
				$text_width = $text_box[2] - $text_box[0];
				$text_height = $text_box[7] - $text_box[1];
				$x = ($w / 2) - ($text_width / 2);
				$y = ($h / 2) - ($text_height / 2);
				$this->imagettftextAS($image2, $fontSize, 0, $x, $y, $tcol, $this->font, $this->text2, 50);
				//Resize Child Image
				$nw = imagesx($image2) / 11;
				$nh = imagesy($image2) * 2.5;
				$res_img = imagecreatetruecolor($nw, $nh);
				imagealphablending($res_img, false);
				imagesavealpha($res_img, true);
				$tt = imagecolorallocatealpha($res_img, 255, 255, 255, 127);
				imagefill($res_img, 0, 0, $tt);
				imagecopyresampled($res_img, $image2, 0, 0, 0, 0, $nw, $nh, $w, $h);
				imagedestroy($image2);
				$image2 = $res_img;
				//Crop Extra Part Of Image
				$cropped2 = imagecropauto($image2, IMG_CROP_DEFAULT);
				if ($cropped2 !== false) {
					imagedestroy($image2);
					$image2 = $cropped2;
				}
				$image2 = $this->rotate_transparent_img($image2, -90);
			}


			$w = 1000;
			$h = 1000;


			if (strlen($this->text1) <= $this->lowLim) {
				$w = 1000;
			} else {
				$w = 1400;
			}

			if ($duo) {
				if (strlen($this->text2) <= $this->lowLim) {
					$h = 1000;
				} else {
					$h = 1400;
				}
			}


			$path = "";
			if ($w == 1000 && $h == 1400) {
				$path = "assets/frames/Frame1000x1400.png";
			} else if ($w == 1400 && $h == 1000) {
				$path = "assets/frames/Frame1400x1000.png";
			} else if ($w == 1000 && $h == 1000) {
				$path = "assets/frames/Frame1000x1000.png";
			} else if ($w == 1400 && $h == 1400) {
				$path = "assets/frames/Frame1400x1400.png";
			}


			$bg_color = imagecolorallocatealpha($image,  $this->bgColor['r'], $this->bgColor['g'], $this->bgColor['b'], 0);
			$bg_image = imagecreatetruecolor($w, $h);
			imagefill($bg_image, 0, 0, $bg_color);
			imagecopy($bg_image, $image, (imagesx($bg_image) / 2) - (imagesx($image) / 2), (imagesy($bg_image) / 2) - (imagesy($image) / 2), 0, 0, imagesx($image), imagesy($image));
			if ($duo) {
				imagecopy($bg_image, $image2, (imagesx($bg_image) / 2) - (imagesx($image2) / 2), (imagesy($bg_image) / 2) - (imagesy($image2) / 2), 0, 0, imagesx($image2), imagesy($image2));
			}

			$fullImage = null;

			if ($this->use_frames) {
				$fullImage = imagecreatefrompng($path);
				imagealphablending($fullImage, false);
				imagesavealpha($fullImage, true);
				// Frame Destination X Axis and Y Axis, you can change these if you want to use your own frames 
				$frame_dest_x = 25;
				$frame_dest_y = 25;
				imagecopy($fullImage, $bg_image, $frame_dest_x, $frame_dest_y, 0, 0, imagesx($bg_image), imagesy($bg_image));
			} else {
				$fullImage = imagecreatetruecolor(imagesx($bg_image), imagesy($bg_image));
				imagecopy($fullImage, $bg_image, 0, 0, 0, 0, imagesx($bg_image), imagesy($bg_image));
			}

			imagedestroy($bg_image);
			imagedestroy($image);

			if ($duo) {
				imagedestroy($image2);
				$fname = "PHPTextTTR_" . md5($this->text1 . $this->text2 . "+" . date("Y:m:d;H:i:s")) . ".png";
			} else {
				$fname = "PHPTextTTR_" . md5($this->text1 . date("Y:m:d;H:i:s")) . ".png";
			}

			if (!$this->inline_img) {
				header('Content-type: image/png');
				if ($force_download) {
					header('Content-Disposition: Attachment; filename="' . $fname . '"');
					header('Pragma: no-cache');
					imagepng($fullImage);
					exit;
				} else {
					imagepng($fullImage);
				}
			} else {
				ob_start();
				imagepng($fullImage);
				$image_data = ob_get_contents();
				ob_end_clean();
				$image_data_base64 = "data:image/png;base64," . base64_encode($image_data);
				echo $image_data_base64;
			}
		}
	}


	private function imagettftextAS($image, $size, $angle, $x, $y, $color, $font, $text, $spacing = 0)
	{
		if ($spacing == 0) {
			imagettftext($image, $size, $angle, $x, $y, $color, $font, $text);
		} else {
			$temp_x = $x;
			for ($i = 0; $i < strlen($text); $i++) {
				$bbox = imagettftext($image, $size, $angle, $temp_x, $y, $color, $font, $text[$i]);
				$temp_x += $spacing + ($bbox[2] - $bbox[0]);
			}
		}
	}

	private function rotate_transparent_img($img_resource, $angle)
	{
		$pngTransparency = imagecolorallocatealpha($img_resource, 255, 255, 255, 127);
		imagefill($img_resource, 0, 0, $pngTransparency);
		$result = imagerotate($img_resource, $angle, $pngTransparency);
		imagealphablending($result, true);
		imagesavealpha($result, true);
		return $result;
	}
}
