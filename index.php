<?php
function logRequest() {
    $current_time = date('Y-m-d H:i:s');
    $log_entry = "$current_time - страница была загружена\n";

    if (file_exists('log.txt')) {
        $lines = file('log.txt');
        $line_count = count($lines);

        if ($line_count >= 10) {
            $log_number = 0;
            while (file_exists("log$log_number.txt")) {
                $log_number++;
            }

            rename('log.txt', "log$log_number.txt");

            file_put_contents('log.txt', $log_entry);
        } else {
            file_put_contents('log.txt', $log_entry, FILE_APPEND);
        }
    } else {
        file_put_contents('log.txt', $log_entry);
    }
}

logRequest();

$image_dir = 'src/assets/img/';
$thumbnail_dir = 'src/assets/img/thumbnails/';

if (!file_exists($thumbnail_dir)) {
    mkdir($thumbnail_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error_message = "Ошибка загрузки файла: " . $file['error'];
    } else {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowed_types)) {
            $error_message = "Недопустимый тип файла. Разрешены только: JPEG, PNG, GIF.";
        } else {
            $max_size = 5 * 1024 * 1024; // 5 МБ
            if ($file['size'] > $max_size) {
                $error_message = "Размер файла превышает допустимый (5 МБ).";
            } else {
                $filename = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                $filepath = $image_dir . $filename;
                $thumbnail_path = $thumbnail_dir . $filename;

                if (move_uploaded_file($file['tmp_name'], $filepath)) {
                    $source_image = null;
                    $image_type = null;
                    $extension = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));

                    if ($extension == 'jpg' || $extension == 'jpeg' || $file['type'] == 'image/jpeg') {
                        $source_image = imagecreatefromjpeg($filepath);
                        $image_type = 'jpeg';
                    } elseif ($extension == 'png' || $file['type'] == 'image/png') {
                        $source_image = imagecreatefrompng($filepath);
                        $image_type = 'png';
                    } elseif ($extension == 'gif' || $file['type'] == 'image/gif') {
                        $source_image = imagecreatefromgif($filepath);
                        $image_type = 'gif';
                    }

                    if ($source_image) {
                        $width = imagesx($source_image);
                        $height = imagesy($source_image);

                        $thumbnail_width = 200;
                        $thumbnail_height = floor($height * ($thumbnail_width / $width));

                        $thumbnail = imagecreatetruecolor($thumbnail_width, $thumbnail_height);

                        if ($image_type == 'png') {
                            imagealphablending($thumbnail, false);
                            imagesavealpha($thumbnail, true);
                            $transparent = imagecolorallocatealpha($thumbnail, 255, 255, 255, 127);
                            imagefilledrectangle($thumbnail, 0, 0, $thumbnail_width, $thumbnail_height, $transparent);
                        }

                        imagecopyresampled(
                            $thumbnail, $source_image,
                            0, 0, 0, 0,
                            $thumbnail_width, $thumbnail_height,
                            $width, $height
                        );

                        switch ($image_type) {
                            case 'jpeg':
                                imagejpeg($thumbnail, $thumbnail_path, 90);
                                break;
                            case 'png':
                                imagepng($thumbnail, $thumbnail_path);
                                break;
                            case 'gif':
                                imagegif($thumbnail, $thumbnail_path);
                                break;
                        }

                        imagedestroy($source_image);
                        imagedestroy($thumbnail);

                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit;
                    } else {
                        $error_message = "Не удалось обработать изображение.";
                    }
                } else {
                    $error_message = "Не удалось сохранить загруженный файл.";
                }
            }
        }
    }
}

function buildGallery($directory, $thumbnail_directory) {
    $gallery_html = '<div class="gallery">';

    if (is_dir($directory)) {
        $files = scandir($directory);

        foreach ($files as $file) {
            $file_path = $directory . $file;
            if ($file === '.' || $file === '..' || is_dir($file_path) || $file === 'thumbnails') {
                continue;
            }

            $image_info = @getimagesize($file_path);
            if ($image_info === false) {
                continue;
            }

            $thumbnail_path = $thumbnail_directory . $file;
            if (!file_exists($thumbnail_path)) {
                $thumbnail_path = $file_path;
            }

            $gallery_html .= '<div class="gallery-item">';
            $gallery_html .= '<a href="' . htmlspecialchars($file_path) . '" target="_blank">';
            $gallery_html .= '<img src="' . htmlspecialchars($thumbnail_path) . '" alt="' . htmlspecialchars($file) . '">';
            $gallery_html .= '</a>';
            $gallery_html .= '</div>';
        }
    }

    $gallery_html .= '</div>';
    return $gallery_html;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фотогалерея</title>
    <link rel="stylesheet" href="/src/assets/styles/style.css">
</head>
<body>
    <h1>Фотогалерея</h1>

    <?php if (isset($error_message)): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <div class="upload-form">
        <h2>Загрузить новое изображение</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Выберите изображение:</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif" required>
            </div>
            <div class="form-group">
                <button type="submit">Загрузить</button>
            </div>
            <div>Максимальный размер: 5 МБ.</div>
            <div>Разрешенные форматы: JPEG, PNG, GIF.</div>
        </form>
    </div>

    <?php echo buildGallery($image_dir, $thumbnail_dir); ?>
</body>
</html>