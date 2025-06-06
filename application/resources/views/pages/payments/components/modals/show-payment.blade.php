<div class="row">
    <div class="col-lg-12">
        <div class="p-b-30">

            <table class="table table-bordered payment-details">
                <tbody>
                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.payment_id')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-left' : 'text-right' }}">#{{ $payment->payment_id }}</td>
                    </tr>
                    <tr class="font-16 font-weight-600">
                            <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.amount')) }}</td>
                            <td class="{{ app()->getLocale() == 'persian' ? 'text-left' : 'text-right' }}">
                                {{ runtimeMoneyFormat($payment->payment_amount) }}</td>
                        </tr>
                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.invoice_id')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-left' : 'text-right' }}"> {{ runtimeInvoiceIdFormat($payment->payment_invoiceid) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.date')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-left' : 'text-right' }}">{{ runtimeDate($payment->payment_date) }}</td>
                    </tr>

                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.payment_method')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-left' : 'text-right' }}">{{ $payment->payment_gateway }}</td>
                    </tr>
                    @if(auth()->user()->is_team)
                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.client')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-left' : 'text-right' }}">{{ $payment->client_company_name }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.project')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-left' : 'text-right' }}">{{ $payment->project_title }}</td>
                    </tr>
                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.notes')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-left' : 'text-right' }}">{{ $payment->payment_notes }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>