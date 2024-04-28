<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbh = new PDO('mysql:host=localhost;dbname=mandragora', 'dev', 'DarkhanBestProgrammerSuckHisDIck!!_27');

// Get post data
$flowerName = $_POST['flowerName'];
$flowerDescription = $_POST['flowerDescription'];
$plantOrigin = $_POST['plantOrigin'];
$plantCare = $_POST['plantCare'];
$scientificData = $_POST['scientificData'];

// Process main image
$mainImageFile = [
    'name'      => $_FILES['fileToUpload']['name'][0],
    'type'      => $_FILES['fileToUpload']['type'][0],
    'tmp_name'  => $_FILES['fileToUpload']['tmp_name'][0],
    'error'     => $_FILES['fileToUpload']['error'][0],
    'size'      => $_FILES['fileToUpload']['size'][0]
];

$mainImage = processImage($mainImageFile, $dbh, $mainImageFile['name']);


// Insert data into 'plants' table and get the last inserted id
$dbh->beginTransaction();
$dbh->exec("INSERT INTO plants (main_image_url, title, description, plant_origin, plant_care, scientific_data)
            VALUES ('$mainImage', '$flowerName', '$flowerDescription', '$plantOrigin', '$plantCare', '$scientificData')");
$lastId = $dbh->lastInsertId();
$dbh->commit();

// Process remaining images and insert them into 'plant_imgs'
for ($i = 0; $i < count($_FILES['fileToUpload']['name']); $i++) {
    $imageFile = [
        'name'      => $_FILES['fileToUpload']['name'][$i],
        'type'      => $_FILES['fileToUpload']['type'][$i],
        'tmp_name'  => $_FILES['fileToUpload']['tmp_name'][$i],
        'error'     => $_FILES['fileToUpload']['error'][$i],
        'size'      => $_FILES['fileToUpload']['size'][$i]
    ];

    $image = processImage($imageFile, $dbh, $imageFile['name']);
    $dbh->exec("INSERT INTO plant_imgs (plant_id, image_url) VALUES ('$lastId', '$image')");
}

$i = 1;
while (isset($_FILES['TransplantationImage'.$i])) {
    if (is_uploaded_file($_FILES['TransplantationImage'.$i]['tmp_name'])) {
        $TransplantationImageFile = [
            'name'      => $_FILES['TransplantationImage'.$i]['name'],
            'type'      => $_FILES['TransplantationImage'.$i]['type'],
            'tmp_name'  => $_FILES['TransplantationImage'.$i]['tmp_name'],
            'error'     => $_FILES['TransplantationImage'.$i]['error'],
            'size'      => $_FILES['TransplantationImage'.$i]['size']
        ];

        $TransplantationImage = processImage($TransplantationImageFile, $dbh, $TransplantationImageFile['name']);
        $TransplantationDescription = $_POST['TransplantationDescription'.$i];

        // Вставить этапы пересадки в таблицу 'transplantation_imgs'
        $stmt = $dbh->prepare("INSERT INTO transplantation_imgs (plant_id, image_url, description) VALUES (:lastId, :transplantationImage, :transplantationDescription)");
        $stmt->bindParam(':lastId', $lastId);
        $stmt->bindParam(':transplantationImage', $TransplantationImage);
        $stmt->bindParam(':transplantationDescription', $TransplantationDescription);
        $stmt->execute();
    }
    $i++;
}


function processImage($file, $dbh, $fileName) {
    // Get extension of the file
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    // Hash the file name and append the extension
    $hashedFileName = hash('sha256', $fileName . time()) . '.' . $imageFileType;

    $target_dir = "uploads/";
    $target_file = $target_dir . $hashedFileName;

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        if (is_uploaded_file($file["tmp_name"])) {
            $check = getimagesize($file["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        } else {
            echo "No file was uploaded.";
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($file["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            echo "The file ". basename($hashedFileName). " has been uploaded.";
            return $hashedFileName;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    return null;
}
?>