<?php
	session_start();
/**
 *  * 圖片特徵 Hash 計算
 *   *
 *    * @version     $Id: ImageHash.php 4429 2012-04-17 13:20:31Z jax $
 *     * @author      jax.hu
 *      *
 *       * <code>
 *        *  //Sample_1
 *         *  $hashA = ImageHash::pHash('001.jpg');
 *          *  $hashB = ImageHash::pHash('002.jpg');
 *           *  if(ImageHash::isSimilar($hashA, $hashB)){
 *            *
 *             *  }
 *              *
 *               * </code>
 *                */

/*
 *    $hashA = ImageHash::pHash('C:\Users\Public\Pictures\Sample Pictures\bNsDhwl.jpg');
 *       $hashB = ImageHash::pHash('C:\Users\Public\Pictures\Sample Pictures\1393673899987.png');
 *
 *           
 *               echo ImageHash::isSimilar($hashA, $hashB);
 *                  */

	
		require_once("db_const.php");
		$result=$mysqli->query("SELECT * FROM `standard` ");
		$hashA=ImageHash::pHash("../newupload/".$_SESSION['CompareFile']);
	//	echo'</br> compare filename'.$_SESSION['CompareFile'];
		$finalresult=0;
		while($rows=$result->fetch_array()){
			//echo $rows['id']."\n";
			$hashB=ImageHash::pHash($rows['picd']);
			$finalresult+= ImageHash::isSimilar($hashA, $hashB);
		}
	
		
	
		$returnresult =999-($finalresult);
		
		if($returnresult<=0)
			$returnresult=0;
  $sql="UPDATE `clothes`.`userpic` SET `score` = '".$returnresult."' WHERE `userpic`.
	              `filename` ='".$_SESSION['CompareFile']."'";
		$result=$mysqli->query($sql);
		echo $returnresult;
	 

class ImageHash {

	/**讀取圖片至指定大小*/
	public static function readImageTo($imagePath, $width, $height){
		if(!$imagePath || !file_exists($imagePath)){ return null; }

	if(class_exists('Imagick')){
		$image = new Imagick($imagePath);
		$image->thumbnailImage($width, $height);
		$img = imagecreatefromstring($image->getImageBlob());
		$image->destroy(); $image = null;

	}else{
		$createFunc = array(
			IMAGETYPE_GIF   =>'imageCreateFromGIF',
			IMAGETYPE_JPEG  =>'imageCreateFromJPEG',
			IMAGETYPE_PNG   =>'imageCreateFromPNG',
			IMAGETYPE_BMP   =>'imageCreateFromBMP',
			IMAGETYPE_WBMP  =>'imageCreateFromWBMP',
			IMAGETYPE_XBM   =>'imageCreateFromXBM',
		);

		$type = exif_imagetype($imagePath);
		if(!array_key_exists($type, $createFunc)){ return null; }

		$func = $createFunc[$type];
		if(!function_exists($func)){ return null; }

		$src = $func($imagePath);
		$img = imageCreateTrueColor($width, $height);
		imageCopyResized(
			$img, $src, 
			0,0,0,0, 
			$width, $height, imagesX($src),imagesY($src)
		);
		imagedestroy($src);
	}

	return $img;
	}



	/**取得灰階數值*/
	public static function getGray($img,$x,$y){
		$col = imagecolorsforindex($img, imagecolorat($img,$x,$y));
		return intval($col['red']*0.3 + $col['green']*0.59 + $col['blue']*0.11);
	}



	/**取得 DCT 常數*/
	private static $_dctConst = null;
	public static function getDctConst(){
		if(self::$_dctConst){ return self::$_dctConst;}

	self::$_dctConst = array();
	for ($dctP=0; $dctP<8; $dctP++) {
		for ($p=0;$p<32;$p++) {
			self::$_dctConst[$dctP][$p] = 
				cos( ((2*$p + 1)/64) * $dctP * pi() );
		}
	}

	return self::$_dctConst;
	}



