<?php

$path = '';
$dir  = __DIR__;
if (isset($_GET['path']) && strlen($_GET['path'])) {
    $dir  = $_GET['path'];
    $path = $dir . '/';
}

$items = scandir($dir);
$rows  = ['folders' => [], 'files' => []];
$base  = 'http://' . $_SERVER['HTTP_HOST'];
$self  = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?path=';

if (isset($_GET['path']) && strlen($_GET['path'])) {
    $url  = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $last = substr($dir, strrpos($dir, '/'));
    $back = substr(urldecode($url), 0, - strlen($last));
}

if (is_array($items) && count($items)) {
    foreach ($items as $item) {
        if ($item != '.' && $item != '..') {
            if (is_dir($dir . '/' . $item)) {
                $rows['folders'][] = $item;
            } else {
                $rows['files'][] = $item;
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Directory</title>

        <style>

            span {
                position: absolute;
                left: 0;
                font-size: 12px;
                text-align: center;
                width: calc(100% - 20px);
                font-family: monospace;
                padding: 0 10px;
                overflow: hidden;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .file,
            .folder {
                font-size: 23px;
                transition: 0.2s all ease-in-out;
                position: relative;
            }

            .folder {
                display: inline-block;
                margin: 23px;
                background-color: transparent;
                overflow: hidden;
                color: #215785;
                line-height: 75px;
            }

            .folder:before {
                content: "";
                float: left;
                background-color: #7ba1ad;
                width: 64px;
                height: 0.45em;
                margin-left: 0.07em;
                margin-bottom: -0.07em;
                border-top-left-radius: 0.1em;
                border-top-right-radius: 0.1em;
                box-shadow: 1.25em 0.25em 0 0em #7ba1ad;
            }

            .folder:after {
                content: "";
                float: left;
                clear: left;
                background-color: #a0d4e4;
                width: 100px;
                height: 75px;
                border-radius: 0.1em;
            }

            .folder:hover {
                font-weight: bold;
            }

            .folder.open:before {
                height: 0.55em;
            }

            .folder.open:after {
                box-shadow: 0 -0.12em 0 0 #ffffff;
            }

            .folder.back::before {
                background: #2195b9;
                box-shadow: 1.25em 0.25em 0 0em #2195b9;
            }

            .folder.back::after {
                background: #2195b9;
            }

            .folder.back span {
                color: #fff;
                font-size: 24px;
            }

            .folder span {
                top: 9px;
            }

            .file {
                width: 70px;
                height: 85px;
                line-height: 85px;
                text-align: center;
                border-radius: 0.25em;
                color: #fff;
                display: inline-block;
                margin: 23px 38px;
                position: relative;
                overflow: hidden;
                box-shadow: 1.9em -2.7em 0 0 #228be6 inset
            }

            .file:after {
                content: "";
                position: absolute;
                z-index: -1;
                border-width: 0;
                border-bottom: 2.6em solid #1864ab;
                border-right: 2.22em solid rgba(0, 0, 0, 0);
                top: -34.5px;
                right: -4px;
            }

            .file:hover {
                font-weight: bold;
            }

        </style>
    </head>
    <body>
        <div class="container">

            <?php if (isset($_GET['path']) && strlen($_GET['path'])) { ?>
                <a href="<?php echo $back; ?>" class="folder open back" title="Back">
                    <span>&#8617;</span>
                </a>
            <?php } ?>

            <?php foreach ($rows['folders'] as $folder) { ?>
                <a class="folder open" title="<?php echo $folder; ?>" href="<?php echo $self . $path . $folder; ?>">
                    <span><?php echo $folder; ?></span>
                </a>
            <?php } ?>

            <?php foreach ($rows['files'] as $file) { ?>
                <a class="file" title="<?php echo $file; ?>">
                    <span><?php echo $file; ?></span>
                </a>
            <?php } ?>
        </div>
    </body>
</html>