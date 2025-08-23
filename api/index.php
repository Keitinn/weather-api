<?php
/**
* Here is the serverless function entry
* for deployment with Vercel.
*/

// Vercel環境でのパス修正
if (isset($_SERVER['PATH_INFO'])) {
    $_SERVER['REQUEST_URI'] = '/apis' . $_SERVER['PATH_INFO'];
} elseif (isset($_SERVER['SCRIPT_URL'])) {
    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_URL'];
}

require __DIR__.'/../public/index.php';
