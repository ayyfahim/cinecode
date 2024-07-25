<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $keyFilePath = $_FILES["keyFile"]["tmp_name"];
    $validityStart = $_POST["validityStart"];
    $validityEnd = $_POST["validityEnd"];
    $oneTimeKey = isset($_POST["oneTimeKey"]) ? "True" : "False";

    // Perform key file validation
    $keyFileContent = file_get_contents($keyFilePath);

    //echo "Key File Content: $keyFileContent <br>";

    $keyFileParts = explode(":", $keyFileContent);
    //print_r($keyFileParts);

    if (count($keyFileParts) == 2) {
        list($key, $savedHash) = $keyFileParts;
		//print_r($key);
		//print_r($savedHash);
        $inputFileForHash = $_FILES["keyFile"]["name"];
        $fileInfo = pathinfo($inputFileForHash);
        $newFileName = $fileInfo["filename"] . ".ccv";
        $inputFileForHash = $newFileName;
		//print_r($inputFileForHash);
        $hashObject = hash("sha256", $key . $inputFileForHash);
		//print_r($hashObject);

        // Compare the calculated hash with the saved hash
        if ($hashObject == $savedHash) {
            $keyFileValidationText = "Key file is valid.";
			//print_r($keyFileValidationText);

            // Validate the date format and check if start date is before end date
            try {
                $startDate = DateTime::createFromFormat('d.m.Y', $validityStart);
                $endDate = DateTime::createFromFormat('d.m.Y', $validityEnd);
				//print_r($startDate);
				//print_r($endDate);
				//print_r($validityStard);
				//print_r($validityEnd);

                if ($startDate && $endDate && $startDate <= $endDate) {
                    // Continue processing
                    $outputFolder = "keys";  // Assuming 'keys' is a directory next to the PHP file

                    // Get current number of files in the output folder
                    $numFiles = count(glob($outputFolder . "/*.cck"));
					//print_r($numFiles);

                    // Create new file name with incremented number
                    $startDateFile = $startDate->format('Ymd');
                    $endDateFile = $endDate->format('Ymd');
                    //print_r($startDateFile);
					//print_r($endDateFile);
					
					// Extrahiere Teile aus dem Dateinamen
					list($name_title, $ctype, $encryptionFileName, $aspectFileName, $name_language, $framerateFileName, $soundFileName, $runtimeCreditstartFileName, $distributorFileName, $name_date) = explode("_", $fileInfo["filename"]);
					//print_r($name_title);
					//print_r($ctype);
					//print_r($name_language);
					//print_r($name_date);
					
					
					$fileName = "Key_" . sprintf("%05d", $numFiles + 1) . "_" . "{$name_title}_{$ctype}_{$name_language}_{$name_date}" . "_valid-from_" .
                        $startDate->format('Ymd') . "_to_" . $endDate->format('Ymd') . ".cck";
					//print_r($fileName);

                    $filePath = $outputFolder . "/" . $fileName;
                    $hashNumber = sprintf("%05d", $numFiles + 1);
                    $hashObject = hash("sha256", $startDate->format('Y-m-d') . $endDate->format('Y-m-d') . $oneTimeKey . $hashNumber . $savedHash);
					//print_r($hashObject);

                    $keyString = "$key:$savedHash:{$startDate->format('Y-m-d')}:{$endDate->format('Y-m-d')}:$oneTimeKey:$hashNumber:$hashObject";
					//print_r($keyString);
					//file_put_contents('debug_output.txt', $keyString . PHP_EOL, FILE_APPEND);

                    // Insert random characters every second position
                    $newKeyString = '';
                    for ($i = 0; $i < strlen($keyString); $i++) {
                        $newKeyString .= $keyString[$i];
                        if ($i % 2 == 1 && $i != strlen($keyString) - 1) {
                            $newKeyString .= substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 3);
                        }
                    }
					//print_r($newKeyString);
                    // Add 1024 random characters at the beginning
                    //$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 1024) . $newKeyString;
					// Füge 1023 zufällige Zeichen ganz vorne hinzu
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 65) . $newKeyString;

					// Füge ein weiteres zufälliges Zeichen hinzu, um insgesamt 1024 Zeichen zu erhalten
					$newKeyString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 49) . $newKeyString;

                    // Create the new file
                    file_put_contents($filePath, $newKeyString);
					//echo "File written to: $filePath";
					
					// Sende den Dateidownload-Header
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . $fileName . '"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($filePath));
					readfile($filePath);

					// Lösche die temporäre Datei nach dem Download
					//unlink($filePath);
					
					$message = "Key file saved as $fileName.";
					
					// Beende das Skript
					exit;
 
                } else {
                    $error = "Start date must be before end date.";
                }
            } catch (Exception $e) {
                $error = "Wrong validity period, must be DD.MM.YYYY.";
            }
        } else {
            $keyFileValidationText = "Key file is not valid.";
        }
    } else {
        $keyFileValidationText = "Invalid key file format.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinecode Key Generator</title>
</head>
<body>
    <h1>Cinecode Key Generator</h1>

    <?php if (isset($message)) : ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (isset($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (isset($keyFileValidationText)) : ?>
        <p><?php echo $keyFileValidationText; ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label>Select key file:</label>
        <input type="file" name="keyFile" required>
        <br>

        <label>Validity period (DD.MM.YYYY - DD.MM.YYYY):</label>
        <input type="text" name="validityStart" placeholder="Start Date" required>
        -
        <input type="text" name="validityEnd" placeholder="End Date" required>
        <br>

        <label>One-time key?</label>
        <input type="checkbox" name="oneTimeKey">
        <br>

        <button type="submit">Generate</button>
    </form>
</body>
</html>