<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(route('login',[],false)); ?>" method="post">
        
        <?php echo e(csrf_field()); ?>

        <input type="email" name="email" value="" placeholder="email">
        <input type="password" name="password">
        <input type="checkbox" name="remember" placeholder="checkbox">
        <button>Login</button>
    </form>
    <a href="#" id="wechat">wechat Login</a>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        var appId = "<?php echo e(config('wechat.mp.appId')); ?>";
        var node = document.getElementById('wechat');
        var app_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid="
            + appId
            + "&redirect_uri=http%3a%2f%2fhttp://baby.fumubidu.com.cn/haomama/wechat/login" +
            "&response_type=code" +
            "&scope=snsapi_userinfo&state=STATE" +
            "&connect_redirect=1#wechat_redirect";
        node.setAttribute('href', app_url);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>