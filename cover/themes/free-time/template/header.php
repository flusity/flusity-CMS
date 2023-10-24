<!DOCTYPE html>
<html lang="<?php echo isset( $_SESSION['lang']) ? $_SESSION['lang'] : $lang_code; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($site_title) ? $site_title : 'Default Title'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <meta name="description" content="<?= isset($meta['description']) ? $meta['description'] : '' ?>">
    <meta name="keywords" content="<?= isset($meta['keywords']) ? $meta['keywords'] : '' ?>">
    <meta http-equiv="Content-Security-Policy: script-src 'self' https://ssl.gstatic.com">
    <meta name="GENERATOR" content="flusity" />
    <meta name="AUTHOR" content="jd flusity" /> 
    <link rel="icon" href="/uploads/<?php echo $site_brand_icone;?>" type="image/x-icon" />
    <link rel="shortcut icon" href="/uploads/<?php echo $site_brand_icone;?>" type="image/x-icon" />
    <script src="/assets/dist/js/jquery-3.6.0.min.js"></script> 
    <link rel="stylesheet" href="<?php echo getThemePath($db, $prefix, 'assets/bootstrap/css/bootstrap.min.css'); ?>"> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anaheim&amp;display=swap">
    <link rel="stylesheet" type="text/css"  href="<?php echo getThemePath($db, $prefix, 'assets/fonts/font-awesome.min.css'); ?>">
    <link rel="stylesheet" type="text/css"  href="<?php echo getThemePath($db, $prefix, 'assets/css/animate.min.css'); ?>">
    <link rel="stylesheet" type="text/css"  href="<?php echo getThemePath($db, $prefix, 'assets/css/Footer-Multi-Column-icons.css'); ?>">
    <link rel="stylesheet" type="text/css"  href="<?php echo getThemePath($db, $prefix, 'assets/css/main.css'); ?>"> 
    <link rel="stylesheet" type="text/css"  href="<?php echo getThemePath($db, $prefix, 'css/site.css'); ?>">
    <link rel="stylesheet" type="text/css"  href="<?php echo getThemePath($db, $prefix, 'css/callendar.css'); ?>">
    <?php printAllAddonsAssets('head'); ?>
    <script src="/assets/dist/js/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="/assets/dist/js/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
    .flag.<?php echo isset($settings['language']) ? $settings['language'] : 'en'; ?> {
        background-image: url('/assets/img/<?php echo isset($settings['language']) ? $settings['language'] : 'en'; ?>.png');
    }
    </style>
</head>
<body>
    