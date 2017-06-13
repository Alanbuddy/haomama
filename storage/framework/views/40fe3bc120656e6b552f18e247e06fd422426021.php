<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.course.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(route('courses.store')); ?>" method="post" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

        <label for="name">name</label>
        <input type="text" name="name" placeholder="name">
        <label for="name">price</label>
        <input type="text" name="price" placeholder="price 0.00">
        <label for="description">description</label>
        <textarea name="description" placeholder="description">
        </textarea>
        <label for="cover">cover</label>
        <input type="file" name="cover">
        <button class="btn" type="submit">提交</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>