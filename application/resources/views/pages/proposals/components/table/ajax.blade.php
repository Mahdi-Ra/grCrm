@foreach($proposals as $proposal)
<!--each row-->
<tr id="proposal_{{ $proposal->doc_id }}" class="{{ $proposal->pinned_status ?? '' }}">
    @if(config('visibility.proposals_col_checkboxes'))
    <td class="proposals_col_checkbox checkproposal p-l-0" id="proposals_col_checkbox_{{ $proposal->doc_id }}">
        <!--list checkbox-->
        <span class="list-checkboxes display-inline-block w-px-20">
            <input type="checkbox" id="listcheckbox-proposals-{{ $proposal->doc_id }}"
                name="ids[{{ $proposal->doc_id }}]"
                class="listcheckbox listcheckbox-proposals filled-in chk-col-light-blue proposals-checkbox"
                data-actions-container-class="proposals-checkbox-actions-container"
                data-proposal-id="{{ $proposal->doc_id }}">
            <label for="listcheckbox-proposals-{{ $proposal->doc_id }}"></label>
        </span>
    </td>
    @endif

    <!--doc_id-->
    <td class="col_doc_id {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
        <a href="{{ url('/proposals/'.$proposal->doc_id) }}">{{ runtimeProposalIdFormat($proposal->doc_id) }}</a>
        <!--automation-->
        @if(auth()->user()->is_team && $proposal->proposal_automation_status == 'enabled')
        <span class="sl-icon-energy text-warning p-l-5" data-toggle="tooltip"
            title="@lang('lang.proposal_automation')"></span>
        @endif
    </td>

    <!--doc_date_start-->
    <td class="col_doc_date_start {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
        {{ runtimeDate($proposal->doc_date_start) }}
    </td>

    <!--client-->
    @if(config('visibility.col_client'))
    <td class="col_clien {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
        @if($proposal->docresource_type == 'client')
        <a href="{{ url('/clients/'.$proposal->client_id) }}"
            title="{{ $proposal->client_company_name ?? '---' }}">{{ str_limit($proposal->client_company_name ?? '---', 25) }}</a>
        @else
        <a href="{{ url('/leads/v/'.$proposal->lead_id.'/view/') }}"
            title="{{ runtimeLeadNameTitle($proposal->lead_firstname, $proposal->lead_lastname, $proposal->lead_title) }}">{{ str_limit(runtimeLeadNameTitle($proposal->lead_firstname, $proposal->lead_lastname), 25) }}</a>
        @endif
    </td>
    @endif

    <!--doc_title-->
    <td class="col_doc_title {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
        {{ str_limit($proposal->doc_title ?? '---', 20) }}
    </td>

    <!--value-->
    <td class="col_value {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
        {{ runtimeMoneyFormat($proposal->bill_final_amount) }}
    </td>

    @if(config('visibility.col_created_by'))
    <td class="col_created_by {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
        <img src="{{ getUsersAvatar($proposal->avatar_directory, $proposal->avatar_filename) }}" alt="user"
            class="img-circle avatar-xsmall">
        {{ $proposal->first_name ?? runtimeUnkownUser() }}
    </td>
    @endif

    <!--doc_date_end-->
    <td class="col_doc_date_start {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
        {{ runtimeDate($proposal->doc_date_end ?? '---') }}
    </td>

    <!--status-->
    <td class="col_foo {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
        <span
            class="label {{ runtimeProposalStatusColors($proposal->doc_status, 'label') }}">{{ runtimeLang($proposal->doc_status) }}</span>

        <!--proposal is scheduled-->
        @if($proposal->doc_publishing_type == 'scheduled' && $proposal->doc_publishing_scheduled_status == 'pending')
        <span class="label label-icons label-icons-warning" data-toggle="tooltip" data-placement="top"
            title="@lang('lang.scheduled_publishing_info'): {{ runtimeDate($proposal->doc_publishing_scheduled_date) }}"><i
                class="sl-icon-clock"></i></span>
        @endif
    </td>

    @if(config('visibility.proposals_col_action'))
    <td class="proposals_col_action actions_column {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}" id="proposals_col_action_{{ $proposal->doc_id }}">
        <!--action button-->
        <span class="list-table-action font-size-inherit">
            <!--delete-->
            @if(config('visibility.action_buttons_delete'))
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_product')) }}"
                data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                data-url="{{ url('/') }}/proposals/{{ $proposal->doc_id }}">
                <i class="sl-icon-trash"></i>
            </button>
            @endif
            <!--edit-->
            @if(config('visibility.action_buttons_edit'))
            <a type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm"
                href="{{ url('/proposals/'.$proposal->doc_id.'/edit') }}">
                <i class="sl-icon-note"></i>
            </a>
            @endif

            <!--view-->
            <a href="{{ _url('/proposals/'.$proposal->doc_id) }}" title="{{ cleanLang(__('lang.view')) }}"
                class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm">
                <i class="ti-new-window"></i>
            </a>

            <!--more button (team)-->
            @if(config('visibility.action_buttons_edit') == 'show')
            <span class="list-table-action dropdown font-size-inherit">
                <button type="button" id="listTableAction" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" title="{{ cleanLang(__('lang.more')) }}"
                    class="data-toggle-action-tooltip btn btn-outline-default-light btn-circle btn-sm">
                    <i class="ti-more"></i>
                </button>
                <div class="dropdown-menu {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}" aria-labelledby="listTableAction">

                    <!--proposal url-->
                    <a class="dropdown-item"
                        href="{{ url('/proposals/view/'.$proposal->doc_unique_id.'?action=preview') }}"
                        target="_blank">@lang('lang.proposal_url')</a>

                    <!--actions button - email client -->
                    <a class="dropdown-item confirm-action-info" href="javascript:void(0)"
                        data-confirm-title="{{ cleanLang(__('lang.email_to_client')) }}"
                        data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                        data-url="{{ url('/proposals') }}/{{ $proposal->doc_id }}/resend?ref=list">
                        {{ cleanLang(__('lang.email_to_client')) }}</a>

                    <!--clone proposal-->
                    @if(auth()->user()->role->role_proposals > 1)
                    <a class="dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form edit-add-modal-button"
                        href="javascript:void(0)" data-toggle="modal" data-target="#commonModal"
                        data-modal-title="{{ cleanLang(__('lang.clone_proposal')) }}"
                        data-url="{{ url('/proposals/'.$proposal->doc_id.'/clone') }}"
                        data-action-url="{{ url('/proposals/'.$proposal->doc_id.'/clone') }}"
                        data-loading-target="actionsModalBody" data-action-method="POST">
                        {{ cleanLang(__('lang.clone_proposal')) }}</a>
                    @endif

                    <!--actions button - change category-->
                    <a class="dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form"
                        href="javascript:void(0)" data-toggle="modal" data-target="#actionsModal"
                        data-modal-title="{{ cleanLang(__('lang.change_category')) }}"
                        data-url="{{ url('/proposals/change-category') }}"
                        data-action-url="{{ urlResource('/proposals/change-category?id='.$proposal->doc_id) }}"
                        data-loading-target="actionsModalBody" data-action-method="POST">
                        @lang('lang.change_category')</a>

                    <!--Mark As Accepted-->
                    <a class="dropdown-item confirm-action-danger {{ runtimeVisibility('document-status', 'accepted', $proposal->doc_status)}}"
                        href="javascript:void(0)" data-confirm-title="{{ cleanLang(__('lang.mark_as_accepted')) }}"
                        id="bill-actions-dettach-project" data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                        data-url="{{ url('/proposals/'.$proposal->doc_id.'/change-status?status=accepted&ref=list') }}">
                        @lang('lang.mark_as_accepted')</a>

                    <!--Mark As Declined-->
                    <a class="dropdown-item confirm-action-danger {{ runtimeVisibility('document-status', 'declined', $proposal->doc_status)}}"
                        href="javascript:void(0)" data-confirm-title="{{ cleanLang(__('lang.mark_as_accepted')) }}"
                        id="bill-actions-dettach-project" data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                        data-url="{{ url('/proposals/'.$proposal->doc_id.'/change-status?status=declined&ref=list') }}">
                        @lang('lang.mark_as_declined')</a>

                    <!--Mark As Revised-->
                    <a class="dropdown-item confirm-action-danger {{ runtimeVisibility('document-status', 'revised', $proposal->doc_status)}}"
                        href="javascript:void(0)" data-confirm-title="{{ cleanLang(__('lang.mark_as_revised')) }}"
                        id="bill-actions-dettach-project" data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                        data-url="{{ url('/proposals/'.$proposal->doc_id.'/change-status?status=revised&ref=list') }}">
                        @lang('lang.mark_as_revised')</a>

                    <!--automation-->
                    <a href="javascript:void(0)"
                        class="dropdown-item edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                        data-toggle="modal" data-target="#commonModal"
                        data-url="{{ urlResource('/proposals/'.$proposal->doc_id.'/edit-automation?ref=list') }}"
                        data-loading-target="commonModalBody" data-modal-title="@lang('lang.proposal_automation')"
                        data-action-url="{{ urlResource('/proposals/'.$proposal->doc_id.'/edit-automation?ref=list') }}"
                        data-action-method="POST"
                        data-action-ajax-loading-target="commonModalBody">@lang('lang.automation')
                    </a>

                </div>
            </span>
            @endif
            <!--more button-->

            <!--pin-->
            <span class="list-table-action">
                <a href="javascript:void(0);" title="{{ cleanLang(__('lang.pinning')) }}"
                    data-parent="proposal_{{ $proposal->doc_id }}"
                    data-url="{{ url('/proposals/'.$proposal->doc_id.'/pinning') }}"
                    class="data-toggle-action-tooltip btn btn-outline-default-light btn-circle btn-sm opacity-4 js-toggle-pinning">
                    <i class="ti-pin2"></i>
                </a>
            </span>

        </span>
        <!--action button-->
    </td>
    @endif
</tr>
@endforeach
<!--each row-->