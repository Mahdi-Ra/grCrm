 <?php $__env->startSection('content'); ?>

<!--calender js [nextloop]-->
<script src="/public/js/calendar/calendar.js?v=<?php echo e(config('system.versioning')); ?>"></script>

<!-- main content -->
<div class="container-fluid">

    <!-- page content -->
    <div class="row">
        <div class="col-12" id="calendar-container">
            <?php echo $__env->make('pages.calendar.calendar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>

    <!--a void space for dynamic rendering-->
    <div id="calendar-dynamic-render"></div>

</div>
<!--main content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\application\resources\views/pages/calendar/wrapper.blade.php ENDPATH**/ ?>