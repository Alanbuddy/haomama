<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.course.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(route('courses.update',$item->id)); ?>" method="post" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

        <?php echo e(method_field('PUT')); ?>

        <label for="name">name</label>
        <input type="text" name="name" placeholder="name" value="<?php echo e($item->name); ?>">
        <label for="name">category id</label>
        <input type="text" name="category_id" placeholder="name" value="<?php echo e($item->category_id); ?>">
        <label for="name">price</label>
        <input type="text" name="price" placeholder="price 0.00" value="<?php echo e($item->price); ?>">
        <label for="name">begin</label>
        <input type="text" name="begin" placeholder="begin at" value="<?php echo e($item->begin); ?>">
        <label for="name">end</label>
        <input type="text" name="end" placeholder="end at" value="<?php echo e($item->end); ?>">
        <label for="name">teacher id</label>
        <input type="text" name="teacherId" placeholder="end at" value="<?php echo e($item->teacher_id); ?>">
        <label for="description">description</label>
        <textarea name="description" placeholder="description">
            <?php echo e($item->description); ?>

        </textarea>
        <label for="cover">cover</label>
        <img src="<?php echo e($item->cover); ?>">
        <input type="file" name="cover">
        <button class="btn" type="submit">提交</button>
    </form>
    <hr>
    category : <?php echo e($item->category->name); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>