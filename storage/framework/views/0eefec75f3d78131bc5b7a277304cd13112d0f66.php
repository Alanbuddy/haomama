<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="format-detection", content: "telephone=no">
    <meta name="format-detection", content: "email=no">

    <title>
        <?php echo $__env->yieldContent('title'); ?> VOD
    </title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/mobile-notification.css">
    <link rel="stylesheet" href="/css/layout.css">
   
    <?php echo $__env->yieldContent('css'); ?>
</head>
<body>
<div>
    <?php echo $__env->yieldContent('header'); ?>
</div>
<div class="wrapper">
    <?php echo $__env->yieldContent('content'); ?>
   <!--  <div class="row">
        <ul class="nav navbar-nav navbar-right"> -->
            <!-- Authentication Links -->

           
                
                
                 --}}

           
                
                
                        
                    
                

                
                
                    
                        
                    
                

                
                    
                        
                        
                    
                
            
        
    
    
</div>
<div>
    <?php echo $__env->yieldContent('foot-div'); ?>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src = "/js/ajax.js"></script>
<script src = "/js/regex.js"></script>
<script src = "/js/mobile-notification.js"></script>
<script src = "/js/layout.js"></script>

<?php echo $__env->yieldContent('script'); ?>
</body>
</html>
