<!-- right-sidebar -->
<div class="right-sidebar" id="sidepanel-calender-settings">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i><?php echo app('translator')->get('lang.calendar_settings'); ?>
                <span>
                    <i class="ti-close js-close-side-panels" data-target="sidepanel-calender-settings"></i>
                </span>
            </div>
            <!--title-->
            <!--body-->
            <div class="r-panel-body">

                <!--events_display_date-->
                <div class="filter-block m-b-30">
                    <div class="title">
                        <?php echo app('translator')->get('lang.events_display_date'); ?>
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select class="select2-basic form-control form-control-sm select2-preselected"
                                    id="pref_calendar_dates_events" name="pref_calendar_dates_events"
                                    data-preselected="<?php echo e(auth()->user()->pref_calendar_dates_events); ?>">
                                    <option value="start"><?php echo app('translator')->get('lang.start_date'); ?></option>
                                    <option value="due"><?php echo app('translator')->get('lang.end_date_due'); ?></option>
                                    <option value="start_due"><?php echo app('translator')->get('lang.start_and_due_date'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!--tasks_display_date-->
                <div class="filter-block m-b-30">
                    <div class="title">
                        <?php echo app('translator')->get('lang.tasks_display_date'); ?>
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select class="select2-basic form-control form-control-sm select2-preselected"
                                    id="pref_calendar_dates_tasks" name="pref_calendar_dates_tasks"
                                    data-preselected="<?php echo e(auth()->user()->pref_calendar_dates_tasks); ?>">
                                    <option value="start"><?php echo app('translator')->get('lang.start_date'); ?></option>
                                    <option value="due"><?php echo app('translator')->get('lang.end_date_due'); ?></option>
                                    <option value="start_due"><?php echo app('translator')->get('lang.start_and_due_date'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <!--projects_display_date-->
                <div class="filter-block m-b-30">
                    <div class="title">
                        <?php echo app('translator')->get('lang.projects_display_date'); ?>
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select class="select2-basic form-control form-control-sm select2-preselected"
                                    id="pref_calendar_dates_projects" name="pref_calendar_dates_projects"
                                    data-preselected="<?php echo e(auth()->user()->pref_calendar_dates_projects); ?>">
                                    <option value="start"><?php echo app('translator')->get('lang.start_date'); ?></option>
                                    <option value="due"><?php echo app('translator')->get('lang.end_date_due'); ?></option>
                                    <option value="start_due"><?php echo app('translator')->get('lang.start_and_due_date'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if(auth()->user()->is_admin): ?>
                <!--projects_display_date-->
                <div class="filter-block m-b-30">
                    <div class="title">
                        <?php echo app('translator')->get('lang.projects_and_taks'); ?>
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select class="select2-basic form-control form-control-sm select2-preselected"
                                    id="pref_calendar_view" name="pref_calendar_view"
                                    data-preselected="<?php echo e(auth()->user()->pref_calendar_view); ?>">
                                    <option value="own"><?php echo app('translator')->get('lang.only_mine'); ?></option>
                                    <option value="all"><?php echo app('translator')->get('lang.display_all'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>



                <!--buttons-->
                <div class="buttons-block">
                    <button type="button" class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        data-url="<?php echo e(urlResource('/calendar?calendar_action=user-preferences')); ?>" data-type="form"
                        data-ajax-type="GET"><?php echo e(cleanLang(__('lang.apply_changes'))); ?></button>
                </div>

                <div class="line"></div>

                <div class="alert alert-info"><?php echo app('translator')->get('lang.calender_not_seeing_items'); ?> <span
                        class="align-middle text-info font-16" data-toggle="tooltip" title="<?php echo app('translator')->get('lang.calender_not_seeing_info'); ?>"
                        data-placement="top"><i class="ti-info-alt"></i></span></div>

            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar--><?php /**PATH C:\xampp\htdocs\application\resources\views/pages/calendar/components/misc/settings.blade.php ENDPATH**/ ?>