<?php

declare(strict_types=1);

namespace App\Controller;

class IndexController
{
    public const COUNTER_FILE = __DIR__ . '/../../data/counter.txt';
    public const IMAGE_FILE = __DIR__ . '/../../data/afsrv-ranking.png';
    public const PLACEHOLDER_FILE = __DIR__ . '/../../data/404-image.png';

    public function home(): never
    {
        ob_start();
        require __DIR__ . '/../view/home.html.php';
        echo ob_get_clean();

        exit(0);
    }

    public function image(): never
    {
        if (!file_exists(self::COUNTER_FILE)) {
            file_put_contents(self::COUNTER_FILE, 0);
        }

        $counter = file_get_contents(self::COUNTER_FILE);
        $counter = $counter + 1;
        file_put_contents(self::COUNTER_FILE, $counter);

        if (file_exists(self::IMAGE_FILE)) {
            header("Content-type: image/png");
            header('Content-Length: ' . filesize(self::IMAGE_FILE));
            readfile(self::IMAGE_FILE);
        } else {
            header("Content-type: image/png");
            header('Content-Length: ' . filesize(self::PLACEHOLDER_FILE));
            readfile(self::PLACEHOLDER_FILE);
        }

        exit(0);
    }

    public function counter(): never
    {
        if (!file_exists(self::COUNTER_FILE)) {
            file_put_contents(self::COUNTER_FILE, 0);
        }

        echo 'Counter: ' . file_get_contents(self::COUNTER_FILE);

        exit(0);
    }

    public function counterReset(): never
    {
        file_put_contents(self::COUNTER_FILE, 0);

        echo 'Success';

        exit(0);
    }
}
