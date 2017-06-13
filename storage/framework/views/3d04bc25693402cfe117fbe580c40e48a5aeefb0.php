<?php $__env->startSection('css'); ?>
    <script src="/js/Sortable.js"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.video.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(route('videos.update',$item->id)); ?>" method="post">
        <?php echo e(csrf_field()); ?>

        <?php echo e(method_field('PUT')); ?>

        <input type="hidden" name="type" value="compound">
        <p>file name</p>
        <input type="text" name="name" value="<?php echo e($item->file_name); ?>">
        <button class="btn" type="submit">保存</button>
    </form>
    <form action="<?php echo e(route('videos.update',$item->id)); ?>" method="post" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

        <?php echo e(method_field('PUT')); ?>

        <input type="hidden" name="type" value="compound">
        <p>picture</p>
        <div id="pic">
            <?php $__currentLoopData = $pictures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(strpos($i->mime,'image')===0): ?>
                    <img data-id="<?php echo e($i->id); ?>" data-no="<?php echo e($i->no); ?>"
                         class="sort" src="<?php echo e($i->path); ?>" style="width:200px ;height: 140px;"
                         title="<?php echo e($i->file_name); ?>">
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <input type="file" name="picture">
        <button class="btn" type="submit">上传</button>
    </form>
    <form action="<?php echo e(route('videos.update',$item->id)); ?>" method="post" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

        <?php echo e(method_field('PUT')); ?>

        <input type="hidden" name="type" value="compound">
        <p>audio</p>
        <?php if(!empty($audio)): ?>
            <audio src="<?php echo e($audio->path); ?>" controls></audio>
        <?php endif; ?>
        <input type="file" name="audio">
        <button class="btn" type="submit">上传</button>
    </form>
    <form action="<?php echo e(route('videos.update',$item->id)); ?>" method="post" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

        <?php echo e(method_field('PUT')); ?>

        <input type="hidden" name="type" value="compound">
        <p>title timeline(CSV)</p>
        <textarea cols="200"><?php echo e($item->caption); ?></textarea><br>
        <input type="file" name="timeline">
        <button class="btn" type="submit">上传</button>
    </form>
    <script>
        var container = document.getElementById("pic");
        var updateUrl="<?php echo e(route('video.attachment.order',$item->id)); ?>";
        var sort = Sortable.create(container, {
            animation: 150, // ms, animation speed moving items when sorting, `0` — without animation
//            handle: ".handle", // Restricts sort start click/touch to the specified element
            draggable: ".sort", // Specifies which items inside the element should be sortable
            onUpdate: function (evt/**Event*/) {
                console.log(evt);
                var item = evt.item; // the current dragged HTMLElement
                update();
            }
        });
        function update() {
            var $pictures = $('#pic').children('img');
            $pictures.each(function (k, v) {
                $(this).attr('data-no', k);
                console.log($(this).data('id'));
                console.log(k);
                console.log(v);
            });
            var data = [];
            $pictures.each(function (k, v) {
                data.push({
                    id: $(v).data('id'),
                    no: $(v).data('no'),
                })
            });
            $.ajax({
                url: updateUrl,
                type: 'get',
                data: {
                    data:data,
                },
                success: function (response) {
                    console.log(response);
                }
            })
        }
        //        sort.destroy();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>