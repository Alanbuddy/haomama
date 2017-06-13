<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.role.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(route('roles.update',$item->id)); ?>" method="post" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

        <?php echo e(method_field('PUT')); ?>

        <label for="name">name</label>
        <input type="text" name="name" placeholder="name" value="<?php echo e($item->name); ?>">
        <label for="name">video</label>
        <input type="text" name="display_name" placeholder="display_name" value="<?php echo e($item->display_name); ?>">
        <button class="btn" type="submit">提交</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>