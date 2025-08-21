<?php

// Vercel Serverless Function entry point
// Change working directory to project root
chdir(dirname(__DIR__));

// Include Laravel's public index
require_once __DIR__ . '/../public/index.php';