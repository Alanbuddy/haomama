<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.user.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(route('users.update',$item->id)); ?>" method="post" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

        <?php echo e(method_field('PUT')); ?>

        <label for="name">name</label>
        <input type="text" name="name" placeholder="name" value="<?php echo e($item->name); ?>">
        <label for="role"></label>
        <input type="text" name="roles" placeholder="role id" value="
        <?php if(count($roles)): ?>
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($role->id); ?><?php if(!$loop->last): ?>,<?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
                ">
        <button class="btn" type="submit">提交</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>