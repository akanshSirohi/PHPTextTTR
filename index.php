<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    require("./PHPTextTTR.php");
    $PHPTextTTR = new PHPTextTTR();

    // Both string cannot be more than 50 chracter length each
    // Second string is optional
    $PHPTextTTR->setText("Akansh Sirohi", "Creative Programmer");

    // Set font color and background color of image
    $PHPTextTTR->setColors("#000000", "#ffffff");

    // Use frames in image if set true
    $PHPTextTTR->setUseFrames(true);

    // if set true makes image embedable in image tags, default false
    $PHPTextTTR->setShowEmbed(true);
    ?>

    <img src="<?= $PHPTextTTR->generateTTR(false); ?>" width="600">

    <?php
    // Try to uncomment these line after setting show embed option false
    // $PHPTextTTR->generateTTR(false); // disabled force download
    // $PHPTextTTR->generateTTR(true); // enabled force download
    ?>
</body>

</html>