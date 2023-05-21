<?php

namespace App\Http\Controllers;

use App\DataTables\OptionsGroupsDataTable;
use App\Http\Requests\OptionGroupsRequest;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\OptionGroups;

class OptionGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OptionsGroupsDataTable $dataTable)
    {
        $pageTitle = trans('messages.list_form_title', ['form' => trans('messages.option_groups')]);
        $auth_user = authSession();
        $assets = ['datatable'];
        return $dataTable->render('option_groups.index', compact('pageTitle', 'auth_user', 'assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        $auth_user = authSession();

        $option_groups = OptionGroups::find($id);
        $pageTitle = trans('messages.update_form_title', ['form' => trans('messages.option_groups')]);

        if ($option_groups == null) {
            $pageTitle = trans('messages.add_button_form', ['form' => trans('messages.option_groups')]);
            $option_groups = new OptionGroups;
        }

        return view('option_groups.create', compact('pageTitle', 'option_groups', 'auth_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OptionGroupsRequest $request)
    {
        if (demoUserPermission()) {
            return  redirect()->back()->withErrors(trans('messages.demo_permission_denied'));
        }
        $data = $request->all();

        /**
         * @var OptionGroups
         */
        $result = OptionGroups::updateOrCreate(['id' => $data['id']], $data);

        if ($request->type  == '') {
            if (count($data['options_id']) > 0) {
                $result->optionsAdded()->delete();
                if ($data['options_id'] != null) {
                    foreach ($data['options_id'] as $option) {
                        $add_data = [
                            'option_groups_id'   => $result->id,
                            'options_id'  =>  $option
                        ];
                        $result->optionsAdded()->insert($add_data);
                    }
                }
            }
        }
        $message = trans('messages.update_form', ['form' => trans('messages.options')]);
        if ($result->wasRecentlyCreated) {
            $message = trans('messages.save_form', ['form' => trans('messages.options')]);
        }
        if ($request->is('api/*')) {
            return comman_message_response($message);
        }

        return redirect(route('option-groups.index'))->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (demoUserPermission()) {
            return  redirect()->back()->withErrors(trans('messages.demo_permission_denied'));
        }
        $option_groups = OptionGroups::find($id);
        $msg = __('messages.msg_fail_to_delete', ['name' => __('messages.option_groups')]);

        if ($option_groups != '') {
            $option_groups->delete();
            $msg = __('messages.msg_deleted', ['name' => __('messages.option_groups')]);
        }
        if (request()->is('api/*')) {
            return comman_message_response($msg);
        }
        return comman_custom_response(['message' => $msg, 'status' => true]);
    }
    public function action(Request $request)
    {
        $id = $request->id;

        $option_groups  = OptionGroups::withTrashed()->where('id', $id)->first();
        $msg = __('messages.not_found_entry', ['name' => __('messages.option_groups')]);
        if ($request->type == 'restore') {
            $option_groups->restore();
            $msg = __('messages.msg_restored', ['name' => __('messages.option_groups')]);
        }
        if ($request->type === 'forcedelete') {
            $option_groups->forceDelete();
            $msg = __('messages.msg_forcedelete', ['name' => __('messages.option_groups')]);
        }
        if (request()->is('api/*')) {
            return comman_message_response($msg);
        }
        return comman_custom_response(['message' => $msg, 'status' => true]);
    }
}
