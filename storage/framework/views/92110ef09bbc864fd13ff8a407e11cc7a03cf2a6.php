<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.setting.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(route('settings.update',$item->id)); ?>" method="post" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

        <?php echo e(method_field('PUT')); ?>

        <label for="name">key</label>
        <input type="text" name="key" placeholder="name" value="<?php echo e($item->key); ?>">
        <label for="name">value</label>
        <input type="text" name="value" placeholder="value" value="<?php echo e($item->value); ?>">
        <button class="btn" type="submit">提交</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>