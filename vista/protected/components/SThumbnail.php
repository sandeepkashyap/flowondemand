<?php 
class SThumbnail extends CComponent {


    const JPG = 0;
    
    const GIF = 1;
    
    const PNG = 2;

    
    private $_image;
    
    private $_thumbnail;
    
    private $_thumbnailWidth;
    
    private $_thumbnailHeight;
    
    private $_thumbnailDir;
    
    private $_imageWidth;
    
    private $_imageHeight;
    
    private $_imageDir;
    
    private $_imageType;
    
    private $_imageBaseName;
    
    private $_imageFileName;
    
    private $_thumbnailBaseName;
    
    private $_thumbnailFileName;
    
    private $_thumbnailType;
    
    private $_sourceImage;
    
    private $_destinationImage;

    
    /**
     
     * Creates a thumbnail of an image
     
     * @param String $image The full path of the original image
     
     * @param String $thumbnail The full path of the thumbnail to create
     
     * @param int $thumbWidth The thumbnail width
     
     * @return boolean true if the thumbnailer was created
     
     */
     
    public function __construct($image, $thumbnail = "", $thumbWidth = 150) {
    
        //        $this->_image = $image;
        //
        //        $imageInfo = pathinfo($image);
        //
        //        $this->_imageBaseName = $imageInfo['basename'];
        //
        //        $this->_imageFileName = $imageInfo['filename'];
        //
        //        $this->_imageDir = $imageInfo['dirname'];
        //
        //        $this->_imageType = $this->getImageType(strtolower($imageInfo['extension']));
        //
        //        if (!$thumbnail) {
        //
        //            $this->_thumbnailBaseName = $this->_imageFileName."_thumb.".$this->getImageTypeText($this->_imageType);
        //
        //            $this->_thumbnailFileName = $this->_imageFileName."_thumb";
        //
        //            $this->_thumbnailDir = $this->_imageDir;
        //
        //            $this->_thumbnailType = $this->_imageType;
        //
        //        } else {
        //
        //            $thumbnailInfo = pathinfo($thumbnail);
        //
        //            $this->_thumbnailBaseName = $thumbnailInfo['basename'];
        //
        //            $this->_thumbnailFileName = $thumbnailInfo['filename'];
        //
        //            $this->_thumbnailDir = $thumbnailInfo['dirname'];
        //
        //            $this->_thumbnailType = $this->getImageType(strtolower($imageInfo['extension']));
        //
        //        }
        //
        //        $this->_thumbnailWidth = $thumbWidth;
        //
        //        switch ($this->_imageType) {
        //
        //            case 0:
        //                $this->_sourceImage = imagecreatefromjpeg($this->_imageDir."/".$this->_imageBaseName);
        //
        //                break;
        //
        //            case 1:
        //
        //                $this->_sourceImage = imagecreatefromgif($this->_imageDir."/".$this->_imageBaseName);
        //
        //                break;
        //
        //            case 2:
        //
        //                $this->_sourceImage = imagecreatefrompng($this->_imageDir."/".$this->_imageBaseName);
        //
        //                break;
        //
        //            default:
        //
        //                return false;
        //
        //                break;
        //
        //        }
        //
        //        return true;
        
    }

    
    public function createthumb() {
    
        $this->_imageWidth = imageSX($this->_sourceImage);
        
        $this->_imageHeight = imageSY($this->_sourceImage);
        
        fb('widht: '.$this->_imageWidth);
        fb('height: '.$this->_imageHeight);
        
        $this->_thumbnailHeight = $this->_imageHeight * ($this->_thumbnailWidth / $this->_imageWidth);
        
        $this->_destinationImage = ImageCreateTrueColor($this->_thumbnailWidth, $this->_thumbnailHeight);

        
        imagecopyresampled($this->_destinationImage, $this->_sourceImage, 0, 0, 0, 0, $this->_thumbnailWidth, $this->_thumbnailHeight, $this->_imageWidth, $this->_imageHeight);
        
        switch ($this->_thumbnailType) {
        
            case 0:
            
                imagejpeg($this->_destinationImage, $this->_thumbnailDir."/".$this->_thumbnailBaseName);
                
                break;
                
            case 1:
            
                imagegif($this->_destinationImage, $this->_thumbnailDir."/".$this->_thumbnailBaseName);
                
                break;
                
            case 2:
            
                imagepng($this->_destinationImage, $this->_thumbnailDir."/".$this->_thumbnailBaseName);
                
                break;
                
            default:
            
                return false;
                
                break;
                
        }
        
        imagedestroy($this->_destinationImage);
        
        imagedestroy($this->_sourceImage);
        
    }

    
    private function getImageType($type) {
    
        if (preg_match('/jpg|jpeg/', $type)) {
        
            return self::JPG;
            
        } else if (preg_match('/png/', $type)) {
        
            return self::PNG;
            
        } else if (preg_match('/gif/', $type)) {
        
            return self::GIF;
            
        }
        
    }

    
    /**
     * Resize input image
     *
     * @param string $input_file
     * @param string $dest_file
     * @param integer $max_width
     * @param integer $max_height
     * @return boolean
     */
    function scale_image($input_file, $dest_file, $max_width, $max_height, $output_type = null, $quality = 80) {
        if (!extension_loaded('gd')) {
            return false;
        } // if
        
        $open_image = SThumbnail::open_image($input_file);
        
        if (is_array($open_image)) {
            $image_type = $open_image['type'];
            $image = $open_image['resource'];
            
            $width = imagesx($image);
            $height = imagesy($image);
            
            $scale = min($max_width / $width, $max_height / $height);
            
            if ($scale < 1) {
                $new_width = floor($scale * $width);
                $new_height = floor($scale * $height);
                
                $tmp_img = imagecreatetruecolor($new_width, $new_height);
                
                $white_color = imagecolorallocate($tmp_img, 255, 255, 255);
                imagefill($tmp_img, 0, 0, $white_color);
                imagecopyresampled($tmp_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagedestroy($image);
                $image = $tmp_img;
            } // if
            
            if ($output_type === null) {
                $output_type = $image_type;
            } // if
            
            switch ($output_type) {
                case IMAGETYPE_JPEG:
                    return imagejpeg($image, $dest_file, $quality);
                case IMAGETYPE_GIF:
                    if (!function_exists('imagegif')) {
                        return false; // If GD is compiled without GIF support
                    } // if
                    return imagegif($image, $dest_file);
                case IMAGETYPE_PNG:
                    return imagepng($image, $dest_file);
            } // switch
        } // ifs
        return false;
    } // scale_image
    
	function resize_image($input_file, $dest_file, $max_size, $output_type = null, $quality = 80) {
        if (!extension_loaded('gd')) {
            return false;
        } // if
        
        $open_image = SThumbnail::open_image($input_file);
        
        if (is_array($open_image)) {
            $image_type = $open_image['type'];
            $image = $open_image['resource'];
            
            $width = imagesx($image);
            $height = imagesy($image);
            
            $scale = $max_size / ($width * $height);
            
            if ($scale < 1) {
                $new_width = floor($scale * $width);
                $new_height = floor($scale * $height);
                $tmp_img = imagecreatetruecolor($new_width, $new_height);
                
                $white_color = imagecolorallocate($tmp_img, 255, 255, 255);
                imagefill($tmp_img, 0, 0, $white_color);
                imagecopyresampled($tmp_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagedestroy($image);
                $image = $tmp_img;
            } // if 
            else {
            	return false;
            }
            
            if ($output_type === null) {
                $output_type = $image_type;
            } // if
            
            switch ($output_type) {
                case IMAGETYPE_JPEG:
                    return imagejpeg($image, $dest_file, $quality);
                case IMAGETYPE_GIF:
                    if (!function_exists('imagegif')) {
                        return false; // If GD is compiled without GIF support
                    } // if
                    return imagegif($image, $dest_file);
                case IMAGETYPE_PNG:
                    return imagepng($image, $dest_file);
            } // switch
        } // ifs
        return false;
    } // resize_image
    
    /**
     * Open image file
     *
     * This function will try to open image file
     *
     * @param string $file
     * @return resource
     */
    function open_image($file) {
        if (!extension_loaded('gd')) {
            return false;
        } // if
        
        $info = &getimagesize($file);
        if ($info) {
            switch ($info[2]) {
                case IMAGETYPE_JPEG:
                    return array('type'=>IMAGETYPE_JPEG, 'resource'=>imagecreatefromjpeg($file)); // array
                case IMAGETYPE_GIF:
                    return array('type'=>IMAGETYPE_GIF, 'resource'=>imagecreatefromgif($file)); // array
                case IMAGETYPE_PNG:
                    return array('type'=>IMAGETYPE_PNG, 'resource'=>imagecreatefrompng($file)); // array
            } // switch
        } // if
        
        return null;
    } // open_image
    
    function getImageSize($file) {
        $open_image = SThumbnail::open_image($file);
		
        if (is_array($open_image)) {
            $image_type = $open_image['type'];
            $image = $open_image['resource'];
            
            $width = imagesx($image);
            $height = imagesy($image);
            return array($width, $height);
        }
        return false;
    }

    
    /**
     * Force resize
     *
     * @param string $input_file
     * @param string $dest_file
     * @param integer $width
     * @param integer $height
     * @param mixed $output_type
     * @return null
     */
    function temp_resize_image($input_file, $dest_file, $new_width, $new_height, $output_type = null, $quality = 80) {
        if (!extension_loaded('gd')) {
            return false;
        } // if
        
        $open_image = open_image($input_file);
        
        if (is_array($open_image)) {
            $image_type = $open_image['type'];
            $image = $open_image['resource'];
            
            $width = imagesx($image);
            $height = imagesy($image);
            
            $tmp_img = imagecreatetruecolor($new_width, $new_height);
            
            $white_color = imagecolorallocate($tmp_img, 255, 255, 255);
            imagefill($tmp_img, 0, 0, $white_color);
            imagecopyresampled($tmp_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagedestroy($image);
            $image = $tmp_img;
            
            if ($output_type === null) {
                $output_type = $image_type;
            } // if
            
            switch ($output_type) {
                case IMAGETYPE_JPEG:
                    return imagejpeg($image, $dest_file, $quality);
                case IMAGETYPE_GIF:
                    return imagegif($image, $dest_file);
                case IMAGETYPE_PNG:
                    return imagepng($image, $dest_file);
            } // switch
        } // ifs
        return false;
    } // resize_image

    
    private function getImageTypeText($type) {
    
        switch ($type) {
        
            case 0:
            
                return "jpg";
                
                break;
                
            case 1:
            
                return "gif";
                
                break;
                
            case 2:
            
                return "png";
                
                break;
                
            default:
            
                return false;
                
                break;
                
        }
        
    }

    
    public function getThumbnailBaseName() {
    
        return $this->_thumbnailBaseName;
        
    }
    
}

?>
