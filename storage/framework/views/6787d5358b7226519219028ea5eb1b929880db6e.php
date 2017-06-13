<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.course.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo e($items->total()); ?> records
    <ul>
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                [<?php echo e($item->id); ?>]
                <?php echo e($item->name); ?>

                <b><?php echo e($item->status); ?></b>
                <b><?php echo e($item->created_at); ?></b>
                <a href="<?php echo e(route('courses.show',['course'=>$item->id])); ?>">
                    详细信息
                </a>
                <a href="<?php echo e(route('courses.edit',['course'=>$item->id])); ?>">
                    编辑基本信息
                </a>
                <a href="<?php echo e(route('courses.lessons.edit',['course'=>$item->id])); ?>">
                    选课
                </a>
                <a href="<?php echo e(route('courses.tags.edit',['course'=>$item->id])); ?>">
                    标签
                </a>
                <a href="<?php echo e(route('courses.comments.index',['course'=>$item->id])); ?>">
                    评论
                </a>
                <a href="<?php echo e(route('courses.favorite',['course'=>$item->id])); ?>">
                    收藏
                </a>
                <a href="<?php echo e(route('courses.enroll',['course'=>$item->id])); ?>">
                    加入
                </a>
                <form action="<?php echo e(route('courses.destroy',['id'=>$item->id])); ?>" method="post" style="display: inline">
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