<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Image</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
        }
        img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>
<body>
    <?php
    // Validate the path parameter
    if (isset($_GET['path'])) {
        $path = $_GET['path'];

        // Sanitize the path to prevent security issues
        $path = filter_var($path, FILTER_SANITIZE_URL);
        if (file_exists($path)) {
            echo "<img src=\"" . htmlspecialchars($path) . "\" alt=\"Full Image\">";
        } else {
            echo "<p>Image not found.</p>";
        }
    } else {
        echo "<p>No image specified.</p>";
    }
    ?>
</body>
</html>
