<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.video.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(route('videos.store')); ?>" method="post" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

        
        <input type="file" name="video">
        <button class="btn" type="submit">上传</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>