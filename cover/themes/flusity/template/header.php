<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $site_title;?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <meta name="GENERATOR" content="flusity" />
    <meta name="AUTHOR" content="jd flusity" /> 
    <meta name="description" content="<?= isset($meta['description']) ? $meta['description'] : '' ?>">
    <meta name="keywords" content="<?= isset($meta['keywords']) ? $meta['keywords'] : '' ?>">
    <meta http-equiv="Content-Security-Policy: script-src 'self' 'unsafe-inline' https://ssl.gstatic.com 'unsafe-eval'">
    <link rel="icon" href="/uploads/<?php echo $site_brand_icone;?>" type="image/x-icon" />
    <link rel="shortcut icon" href="/uploads/<?php echo $site_brand_icone;?>" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="/assets/bootstrap-5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="/assets/dist/js/jquery-3.6.0.min.js"></script>
    <link href="/assets/fonts/fonts-quicksand.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo getThemePath($db, $prefix, 'css/style.css'); ?>">
    <link rel="stylesheet" type="text/css"  href="<?php echo getThemePath($db, $prefix, 'css/site.css'); ?>">
    
   <style>
    .navbar-shrink {
        height: 80px;
        transition: height 0.5s ease;
    }
  </style>
</head>
<body>
