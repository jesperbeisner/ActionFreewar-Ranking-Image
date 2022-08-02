<?php

declare(strict_types=1);

$requestUri = $_SERVER['REQUEST_URI'];

const FILE = __DIR__ . '/../images/afsrv-ranking.png';

if ($requestUri !== '/images/afsrv-ranking.png') {
    echo 'Hallo :)';
} else {
    if (file_exists(__DIR__ . '/../images/afsrv-ranking.png')) {
        if (time() - filemtime(FILE) < 300) {
            header("Content-type: image/png");
            header('Content-Length: ' . filesize(__DIR__ . '/../images/afsrv-ranking.png'));
            readfile(__DIR__ . '/../images/afsrv-ranking.png');
            exit(0);
        }
    }

    $playerDump = file_get_contents('https://afsrv.freewar.de/freewar/dump_players.php');
    $playerDump = trim($playerDump);

    $playerDump = explode("\n", $playerDump);
    $playerStats = [];
    foreach ($playerDump as $player) {
        $playerStats[] = explode("\t", $player);
    }

    usort($playerStats, function($a, $b) {
        return (int) $a[2] + (int) $a[5] <=> (int) $b[2] + (int) $b[5];
    });

    $players = array_reverse($playerStats);

    $image = imagecreate(640, 945);

    $backgroundColor = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $backgroundColor);

    $text = "Top 35 ActionFreewar Ranking                      " . date('H:i:s d.m.Y', time() + 60 * 60 * 2);
    $textColor = imagecolorallocate($image, 0, 0, 0);
    imagestring($image, 5, 10, 5, $text, $textColor);

    imagettftext($image, 14, 0, 10, 55, $textColor, __DIR__ . '/../font/Roboto-Light.ttf', '#');
    imagettftext($image, 14, 0, 54, 55, $textColor, __DIR__ . '/../font/Roboto-Light.ttf', 'Name');
    imagettftext($image, 14, 0, 300, 55, $textColor, __DIR__ . '/../font/Roboto-Light.ttf', 'XP');
    imagettftext($image, 14, 0, 425, 55, $textColor, __DIR__ . '/../font/Roboto-Light.ttf', 'Soul-XP');
    imagettftext($image, 14, 0, 550, 55, $textColor, __DIR__ . '/../font/Roboto-Light.ttf', 'Total-XP');

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
        imagettftext($image, 14, 0,10, $y, $textColor, __DIR__ . '/../font/Roboto-Light.ttf', $text);
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

        imagettftext($image, 14, 0,300, $y, $textColor, __DIR__ . '/../font/Roboto-Light.ttf', $playerXp);
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

        imagettftext($image, 14, 0,425, $y, $textColor, __DIR__ . '/../font/Roboto-Light.ttf', $playerSoulXp);
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
        imagettftext($image, 14, 0,550, $y, $textColor, __DIR__ . '/../font/Roboto-Light.ttf', $text);
        $i++;
        $y += 25;
        $playerCount++;

        if ($playerCount === 35) {
            break;
        }
    }

    imagepng($image, __DIR__ . '/../images/afsrv-ranking.png');

    header("Content-type: image/png");
    header('Content-Length: ' . filesize(__DIR__ . '/../images/afsrv-ranking.png'));
    readfile(__DIR__ . '/../images/afsrv-ranking.png');

    exit(0);
}
