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

$dbh->exec("INSERT INTO plant_imgs (plant_id, image_url) VALUES ('$lastId', '$mainImage')");
// Process remaining images and insert them into 'plant_imgs'
for ($i = 1; $i < count($_FILES['fileToUpload']['name']); $i++) {
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
while (isset($_FILES['TransplantationImage'.$i]) && is_uploaded_file($_FILES['TransplantationImage'.$i]['tmp_name'])) {
    
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
        $stmt = $dbh->prepare("INSERT INTO transplantation (plant_id, image_url, description) VALUES (:lastId, :transplantationImage, :transplantationDescription)");
        $stmt->bindParam(':lastId', $lastId);
        $stmt->bindParam(':transplantationImage', $TransplantationImage);
        $stmt->bindParam(':transplantationDescription', $TransplantationDescription);
        $stmt->execute();
    $i++;
    echo $i;
}

function processImage($file, $dbh, $fileName) {
    try{
        if ($fileName === null || empty($fileName)) {
            $fileName = mt_rand() . time();
        }

        // Get extension of the file
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        // Hash the file name and append the extension
        $hashedFileName = hash('sha256', $fileName . time()) . '.' . $imageFileType;

        $target_dir = "uploads/";
        $target_file = $target_dir . $hashedFileName;
        clearstatcache();
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "File already exists.";
            return $hashedFileName;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {

            header("Location: admin.php?upload_status=Фото не загружено из-за ошибки: Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            exit;
        }

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
                echo "The file ". basename($hashedFileName). " has been uploaded.\n";
                return $hashedFileName;
        } else {
                header("Location: admin.php?upload_status=Фото не загружено из-за ошибки: Sorry, your file was not uploaded2s");
                exit;
            }
        }
       catch (Exception $e) {
    // Обработка исключения
    echo 'Caught exception: ',  $e;
    }
}

header("Location: admin.php?upload_status=Successfully uploaded image with id: $lastId");
exit;
?>
