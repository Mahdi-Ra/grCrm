<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for expenses
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Log;

class ExpenseRepository {

    /**
     * The expenses repository instance.
     */
    protected $expenses;

    /**
     * Inject dependecies
     */
    public function __construct(Expense $expenses) {
        $this->expenses = $expenses;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @param array $data optional data payload
     * @return object expense collection
     */
    public function search($id = '', $data = array()) {

        $expenses = $this->expenses->newQuery();

        //default - always apply filters
        if (!isset($data['apply_filters'])) {
            $data['apply_filters'] = true;
        }

        //carbon dates
        $now = \Carbon\Carbon::now();
        $this_month = \Carbon\Carbon::now()->startOfMonth();

        //joins
        $expenses->leftJoin('clients', 'clients.client_id', '=', 'expenses.expense_clientid');
        $expenses->leftJoin('projects', 'projects.project_id', '=', 'expenses.expense_projectid');
        $expenses->leftJoin('categories', 'categories.category_id', '=', 'expenses.expense_categoryid');
        $expenses->leftJoin('users', 'users.id', '=', 'expenses.expense_creatorid');
        $expenses->leftJoin('pinned', function ($join) {
            $join->on('pinned.pinnedresource_id', '=', 'expenses.expense_id')
                ->where('pinned.pinnedresource_type', '=', 'expense');
            if (auth()->check()) {
                $join->where('pinned.pinned_userid', auth()->id());
            }
        });

        // all client fields
        $expenses->selectRaw('*');

        //default where
        $expenses->whereRaw("1 = 1");

        //filter by passed id
        if (is_numeric($id)) {
            $expenses->where('expense_id', $id);
        }

        //filter by client - used for counting on external pages
        if (isset($data['project_clientid'])) {
            $expenses->where('project_clientid', $data['expense_clientid']);
        }

        //apply filters
        if ($data['apply_filters']) {

            //filters: id
            if (request()->filled('filter_expense_id')) {
                $expenses->where('expense_id', request('filter_expense_id'));
            }

            //filters: client id
            if (request()->filled('filter_expense_clientid') && $data['apply_filters']) {
                $expenses->where('expense_clientid', request('filter_expense_clientid'));
            }

            //filters: creator id
            if (request()->filled('filter_expense_creatorid')) {
                $expenses->where('expense_creatorid', request('filter_expense_creatorid'));
            }

            //filters: creator id (list)
            if (request()->filled('filter_expense_creatorid_list') && is_array(request('filter_expense_creatorid_list'))) {
                $expenses->whereIn('expense_creatorid', request('filter_expense_creatorid_list'));
            }

            //filter: amount (min)
            if (request()->filled('filter_expense_amount_min')) {
                $expenses->where('expense_amount', '>=', request('filter_expense_amount_min'));
            }

            //filter: amount (max)
            if (request()->filled('filter_expense_amount_max')) {
                $expenses->where('expense_amount', '<=', request('filter_expense_amount_max'));
            }

            //filter: date (start)
            if (request()->filled('filter_expense_date_start')) {
                $expenses->whereDate('expense_date', '>=', request('filter_expense_date_start'));
            }

            //filter: date (start)
            if (request()->filled('filter_expense_date_end')) {
                $expenses->whereDate('expense_date', '<=', request('filter_expense_date_end'));
            }

            //filters: billing status
            if (request()->filled('expense_billing_status')) {
                $expenses->where('expense_billing_status', request('expense_billing_status'));
            }

            //filters: billable
            if (request()->filled('expense_billable')) {
                $expenses->where('expense_billable', request('expense_billable'));
            }

            //filters: project id
            if (request()->filled('filter_expense_projectid') && $data['apply_filters']) {
                $expenses->where('expense_projectid', request('filter_expense_projectid'));
            }

            //stats: - sum billable
            if (isset($data['stats']) && $data['stats'] == 'sum-invoiced') {
                $expenses->where('expense_billing_status', 'invoiced');
            }

            //stats: - sum unbillable
            if (isset($data['stats']) && $data['stats'] == 'sum-not-invoiced') {
                $expenses->where('expense_billing_status', 'not_invoiced');
            }

            //resource filtering
            if (request()->filled('expenseresource_type') && request()->filled('expenseresource_id')) {
                switch (request('expenseresource_type')) {
                case 'client':
                    $expenses->where('expense_clientid', request('expenseresource_id'));
                    break;
                case 'project':
                    $expenses->where('expense_projectid', request('expenseresource_id'));
                    break;
                }
            }

            //filter category
            if (is_array(request('filter_expense_categoryid'))) {
                $expenses->whereIn('expense_categoryid', request('filter_expense_categoryid'));
            }

            //search: various client columns and relationships (where first, then wherehas)
            if (request()->filled('search_query') || request()->filled('query')) {
                $expenses->where(function ($query) {
                    $query->Where('expense_id', '=', request('search_query'));
                    if (is_numeric(request('search_query'))) {
                        $query->orWhere('expense_amount', '=', request('search_query'));
                    }
                    $query->orWhere('expense_date', '=', date('Y-m-d', strtotime(request('search_query'))));
                    $query->orWhere('expense_billing_status', '=', request('search_query'));
                    $query->orWhere('expense_billable', '=', request('search_query'));
                    $query->orWhere('expense_description', 'LIKE', '%' . request('search_query') . '%');
                    $query->orWhereHas('category', function ($q) {
                        $q->where('category_name', 'LIKE', '%' . request('search_query') . '%');
                    });
                    $query->orWhereHas('client', function ($q) {
                        $q->where('client_company_name', 'LIKE', '%' . request('search_query') . '%');
                    });
                    $query->orWhereHas('project', function ($q) {
                        $q->where('project_title', 'LIKE', '%' . request('search_query') . '%');
                    });

                });
            }

        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('expenses', request('orderby'))) {
                $expenses->orderByRaw('CASE WHEN pinned.pinned_id IS NOT NULL THEN 1 ELSE 0 END DESC')
                    ->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'client':
                $expenses->orderByRaw('CASE WHEN pinned.pinned_id IS NOT NULL THEN 1 ELSE 0 END DESC')
                    ->orderBy('client_company_name', request('sortorder'));
                break;
            case 'project':
                $expenses->orderByRaw('CASE WHEN pinned.pinned_id IS NOT NULL THEN 1 ELSE 0 END DESC')
                    ->orderBy('project_title', request('sortorder'));
                break;
            case 'category':
                $expenses->orderByRaw('CASE WHEN pinned.pinned_id IS NOT NULL THEN 1 ELSE 0 END DESC')
                    ->orderBy('category_name', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $expenses->orderByRaw('CASE WHEN pinned.pinned_id IS NOT NULL THEN 1 ELSE 0 END DESC')
                ->orderBy(config('settings.ordering_expenses.sort_by'), config('settings.ordering_expenses.sort_order'));
        }

        //eager load
        $expenses->with([
            'project',
            'client',
            'category',
        ]);

        //stats - count all
        if (isset($data['stats']) && $data['stats'] == 'count-all') {
            return $expenses->count();
        }
        //stats - sum all
        if (isset($data['stats']) && in_array($data['stats'], [
            'sum-all',
            'sum-invoiced',
            'sum-not-invoiced',
        ])) {
            return $expenses->sum('expense_amount');
        }

        //we are not paginating (e.g. when doing exports)
        if (isset($data['no_pagination']) && $data['no_pagination'] === true) {
            return $expenses->get();
        }

        // return paginated rows
        return $expenses->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Create a new record
     * @return mixed int|bool
     */
    public function create() {

        //save new user
        $expense = new $this->expenses;

        //data
        $expense->expense_date = request('expense_date');
        $expense->expense_clientid = request('expense_clientid');
        $expense->expense_creatorid = (is_numeric(request('expense_creatorid'))) ? request('expense_creatorid') : auth()->id();
        $expense->expense_projectid = request('expense_projectid');
        $expense->expense_categoryid = request('expense_categoryid');
        $expense->expense_amount = request('expense_amount');
        $expense->expense_description = request('expense_description');
        $expense->expense_billable = (request('expense_billable') == 'on') ? 'billable' : 'not_billable';

        //save and return id
        if ($expense->save()) {
            return $expense->expense_id;
        } else {
            Log::error("unable to create record - database error", ['process' => '[ExpenseRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * update a record
     * @param int $id record id
     * @return mixed int|bool
     */
    public function update($id) {

        //get the record
        if (!$expense = $this->expenses->find($id)) {
            return false;
        }

        //data
        $expense->expense_date = request('expense_date');
        $expense->expense_categoryid = request('expense_categoryid');
        $expense->expense_amount = request('expense_amount');
        $expense->expense_description = request('expense_description');
        $expense->expense_clientid = request('expense_clientid');
        $expense->expense_projectid = request('expense_projectid');

        //update only if this expense has not already been invoiced
        if ($expense->expense_billing_status != 'invoiced') {
            $expense->expense_billable = (request('expense_billable') == 'on') ? 'billable' : 'not_billable';
        }

        //update team members
        if (is_numeric(request('expense_creatorid'))) {
            $expense->expense_creatorid = request('expense_creatorid');
        }

        //save
        if ($expense->save()) {
            return $expense->expense_id;
        } else {
            Log::error("unable to create record - database error", ['process' => '[ExpenseRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * find all expenses that need to be recurred today and recurr them
     * increase the counter by one and set the next renewal date based on available data any cycle settings
     * @param int $limit number of expenses to process at a time
     * @return bool
     */
    public function recurringExpenses($limit = 0) {

        //validate limit
        $limit = (is_numeric($limit) && $limit > 0) ? $limit : 5;

        //todays date
        $today = \Carbon\Carbon::now()->format('Y-m-d');

        //new query
        $expenses = $this->expenses->newQuery();

        // all fields
        $expenses->selectRaw('*');

        //recurring
        $expenses->where('expense_recurring', 'yes');

        //next expense date is today
        $expenses->where('expense_recurring_next', $today);

        //exlcude those already processings
        $expenses->where('expense_cron_status', '!=', 'processing');

        //valid cycles
        $expenses->where('expense_recurring_duration', '>', 0);

        //there is still expenseing cycles to go
        $expenses->where(function ($query) {
            //infinite
            $query->where('expense_recurring_cycles', 0);
            //or still has cycles to go
            $query->orWhereColumn('expense_recurring_cycles_counter', '<', 'expense_recurring_cycles');
        });

        //get the expenses
        $results = $expenses->take($limit)->get();

        $count = $results->count();

        Log::info("found ($count) expenses due for recurring today", ['cronjob.expenses.recurring', config('app.debug_ref'), basename(__FILE__), __line__]);

        //create a new expense
        foreach ($results as $expense) {

            //mark as processing (prevents overlapping cron processes)
            $expense->expense_cron_status = 'processing';
            $expense->save();

            //clone the expense
            $new_expense = $expense->replicate();

            //reset unique fields
            $new_expense->expense_created = \Carbon\Carbon::now();
            $new_expense->expense_recurring = 'no';
            $new_expense->expense_recurring_duration = null;
            $new_expense->expense_recurring_period = null;
            $new_expense->expense_recurring_cycles = null;
            $new_expense->expense_recurring_cycles_counter = 0;
            $new_expense->expense_recurring_last = null;
            $new_expense->expense_recurring_next = null;
            $new_expense->expense_recurring_child = 'yes';
            $new_expense->expense_recurring_parent_id = $expense->expense_id;
            $new_expense->expense_date = $today;
            $new_expense->expense_cron_status = 'none';
            $new_expense->save();

            $new_expense_id = $new_expense->expense_id;

            //update recurring settings for parent
            $expense->expense_recurring_cycles_counter = $expense->expense_recurring_cycles_counter + 1;

            //calculate next renewal date
            switch ($expense->expense_recurring_period) {
            case 'day':
                $expense->expense_recurring_next = \Carbon\Carbon::now()->addDays($expense->expense_recurring_duration);
                break;
            case 'week':
                $expense->expense_recurring_next = \Carbon\Carbon::now()->addWeeks($expense->expense_recurring_duration);
                break;
            case 'month':
                $expense->expense_recurring_next = \Carbon\Carbon::now()->addMonths($expense->expense_recurring_duration);
                break;
            case 'year':
                $expense->expense_recurring_next = \Carbon\Carbon::now()->addYears($expense->expense_recurring_duration);
                break;
            }

            //update last renewal date
            $expense->expense_recurring_last = $today;

            //reset cron status
            $expense->expense_cron_status = 'completed';

            //save parent
            $expense->save();
            $expense_id = $expense->expense_id;

            Log::info("expense with id ($expense_id) has been recurred. New expense id($new_expense_id)", ['cronjob.expenses.recurring', config('app.debug_ref'), basename(__FILE__), __line__]);
        }

        return true;
    }

}