<?php

class Image
{
    public function crop_image($original_file_name, $cropped_file_name, $max_width, $max_height)
    {
        if (file_exists($original_file_name)) {
            $original_image = imagecreatefromjpeg($original_file_name);

            $original_width = imagesx($original_image);
            $original_height = imagesy($original_image);

            // Calculate dimensions of the square crop
            $crop_size = min($original_width, $original_height);

            // Calculate coordinates for the square crop
            $crop_x = ($original_width - $crop_size) / 2;
            $crop_y = ($original_height - $crop_size) / 2;

            // Create the square crop
            $cropped_image = imagecrop($original_image, ['x' => $crop_x, 'y' => $crop_y, 'width' => $crop_size, 'height' => $crop_size]);

            // Create a new true color image at the desired dimensions
            $new_image = imagecreatetruecolor($max_width, $max_height);

            // Resample the cropped image into the new true color image
            imagecopyresampled($new_image, $cropped_image, 0, 0, 0, 0, $max_width, $max_height, $crop_size, $crop_size);

            // Save the new image as a JPEG
            imagejpeg($new_image, $cropped_file_name, 90);
        }
    }
}

?>
