<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.role.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(route('roles.store')); ?>" method="post" >
        <?php echo e(csrf_field()); ?>

        <label for="name">name</label>
        <input type="text" name="name" placeholder="name">
        <label for="name">display_name</label>
        <input type="text" name="display_name" placeholder="display name">
        <button class="btn" type="submit">提交</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>