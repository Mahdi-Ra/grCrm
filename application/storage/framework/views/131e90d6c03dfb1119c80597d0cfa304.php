<div class="calendar_wrapper" id="calendar_wrapper">

    <!--calendar dynamically loaded here-->

</div>
<?php echo $__env->make('pages.calendar.components.misc.settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<!--set the data payload-->
<script>
    //general data from backend
    NX.calendar_data = <?php echo json_encode($data, 15, 512) ?>;

    //events payload
    NX.calendar_events = <?php echo json_encode($events, 15, 512) ?>;

    //general var
    NX.calendar_add_url = "<?php echo e(url('/calendar/create')); ?>";
    NX.calendar_action_url = "<?php echo e(url('/calendar')); ?>";
    NX.calendar_start_day = "<?php echo e(config('system.settings2_calendar_first_day') ?? 1); ?>";

    //language
    NXLANG.calender_settings = "<?php echo app('translator')->get('lang.calendar_settings'); ?>";
    NXLANG.calender_add_event = "<?php echo app('translator')->get('lang.add_event'); ?>";

    NXLANG.calender_lang = {
        code: 'nextloop',
        buttonText: {
            today: "<?php echo app('translator')->get('lang.today'); ?>",
            month: "<?php echo app('translator')->get('lang.month'); ?>",
            week: "<?php echo app('translator')->get('lang.week'); ?>",
            day: "<?php echo app('translator')->get('lang.day'); ?>",
            list: "<?php echo app('translator')->get('lang.list'); ?>"
        },
        weekText: 'W',
        allDayText: "<?php echo app('translator')->get('lang.all_day'); ?>",
        moreLinkText: "<?php echo app('translator')->get('lang.more'); ?>",
        noEventsText: "<?php echo app('translator')->get('lang.no_events_to_display'); ?>",
        dayNames: [
            "<?php echo app('translator')->get('lang.sunday'); ?>",
            "<?php echo app('translator')->get('lang.monday'); ?>",
            "<?php echo app('translator')->get('lang.tuesday'); ?>",
            "<?php echo app('translator')->get('lang.wednesday'); ?>",
            "<?php echo app('translator')->get('lang.thursday'); ?>",
            "<?php echo app('translator')->get('lang.friday'); ?>",
            "<?php echo app('translator')->get('lang.saturday'); ?>"
        ],
        dayNamesShort: [
            "<?php echo app('translator')->get('lang.sunday_short'); ?>",
            "<?php echo app('translator')->get('lang.monday_short'); ?>",
            "<?php echo app('translator')->get('lang.tuesday_short'); ?>",
            "<?php echo app('translator')->get('lang.wednesday_short'); ?>",
            "<?php echo app('translator')->get('lang.thursday_short'); ?>",
            "<?php echo app('translator')->get('lang.friday_short'); ?>",
            "<?php echo app('translator')->get('lang.saturday_short'); ?>"
        ],
        monthNames: [
            "<?php echo app('translator')->get('lang.january'); ?>",
            "<?php echo app('translator')->get('lang.february'); ?>",
            "<?php echo app('translator')->get('lang.march'); ?>",
            "<?php echo app('translator')->get('lang.april'); ?>",
            "<?php echo app('translator')->get('lang.may'); ?>",
            "<?php echo app('translator')->get('lang.june'); ?>",
            "<?php echo app('translator')->get('lang.july'); ?>",
            "<?php echo app('translator')->get('lang.august'); ?>",
            "<?php echo app('translator')->get('lang.september'); ?>",
            "<?php echo app('translator')->get('lang.october'); ?>",
            "<?php echo app('translator')->get('lang.november'); ?>",
            "<?php echo app('translator')->get('lang.december'); ?>"
        ],
        monthNamesShort: [
            "<?php echo app('translator')->get('lang.january_short'); ?>",
            "<?php echo app('translator')->get('lang.february_short'); ?>",
            "<?php echo app('translator')->get('lang.march_short'); ?>",
            "<?php echo app('translator')->get('lang.april_short'); ?>",
            "<?php echo app('translator')->get('lang.may_short'); ?>",
            "<?php echo app('translator')->get('lang.june_short'); ?>",
            "<?php echo app('translator')->get('lang.july_short'); ?>",
            "<?php echo app('translator')->get('lang.august_short'); ?>",
            "<?php echo app('translator')->get('lang.september_short'); ?>",
            "<?php echo app('translator')->get('lang.october_short'); ?>",
            "<?php echo app('translator')->get('lang.november_short'); ?>",
            "<?php echo app('translator')->get('lang.december_short'); ?>"
        ]
    };
</script>

<!--trigger element-->
<span class="edit-add-modal-button js-ajax-ux-request reset-target-modal-form" id="calendar-event-trigger"
    data-toggle="modal" data-target="#commonModal" data-loading-target="commonModalBody"
    data-modal-title="" data-action-method="GET" data-action-ajax-class="ajax-request"
    data-modal-size="modal-lg" data-action-ajax-loading-target="commonModalBody" data-footer-visibility="hidden"
    data-url-backup="<?php echo e(url('/calendar')); ?>/" data-url="<?php echo e(url('/calendar')); ?>/">
    <!--dynamic-->
</span><?php /**PATH C:\xampp\htdocs\application\resources\views/pages/calendar/calendar.blade.php ENDPATH**/ ?>