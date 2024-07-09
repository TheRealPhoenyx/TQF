<?php

class Image
{






    public function crop_image($original_file_name, $cropped_file_name, $max_width = 800, $max_height = 800)
    {
      $original_image = "";
      $original_file_name = "";

        if (file_exists($original_file_name)) {
            // Get the image type
            $image_type = exif_imagetype($original_file_name);

            switch ($image_type) {
                case IMAGETYPE_JPEG:
                    $original_image = imagecreatefromjpeg($original_file_name);
                    break;
                case IMAGETYPE_GIF:
                    $original_image = imagecreatefromgif($original_file_name);
                    break;
                case IMAGETYPE_PNG:
                    $original_image = imagecreatefrompng($original_file_name);
                    break;
                default:
                    // Handle unsupported image types
                    echo "Unsupported image type.";
                    return false;
            }

            if (!$original_image) {
                echo "Failed to create image from file.";
                return false;
            }

            $original_width = imagesx($original_image);
            $original_height = imagesy($original_image);

            // Calculate aspect ratios
            $aspect_ratio = $original_width / $original_height;
            $max_aspect_ratio = $max_width / $max_height;

            if ($aspect_ratio > $max_aspect_ratio) {
                // Wider than max aspect ratio
                $new_height = $max_height;
                $new_width = $max_height * $aspect_ratio;
            } else {
                // Taller than max aspect ratio
                $new_width = $max_width;
                $new_height = $max_width / $aspect_ratio;
            }

            // Create a new empty image
            $new_image = imagecreatetruecolor($new_width, $new_height);

            // Copy and resize old image into new image
            imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

            // Crop the image to the specified dimensions
            $cropped_image = imagecreatetruecolor($max_width, $max_height);
            $crop_x = ($new_width - $max_width) / 2;
            $crop_y = ($new_height - $max_height) / 2;
            imagecopyresampled($cropped_image, $new_image, 0, 0, $crop_x, $crop_y, $max_width, $max_height, $max_width, $max_height);

            // Save the cropped image based on original image type
            switch ($image_type) {
                case IMAGETYPE_JPEG:
                    imagejpeg($cropped_image, $cropped_file_name);
                    break;
                case IMAGETYPE_GIF:
                    imagegif($cropped_image, $cropped_file_name);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($cropped_image, $cropped_file_name);
                    break;
            }

            // Free memory
            imagedestroy($original_image);
            imagedestroy($new_image);
            imagedestroy($cropped_image);

            return true;
        }

        echo "File does not exist.";
        return false;
    }
}

?>
