<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.lesson.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(route('lessons.store')); ?>" method="post" >
        <?php echo e(csrf_field()); ?>

        <label for="name">name</label>
        <input type="text" name="name" placeholder="name" value="<?php echo e(str_random(4)); ?>">
        <label for="name">video</label>
        <input type="text" name="video_id" placeholder="video id" value="1">
        <label for="name">begin</label>
        <input type="text" name="begin" placeholder="" value="<?php echo e(date('Y-m-d H:i:s', strtotime("+1 day"))); ?>">
        <label for="name">end</label>
        <input type="text" name="end" placeholder="" value="<?php echo e(date('Y-m-d H:i:s', strtotime("+1 week"))); ?>">
        <button class="btn" type="submit">提交</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>