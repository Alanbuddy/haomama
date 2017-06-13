<?php $__env->startSection('title'); ?>
    Lesson index
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.user_behavior.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo e($items->total()); ?> records
    <ul>
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                [<?php echo e($item->id); ?>]
                <b><?php echo e($item->type); ?></b>
                <b><?php echo e($item->data); ?></b>
                <b><?php echo e($item->time); ?></b>
                <b><?php echo e($item->created_at); ?></b>
                <a href="<?php echo e(route('behaviors.show',['user-behavior'=>$item->id])); ?>">
                    详细信息
                </a>
                <a href="<?php echo e(route('behaviors.edit',['user-behavior'=>$item->id])); ?>">
                    编辑
                </a>
                <form action="<?php echo e(route('behaviors.destroy',['id'=>$item->id])); ?>" method="post" style="display: inline">
                    <?php echo e(csrf_field()); ?>

                    <?php echo e(method_field('DELETE')); ?>

                    <button class="btn" type="submit">删除</button>
                </form>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <?php echo e($items->render()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>