<!-- right-sidebar -->
<div class="right-sidebar reminders-side-panel" id="reminders-side-panel">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}"> <!--add class'due'to title panel -->
                <i class="ti-alarm-clock display-inline-block"></i>
                <div class="display-inline-block" id="reminders-side-panel-title">
                    <!--dynamic title-->
                </div>
                <span>
                    <i class="ti-close js-close-side-panels" data-target="reminders-side-panel" id="reminders-side-panel-close-icon"></i>
                </span>
            </div>
            <!--title-->
            <!--body-->
            <div class="r-panel-body reminders-side-panel-body  p-b-80" id="reminders-side-panel-body">




            </div>

            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->