@foreach($items as $item)
<!--each row-->
<tr id="item_{{ $item->item_id }}" class="{{ $item->pinned_status ?? '' }}">
    @if(config('visibility.items_col_checkboxes'))
    <td class="items_col_checkbox checkitem" id="items_col_checkbox_{{ $item->item_id }}">
        <!--list checkbox-->
        <span class="list-checkboxes display-inline-block w-px-20">
            <input type="checkbox" id="listcheckbox-items-{{ $item->item_id }}" name="ids[{{ $item->item_id }}]"
                class="listcheckbox listcheckbox-items filled-in chk-col-light-blue items-checkbox"
                data-actions-container-class="items-checkbox-actions-container" data-item-id="{{ $item->item_id }}"
                data-unit="{{ $item->item_unit }}" data-quantity="1" data-description="{{ $item->item_description }}"
                data-type="{{ $item->item_type }}" data-length="{{ $item->item_dimensions_length }}"
                data-width="{{ $item->item_dimensions_width }}" data-tax-status="{{ $item->item_tax_status }}"
                data-has-estimation-notes="{{ $item->has_estimation_notes }}"
                data-estimation-notes="{{ $item->estimation_notes_encoded }}" data-rate="{{ $item->item_rate }}">
            <label for="listcheckbox-items-{{ $item->item_id }}"></label>
        </span>
    </td>
    @endif
    <td class="items_col_description {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}" id="items_col_description_{{ $item->item_id }}">
        @if(config('settings.trimmed_title'))
        {{ runtimeProductStripTags(str_limit($item->item_description ?? '---', 45)) }}
        @else
        {{ runtimeProductStripTags($item->item_description) }}
        @endif
    </td>
    <td class="items_col_rate {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}" id="items_col_rate_{{ $item->item_id }}">
        {{ runtimeMoneyFormat($item->item_rate) }}
    </td>
    <td class="items_col_unit {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}" id="items_col_unit_{{ $item->item_id }}">{{ $item->item_unit }}</td>
    @if(config('visibility.items_col_category'))
    <td class="items_col_category ucwords {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}" id="items_col_category_{{ $item->item_id }}">
        {{ str_limit($item->category_name ?? '---', 30) }}</td>
    @endif

    <!--number sold-->
    <td class="items_col_count_sold {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
        {{ $item->count_sold }}
    </td>

    <!--amount sold-->
    <td class="items_col_amount_sold {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
        {{ runtimeMoneyFormat($item->sum_sold) }}
    </td>

    @if(config('visibility.items_col_action'))
    <td class="items_col_action actions_column {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}" id="items_col_action_{{ $item->item_id }}">
        <!--action button-->
        <span class="list-table-action font-size-inherit">
            <!--delete-->
            @if(config('visibility.action_buttons_delete'))
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_product')) }}"
                data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                data-url="{{ url('/') }}/items/{{ $item->item_id }}">
                <i class="sl-icon-trash"></i>
            </button>
            @endif
            @if(config('visibility.action_buttons_edit'))
            <!--edit-->
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/items/'.$item->item_id.'/edit') }}" data-loading-target="commonModalBody"
                data-modal-title="{{ cleanLang(__('lang.edit_product')) }}"
                data-action-url="{{ urlResource('/items/'.$item->item_id.'?ref=list') }}" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="items-td-container">
                <i class="sl-icon-note"></i>
            </button>
            <!--tasks-->
            <button type="button" title="@lang('lang.product_tasks')"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm js-toggle-side-panel"
                data-create-task-action-url="{{ url('items/tasks?item_id='.$item->item_id) }}"
                data-create-task-url="{{ url('items/tasks/create?item_id='.$item->item_id) }}"
                id="js-products-automation-tasks" data-url="{{ url('items/'.$item->item_id.'/tasks') }}"
                data-progress-bar="hidden" data-loading-target="products-tasks-side-panel-content"
                data-target="products-tasks-side-panel">
                <i class="ti-menu-alt"></i>
            </button>

            @endif
            <!--more button (team)-->
            @if(config('visibility.action_buttons_edit') == 'show')
            <span class="list-table-action dropdown font-size-inherit">
                <button type="button" id="listTableAction" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" title="{{ cleanLang(__('lang.more')) }}"
                    class="data-toggle-action-tooltip btn btn-outline-default-light btn-circle btn-sm">
                    <i class="ti-more"></i>
                </button>
                <div class="dropdown-menu {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}" aria-labelledby="listTableAction">
                    <!--actions button - change category-->
                    <a class="dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form"
                        href="javascript:void(0)" data-toggle="modal" data-target="#actionsModal"
                        data-modal-title="{{ cleanLang(__('lang.change_category')) }}"
                        data-url="{{ url('/items/change-category') }}"
                        data-action-url="{{ urlResource('/items/change-category?id='.$item->item_id) }}"
                        data-loading-target="actionsModalBody" data-action-method="POST">
                        {{ cleanLang(__('lang.change_category')) }}</a>
                    <!--actions button - attach project -->
                </div>
            </span>
            @endif

            <!--pin-->
            <span class="list-table-action {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
                <a href="javascript:void(0);" title="{{ cleanLang(__('lang.pinning')) }}"
                    data-parent="item_{{ $item->item_id }}" data-url="{{ url('/items/'.$item->item_id.'/pinning') }}"
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