	/**圖片檔案 aHash
	 *      * @param string $filePath 檔案位址路徑
	 *           * @return string 圖片 hash 值，失敗則是 null
	 *                * */
	public static function aHash($imagePath){
		$img = self::readImageTo($imagePath, 8, 8);
		if(!$img){ return null; }

		$graySum = 0;
		$grays = array();
		for ($y=0; $y<8; $y++){
			for ($x=0; $x<8; $x++){
				$gray = self::getGray($img,$x,$y);
				$grays[] = $gray;
				$graySum +=  $gray;
			}
		}
		imagedestroy($img);

		/*計算所有像素的灰階平均值*/
		$average = $graySum/64;

		/*計算 hash 值*/
		foreach ($grays as $i => $gray){
			$grays[$i] = ($gray>=$average) ? '1' : '0';
		}

		return join('',$grays);
	}




	/**圖片檔案 pHash
	 *      * @param string $filePath 檔案位址路徑
	 *           * @return string 圖片 hash 值，失敗則是 null
	 *                * */
	public static function pHash($imagePath){
		$img = self::readImageTo($imagePath, 32, 32);
		if(!$img){ return null; }

		/*取得灰階數值 32*32*/
		$grays = array();
		for ($y=0; $y<32; $y++){
			for ($x=0; $x<32; $x++){
				$grays[$y][$x] = self::getGray($img,$x,$y);
			}
		}
		imagedestroy($img);


		/*計算 DCT 8*8*/
		$dctConst = self::getDctConst();
		$dctSum = 0;
		$dcts = array();
		for ($dctY=0; $dctY<8; $dctY++) {
			for ($dctX=0; $dctX<8; $dctX++) {

				$sum = 1;
				for ($y=0;$y<32;$y++) {
					for ($x=0;$x<32;$x++) {
						$sum += 
							$dctConst[$dctY][$y] * 
							$dctConst[$dctX][$x] * 
							$grays[$y][$x];
					}
				}

				/*apply coefficients*/
				$sum *= .25;
				if ($dctY == 0 || $dctX == 0) {
					$sum *= 1/sqrt(2);
				}

				$dcts[] = $sum;
				$dctSum +=  $sum;
			}
		}

		/*計算所有像素的灰階平均值*/
		$average = $dctSum/64;

		/*計算 hash 值*/
		foreach ($dcts as $i => $dct){
			$dcts[$i] = ($dct>=$average) ? '1' : '0';
		}

		return join('',$dcts);
	}



	/**圖片檔案 dHash
	 *      * @param string $filePath 檔案位址路徑
	 *           * @return string 圖片 hash 值，失敗則是 null
	 *                * */
	public static function dHash($imagePath){
		$img = self::readImageTo($imagePath, 9, 8);
		if(!$img){ return null; }

		$grays = array();
		for ($y=0; $y<8; $y++){
			for ($x=0; $x<9; $x++){
				$grays[$y][$x] = $gray = self::getGray($img,$x,$y);
			}
		}
		imagedestroy($img);

		$bitStr = array();
		for ($y=0; $y<8; $y++){
			for ($x=0; $x<8; $x++){
				$bitStr[] = ($grays[$y][$x] < $grays[$y][$x+1]) ? '1' : '0';
			}
		}

		return join('',$bitStr);
	}



	/**比較兩個 hash 值，是不是相似
	 *     * @param string $aHash A圖片的 hash 值
	 *         * @param string $bHash B圖片的 hash 值
	 *             * @return bool 當圖片相似則回傳 true，否則是 false
	 *                 * */
	public static function isSimilar($hashStrA, $hashStrB){
		$aL = strlen($hashStrA); $bL = strlen($hashStrB);
		if ($aL !== $bL){ return false; }

		/*計算兩個 hash 值的漢明距離*/
		$distance = 0;
		for($i=0; $i<$aL; $i++){
			if ($hashStrA{$i} !== $hashStrB{$i}){ $distance++; }
		}

		return $distance ;
	}

}

