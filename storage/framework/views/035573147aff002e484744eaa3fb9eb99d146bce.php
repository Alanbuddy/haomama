<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.video.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(route('videos.update',$item->id)); ?>" method="post">
        <?php echo e(csrf_field()); ?>

        <?php echo e(method_field('PUT')); ?>

        <input type="hidden" name="type" value="compound">
        <p>file name</p>
        <input type="text" name="name" value="<?php echo e($item->file_name); ?>">
        <button class="btn" type="submit">保存</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>