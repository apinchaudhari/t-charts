<?php

namespace App\Http\Controllers\Superadmin\Common;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Common\Company as Request;
use App\Jobs\Common\CreateCompany;
use App\Jobs\Common\DeleteCompany;
use App\Jobs\Superadmin\Common\UpdateCompany;
use App\Models\Superadmin\Common\Company;
use App\Models\Superadmin\Setting\Currency;
use App\Traits\Uploads;
use App\Traits\Users;
use Illuminate\Support\Facades\DB;

class Companies extends Controller
{
    use Uploads, Users;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
      //  $companies = user()->companies()->collect();
       // $companies = DB::table('companies')->leftjoin('settings', 'companies.id', '=', 'settings.company_id')->get();
       //$companies = user()->companies()->collect();
       $companies = DB::table('companies')->leftjoin('settings', 'companies.id', '=', 'settings.company_id')->get()->collect();
      // echo "<pre>";print_r($companies);exit;
        $company_data = array();
        foreach($companies as $company){
            if(!empty($company->company_id)){
                $company_data[$company->company_id]['id'] = $company->company_id;
                $company_data[$company->company_id]['enabled'] = $company->enabled;
                $company_data[$company->company_id]['created_at'] = $company->created_at;
                $company_data[$company->company_id][str_replace("company.","",$company->key)] = $company->value;
            }
        }
        $companies = json_decode(json_encode($company_data));
        $companies_data =  DB::table('companies')->get()->collect();
       // echo "<pre>";print_r($companies);exit;
        return $this->response('superadmin.common.companies.index', compact('companies', 'companies_data'));
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return redirect()->route('superadmin.companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $currencies = Currency::enabled()->pluck('name', 'code');

        return view('superadmin.common.companies.create', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $current_company_id = company_id();

        $response = $this->ajaxDispatch(new CreateCompany($request));

        if ($response['success']) {
            $response['redirect'] = route('companies.index');

            $message = trans('messages.success.added', ['type' => trans_choice('general.companies', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('companies.create');

            $message = $response['message'];

            flash($message)->error()->important();
        }

        company($current_company_id)->makeCurrent();

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Company  $company
     *
     * @return Response
     */
    public function edit(Company $company)
    {
        // if ($this->isNotUserCompany($company->id)) {
        //     return redirect()->route('companies.index');
        // }

        $currencies = Currency::enabled()->pluck('name', 'code');

        return view('superadmin.common.companies.edit', compact('company', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Company $company
     * @param  Request $request
     *
     * @return Response
     */
    public function update(Company $company, Request $request)
    {
        $current_company_id = company_id();

        $response = $this->ajaxDispatch(new UpdateCompany($company, $request, company_id()));

        if ($response['success']) {
            $response['redirect'] = route('companies.index');

            $message = trans('messages.success.updated', ['type' => trans_choice('general.companies', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('companies.edit', $company->id);

            $message = $response['message'];

            flash($message)->error()->important();
        }

        company($current_company_id)->makeCurrent();

        return response()->json($response);
    }

    /**
     * Enable the specified resource.
     *
     * @param  Company $company
     *
     * @return Response
     */
    public function enable(Company $company)
    {
        $response = $this->ajaxDispatch(new UpdateCompany($company, request()->merge(['enabled' => 1])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.enabled', ['type' => trans_choice('general.companies', 1)]);
        }

        return response()->json($response);
    }

    /**
     * Disable the specified resource.
     *
     * @param  Company $company
     *
     * @return Response
     */
    public function disable(Company $company)
    {
        $response = $this->ajaxDispatch(new UpdateCompany($company, request()->merge(['enabled' => 0])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.disabled', ['type' => trans_choice('general.companies', 1)]);
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Company $company
     *
     * @return Response
     */
    public function destroy(Company $company)
    {
        $response = $this->ajaxDispatch(new DeleteCompany($company));

        $response['redirect'] = route('companies.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => trans_choice('general.companies', 1)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Change the active company.
     *
     * @param  Company  $company
     *
     * @return Response
     */
    public function switch(Company $company)
    {
        if ($this->isUserCompany($company->id)) {
            $old_company_id = company_id();

            $company->makeCurrent();

            session(['dashboard_id' => user()->dashboards()->enabled()->pluck('id')->first()]);

            event(new \App\Events\Common\CompanySwitched($company, $old_company_id));

            // Check wizard
            if (!setting('wizard.completed', false)) {
                return redirect()->route('wizard.edit', ['company_id' => $company->id]);
            }
        }

        return redirect()->route('dashboard', ['company_id' => $company->id]);
    }

    public function autocomplete()
    {
        $query = request('query');

        $autocomplete = Company::autocomplete([
            'name' => $query
        ]);

        $companies = $autocomplete->get()->sortBy('name')->pluck('name', 'id');

        return response()->json([
            'success' => true,
            'message' => 'Get all companies.',
            'errors' => [],
            'count' => $companies->count(),
            'data' => ($companies->count()) ? $companies : null,
        ]);
    }
}
