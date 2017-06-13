<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.comment.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(route('comments.store')); ?>" method="post" >
        <?php echo e(csrf_field()); ?>

        <label for="name">Content</label>
        <input type="text" name="content" placeholder="content">
        <label for="name">Star</label>
        <input type="text" name="star" placeholder="star">
        <label for="name">Course ID</label>
        <input type="text" name="course_id" placeholder="course_id">
        <button class="btn" type="submit">提交</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>