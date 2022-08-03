<?php

declare(strict_types=1);

const IMAGE_FILE = __DIR__ . '/../data/afsrv-ranking.png';
const FONT_FILE = __DIR__ . '/../data/Roboto-Light.ttf';

$playerDump = file_get_contents('https://afsrv.freewar.de/freewar/dump_players.php');
$playerDump = trim($playerDump);

$playerDump = explode("\n", $playerDump);
$playerStats = [];
foreach ($playerDump as $player) {
    $playerStats[] = explode("\t", $player);
}

usort($playerStats, function ($a, $b) {
    return (int) $a[2] + (int) $a[5] <=> (int) $b[2] + (int) $b[5];
});

$players = array_reverse($playerStats);

$image = imagecreate(640, 945);

$backgroundColor = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $backgroundColor);

$text = "Top 35 ActionFreewar Ranking                      " . date('H:i:s d.m.Y', time() + 60 * 60 * 2);
$textColor = imagecolorallocate($image, 0, 0, 0);
imagestring($image, 5, 10, 5, $text, $textColor);

imagettftext($image, 14, 0, 10, 55, $textColor, FONT_FILE, '#');
imagettftext($image, 14, 0, 54, 55, $textColor, FONT_FILE, 'Name');
imagettftext($image, 14, 0, 300, 55, $textColor, FONT_FILE, 'XP');
imagettftext($image, 14, 0, 425, 55, $textColor, FONT_FILE, 'Soul-XP');
imagettftext($image, 14, 0, 550, 55, $textColor, FONT_FILE, 'Total-XP');

$playerCount = 0;
$i = 1;
$y = 85;
foreach ($players as $player) {
    $playerName = $player[1];

    if (strlen($playerName) > 20) {
        $playerName = substr($playerName, 0, 20);
    }

    if (strlen($playerName) < 20) {
        while (strlen($playerName) < 20) {
            $playerName .= ' ';
        }
    }

    $playerName .= ' ';
    $positionText = $i < 10 ? "$i.      " : "$i.    ";

    $text = $positionText . "$playerName";
    imagettftext($image, 14, 0, 10, $y, $textColor, FONT_FILE, $text);
    $i++;
    $y += 25;
    $playerCount++;

    if ($playerCount === 35) {
        break;
    }
}

$playerCount = 0;
$i = 1;
$y = 85;
foreach ($players as $player) {
    $playerXp = $player[2];
    $playerXp = number_format((float) $playerXp, 0, ',', '.');

    imagettftext($image, 14, 0, 300, $y, $textColor, FONT_FILE, $playerXp);
    $i++;
    $y += 25;
    $playerCount++;

    if ($playerCount === 35) {
        break;
    }
}

$playerCount = 0;
$i = 1;
$y = 85;
foreach ($players as $player) {
    $playerSoulXp = $player[5];
    $playerSoulXp = number_format((float) $playerSoulXp, 0, ',', '.');

    imagettftext($image, 14, 0, 425, $y, $textColor, FONT_FILE, $playerSoulXp);
    $i++;
    $y += 25;
    $playerCount++;

    if ($playerCount === 35) {
        break;
    }
}

$playerCount = 0;
$i = 1;
$y = 85;
foreach ($players as $player) {
    $playerTotalXp = (int) $player[2] + (int) $player[5];
    $playerTotalXp = number_format((float) $playerTotalXp, 0, ',', '.');

    $text = "$playerTotalXp";
    imagettftext($image, 14, 0, 550, $y, $textColor, FONT_FILE, $text);
    $i++;
    $y += 25;
    $playerCount++;

    if ($playerCount === 35) {
        break;
    }
}

imagepng($image, IMAGE_FILE);

echo 'Image created!' . PHP_EOL;

exit(0);
