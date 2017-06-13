<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.user_behavior.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(route('behaviors.store')); ?>" method="post">
        <?php echo e(csrf_field()); ?>

        <label for="name">type</label>
        <input type="text" name="type" placeholder="video.drag.begin" value="video.drag.begin">
        <label for="name">data</label>
        <input type="text" name="data" placeholder={"time":2} value={"time":2,"video_id":1}>
        <button class="btn" type="submit">提交开始拖动行为</button>
    </form>
    <form action="<?php echo e(route('behaviors.store')); ?>" method="post">
        <?php echo e(csrf_field()); ?>

        <label for="name">type</label>
        <input type="text" name="type" placeholder="" value="video.drag.end">
        <label for="name">data</label>
        <input type="text" name="data" placeholder='' value={"time":23,"video_id":1}>
        <button class="btn" type="submit">提交结束拖动行为</button>
    </form>
    <form action="<?php echo e(route('behaviors.store')); ?>" method="post">
        <?php echo e(csrf_field()); ?>

        <label for="name">type</label>
        <input type="text" name="type" placeholder="" value="video.play">
        <label for="name">data</label>
        <input type="text" name="data" placeholder={"time":2} value={"video_id":1}>
        <button class="btn" type="submit">提交播放视频行为</button>
    </form>
    <form action="<?php echo e(route('behaviors.store')); ?>" method="post">
        <?php echo e(csrf_field()); ?>

        <label for="name">type</label>
        <input type="text" name="type" placeholder="" value="video.share">
        <label for="name">data</label>
        <input type="text" name="data" placeholder="" value={"video_id":1}>
        <button class="btn" type="submit">提交分享视频行为</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>