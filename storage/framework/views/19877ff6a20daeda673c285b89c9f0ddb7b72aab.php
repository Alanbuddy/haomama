<?php $__env->startSection('title'); ?>
首页
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container" id="33">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Welcome!</div>
        <div class="panel-body">Your Application's Landing Page.</div>
      </div>
    </div>
  </div>
</div>
<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div><?php echo htmlspecialchars($item->name,ENT_QUOTES,'UTF-8'); ?></div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>