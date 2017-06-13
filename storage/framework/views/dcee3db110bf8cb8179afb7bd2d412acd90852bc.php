<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <ul>
        <li>
            <a href="<?php echo e(route('videos.index')); ?>">Video</a>
        </li>
        <li>
            <a href="<?php echo e(route('courses.index')); ?>">Course</a>
        </li>
        <li>
            <a href="<?php echo e(route('lessons.index')); ?>">Lesson</a>
        </li>
        <li>
            <a href="<?php echo e(route('comments.index')); ?>">Comment</a>
        </li>
        <li>
            <a href="<?php echo e(route('terms.index')); ?>?type=tag">Tag</a>
        </li>
        <li>
            <a href="<?php echo e(route('terms.index')); ?>?type=category">Category</a>
        </li>
        <li>
            <a href="<?php echo e(route('orders.index')); ?>">Order</a>
        </li>
        <li>
            <a href="<?php echo e(route('users.index')); ?>">User</a>
        </li>
        <li>
            <a href="<?php echo e(route('settings.index')); ?>">Setting</a>
        </li>
        <li>
            <a href="<?php echo e(route('roles.index')); ?>">Role</a>
        </li>
        <li>
            <a href="<?php echo e(route('behaviors.index')); ?>">User Behavior</a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>