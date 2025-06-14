<div class="col-12">
    <div class="table-responsive m-t-40 invoice-table-wrapper {{ config('css.bill_mode') }} clear-both">
        <table class="table table-hover invoice-table {{ config('css.bill_mode') }}">
            <thead>
                <tr>
                    <!--action-->
                    @if(config('visibility.bill_mode') == 'editing')
                    <th class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }} x-action bill_col_action"></th>
                    @endif
                    <!--description-->
                    <th class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }} x-description bill_col_description">{{ cleanLang(__('lang.description')) }}
                    </th>
                    <!--quantity-->
                    <th class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }} x-quantity bill_col_quantity">{{ cleanLang(__('lang.qty')) }}</th>
                    <!--unit price-->
                    <th class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }} x-unit bill_col_unit">{{ cleanLang(__('lang.unit')) }}</th>
                    <!--rate-->
                    <th class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }} x-rate bill_col_rate">{{ cleanLang(__('lang.rate')) }}</th>
                    <!--tax-->
                    <th
                        class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }} x-tax bill_col_tax {{ runtimeVisibility('invoice-column-inline-tax', $bill->bill_tax_type) }}">
                        {{ cleanLang(__('lang.tax')) }}</th>
                    <!--total-->
                    <th class="{{ app()->getLocale() == 'persian' ? 'text-left' : 'text-right' }} x-total bill_col_total" id="bill_col_total">{{ cleanLang(__('lang.total')) }}
                    </th>
                </tr>
            </thead>
            @if(config('visibility.bill_mode') == 'editing')
            <tbody id="billing-items-container" class="billing-items-container-editing">
                @foreach($lineitems as $lineitem)
                <!--plain line-->
                @if($lineitem->lineitem_type == 'plain')
                @include('pages.bill.components.elements.line-plain')
                @endif

                <!--estimation notes-->
                @if($lineitem->item_notes_estimatation != '')
                @include('pages.bill.components.elements.line-estimation-notes')
                @endif

                <!--time line-->
                @if($lineitem->lineitem_type == 'time')
                @include('pages.bill.components.elements.line-time')
                @endif

                <!--dimensions line-->
                @if($lineitem->lineitem_type == 'dimensions')
                @include('pages.bill.components.elements.line-dimensions')
                @endif

                @endforeach
            </tbody>
            @else
            <tbody id="billing-items-container {{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
                @include('pages.bill.components.elements.lineitems')
            </tbody>
            @endif
        </table>
    </div>
</div>