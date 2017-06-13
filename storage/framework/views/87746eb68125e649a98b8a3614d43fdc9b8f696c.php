<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('admin.course.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <dl>
        <?php $__currentLoopData = $course->getAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <dt>
                <?php echo e($k); ?>

            </dt>
            <dd>
                <?php echo e($v); ?>

            </dd>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <dt>是否已加入</dt>
        <dd><?php echo e($hasEnrolled?'yes':'no'); ?> </dd>
        <dd>已加入<?php echo e($enrolledCount); ?>人</dd>
        <dt>是否已收藏</dt>
        <dd><?php echo e($hasFavorited?'yes':'no'); ?> </dd>
        <dt>课程</dt>
        <dd><?php echo e(count($lessons)); ?> </dd>
        <dt>评论</dt>
        <dd><?php echo e(count($comments)); ?> </dd>
        <dt>推荐</dt>
        <dd><?php echo e(json_encode($recommendedCourses)); ?> </dd>
    </dl>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>