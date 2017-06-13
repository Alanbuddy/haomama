<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    Lesson show
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('admin.lesson.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <dl>
        <?php $__currentLoopData = $item->getAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <dt>
                <?php echo e($k); ?>

            </dt>
            <dd>
                <?php echo e($v); ?>

            </dd>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </dl>

    <h2>video info</h2>
    <?php echo e($item->video->id); ?>

    <?php echo e($item->video->file_name); ?>

    <?php echo e($item->video->video_type); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>