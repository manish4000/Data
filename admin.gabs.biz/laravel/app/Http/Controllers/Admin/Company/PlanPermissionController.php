<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use App\Models\Company\CompanyMenuGroupMenu;
use App\Models\Company\CompanyPermission;
use App\Models\Company\CompanyPlanModel;
use App\Models\Company\CompanyPlanPermissionModel;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanPermissionController extends Controller
{   
    protected $baseUrl      =   '';
    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
        $this->baseUrl = $this->url->to('admin/company/plan-permission');
    } 

    public function index(){

        if (!Auth::user()->can('main-navigation-company-plan-permission')) {
            abort(403);
        }

      $companyPlans =   CompanyPlanModel::orderBy('order_by','asc')->get();

    //   $companyPermissions=CompanyPermission::where('parent_id', 0)->get();
      $companyPermissions=CompanyMenuGroupMenu::where('parent_id', 0)->get();

      $companyPlanPermissionData = CompanyPlanPermissionModel::get();
      $pageConfigs = [
        'baseUrl' => $this->baseUrl, 
        'moduleName' => __('webCaption.plan_permissions.title'), 
        ];
      return view('content.admin.company.planPermission.index',compact('companyPlans','pageConfigs','companyPermissions','companyPlanPermissionData'));
    }

    public function store(Request $request){

        if (!Auth::user()->can('main-navigation-company-plan-permission-edit')) {
            abort(403);
        }
        
        $plans =  $request->plan_id;
        $companyPlanPermissionModel =   new CompanyPlanPermissionModel;
        foreach($plans as $plan){
            $data = [
                'company_plan_id' => $plan,
                'permissions' => isset($request->permissions[$plan]) ? $request->permissions[$plan] :[],
            ];
            $companyPlanPermissionModel->updateOrCreate(['company_plan_id'=> $plan ],$data);
            $data = [];
        }

        $companyPlanPermissionModel->whereNotIn('company_plan_id',$plans)->delete();
        return redirect()->back()->with(['success_message' => __('webCaption.alert_updated_successfully.title')]);
    }


}
