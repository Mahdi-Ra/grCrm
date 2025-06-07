<div class="row">
    <div class="col-12">
        <div class="table-responsive receipt">
            <table class="table table-bordered">
                <tbody>
                    <!--date-->
                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.date')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ runtimeDate($expense->expense_date) }}</td>
                    </tr>
                    <!--client-->
                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.client')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ $expense->client_company_name }}</td>
                    </tr>
                    <!--project-->
                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.project')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ $expense->project_title }}</td>
                    </tr>
                    <!--user-->
                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.recorded_by')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ $expense->first_name }} {{ $expense->last_name }}</td>
                    </tr>
                    <!--description-->
                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.description')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ $expense->expense_description }}</td>
                    </tr>
                    <!--Attchment-->
                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.attachement')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
                            @foreach($attachments as $attachment)
                            <ul class="p-l-0">
                                <li  id="fx-expenses-files-attached">
                                    <a href="expenses/attachments/download/{{ $attachment->attachment_uniqiueid }}" download>
                                        {{ $attachment->attachment_filename }} <i class="ti-download"></i>
                                    </a>
                                </li>
                            </ul>
                            @endforeach
                        </td>
                    </tr>
                    <!--date-->
                    <!--description-->
                    <tr>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.financial')) }}</td>
                        <td class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">
                            <span
                                class="label {{ runtimeExpenseStatusColors($expense->expense_billable, 'label') }}">{{ runtimeLang($expense->expense_billable) }}</span> <span
                                class="label {{ runtimeExpenseStatusColors($expense->expense_billing_status, 'label') }}">{{
                            runtimeLang($expense->expense_billing_status) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td id="fx-expenses-td-amount" class="{{ app()->getLocale() == 'persian' ? 'text-right' : 'text-left' }}">{{ cleanLang(__('lang.amount')) }}</td>
                        <td id="fx-expenses-td-money">{{ runtimeMoneyFormat($expense->expense_amount) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>