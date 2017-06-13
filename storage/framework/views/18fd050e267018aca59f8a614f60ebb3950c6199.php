<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.video.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <ul>
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                [<?php echo e($item->id); ?>]
                <?php echo e($item->file_name); ?>

                <b><?php echo e($item->video_type); ?></b>
                <b><?php echo e($item->created_at); ?></b>
                <a href="<?php echo e(route('video.cloud.info',['id'=>$item->id])); ?>">
                    云信息
                </a>
                <a href="<?php echo e(route('video.cloud.transcode',['id'=>$item->id])); ?>">
                    转码中
                </a>
                <a href="<?php echo e(route('videos.show',['id'=>$item->id])); ?>">
                    详细信息
                </a>
                <a href="<?php echo e(route('videos.edit',['video'=>$item->id])); ?>">
                    编辑
                </a>
                <form action="<?php echo e(route('videos.destroy',['id'=>$item->id])); ?>" method="post">
                    <?php echo e(csrf_field()); ?>

                    <?php echo e(method_field('DELETE')); ?>

                    <button class="btn" type="submit">删除</button>
                </form>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>