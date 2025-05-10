<div class="col-lg-4  col-md-12">
    <div class="card">
        <div class="card card-body mailbox m-b-0">
            <h5 class="card-title {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.projects')) }}</h5>
            <div class="message-center dashboard-projects-admin">
                <!-- not started -->
                <a href="javascript:void(0)">
                    <div class="mail-contnet {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
                        <h5>{{ cleanLang(__('lang.not_started')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.assigned_to_me')) }}:
                            <strong>{{ $payload['my_projects']['not_started'] }}</strong></span>
                    </div>
                    <div class="btn label-default btn-circle">{{ $payload['all_projects']['not_started'] }}</div>
                </a>

                <!-- in progress -->
                <a href="javascript:void(0)">
                    <div class="mail-contnet {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
                        <h5>{{ cleanLang(__('lang.in_progress')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.assigned_to_me')) }}:
                            <strong>{{ $payload['my_projects']['in_progress'] }}</strong></span>
                    </div>
                    <div class="btn btn-info btn-circle">{{ $payload['all_projects']['in_progress'] }}</div>
                </a>

                <!-- on hold -->
                <a href="javascript:void(0)">
                    <div class="mail-contnet {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
                        <h5>{{ cleanLang(__('lang.on_hold')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.assigned_to_me')) }}:
                            <strong>{{ $payload['my_projects']['on_hold'] }}</strong></span>
                    </div>
                    <div class="btn btn-warning btn-circle">{{ $payload['all_projects']['on_hold'] }}</div>
                </a>


                <!-- completed -->
                <a href="javascript:void(0)">
                    <div class="mail-contnet {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
                        <h5>{{ cleanLang(__('lang.completed')) }}</h5> <span class="mail-desc">{{ cleanLang(__('lang.assigned_to_me')) }}:
                            <strong>{{ $payload['my_projects']['completed'] }}</strong></span>
                    </div>
                    <div class="btn btn-success btn-circle">{{ $payload['all_projects']['completed'] }}</div>
                </a>
            </div>
        </div>
    </div>
</div>