<!DOCTYPE html>
<!--
Template Name:  SmartAdmin Responsive WebApp - Template build with Twitter Bootstrap 4
Version: 4.5.1
Author: Sunnyat A.
Website: http://gootbootstrap.com
Purchase: https://wrapbootstrap.com/theme/smartadmin-responsive-webapp-WB0573SK0?ref=myorange
License: You must have a valid license purchased only from wrapbootstrap.com (link above) in order to legally use this theme for your project.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        <?php echo $__env->yieldContent('title'); ?> - SmartAdmin v4.5.1
    </title>
    <meta name="description" content="Login">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link rel="stylesheet" media="screen, print" href="<?php echo e(URL::asset('css/vendors.bundle.css')); ?>">
    <link rel="stylesheet" media="screen, print" href="<?php echo e(URL::asset('css/app.bundle.css')); ?>">
    <!-- Place favicon.ico in the root directory -->
    <link rel="stylesheet" media="screen, print" href="<?php echo e(URL::asset('css/vendors.bundle.css')); ?>">
    <link rel="stylesheet" media="screen, print" href="<?php echo e(URL::asset('css/app.bundle.css')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(URL::asset('/img/favicon/apple-touch-icon.png')); ?>">
    <link id="mytheme" rel="stylesheet" media="screen, print" href="<?php echo e(URL::asset('css/themes/cust-theme-4.css')); ?>">
    <?php echo $__env->yieldContent('headerStyle'); ?>
</head>

<body>
    <?php echo $__env->yieldContent('content'); ?>
    <!-- color-profile -->
    <?php echo $__env->make('layouts/partials/color-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="<?php echo e(URL::asset('js/vendors.bundle.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/app.bundle.js')); ?>"></script>
    <?php echo $__env->yieldContent('footerScript'); ?>
</body>

</html>
<?php /**PATH /var/www/Portal_laravel/resources/views/layouts/app.blade.php ENDPATH**/ ?>