<div class="card count-{{ @count($templates ?? []) }}" id="template-table-wrapper">
    <div class="card-body">
        <div class="table-responsive">
            @if (@count($templates ?? []) > 0)
            <table id="template-contract-addrow" class="table m-t-0 m-b-0 table-hover no-wrap" data-page-size="10">
                <thead>

                    <!--contract_template_title-->
                    <th class="col_contract_template_title {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}"><a class="js-ajax-ux-request js-list-sorting"
                            id="sort_contract_template_title" href="javascript:void(0)"
                            data-url="{{ urlResource('/templates/contracts?action=sort&orderby=contract_template_title&sortorder=asc') }}">@lang('lang.title')<span
                                class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                    <!--contract_template_created-->
                    <th class="col_contract_template_created {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}"><a class="js-ajax-ux-request js-list-sorting"
                            id="sort_contract_template_created" href="javascript:void(0)"
                            data-url="{{ urlResource('/templates/contracts?action=sort&orderby=contract_template_created&sortorder=asc') }}">@lang('lang.date_created')<span
                                class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                    <!--created by-->
                    <th class="col_created_by {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}"><a class="js-list-sorting" id="sort_fooo"
                            href="javascript:void(0)">@lang('lang.created_by')</a></th>

                    <!--actions-->
                    <th class="col_contracts_actions w-px-120 {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}"><a href="javascript:void(0)">@lang('lang.actions')</a>
                    </th>
                </thead>
                <tbody id="template-td-container">
                    <!--ajax content here-->
                    @include('pages.templates.contracts.components.table.ajax')
                    <!--ajax content here-->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--load more button-->
                        </td>
                    </tr>
                </tfoot>
            </table>
            @endif @if (@count($templates ?? []) == 0)
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif
        </div>
    </div>
</div>