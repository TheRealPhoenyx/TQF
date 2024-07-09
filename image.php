<?php

class Image
{
    private $image_path;

    public function __construct($image_path)
    {
        $this->image_path = $image_path;
    }

    public function generate_filename($length, $folder)
    {
        $array = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $text = "";
        for ($i = 0; $i < $length; $i++) {
            $text .= $array[rand(0, count($array) - 1)];
        }
        return $folder . $text . '.jpg';
    }

    public function resize($image_path, $width, $height)
    {
        list($original_width, $original_height) = getimagesize($image_path);
        $new_image = imagecreatetruecolor($width, $height);
        $image_resource = imagecreatefromjpeg($image_path);

        imagecopyresampled($new_image, $image_resource, 0, 0, 0, 0, $width, $height, $original_width, $original_height);

        imagejpeg($new_image, $image_path, 90);

        imagedestroy($new_image);
        imagedestroy($image_resource);
    }

    public function get_thumb_post($image_path)
    {
        $thumb_path = str_replace(".jpg", "_thumb.jpg", $image_path);
        $this->resize($image_path, 200, 200);
        return $thumb_path;
    }
}

?>
