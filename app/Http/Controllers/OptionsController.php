<?php

namespace App\Http\Controllers;

use App\DataTables\OptionsDataTable;
use App\Http\Requests\OptionsRequest;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Options;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OptionsDataTable $dataTable)
    {
        $pageTitle = trans('messages.list_form_title', ['form' => trans('messages.options')]);
        $auth_user = authSession();
        $assets = ['datatable'];
        return $dataTable->render('options.index', compact('pageTitle', 'auth_user', 'assets'));
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

        $options = Options::find($id);
        $pageTitle = trans('messages.update_form_title', ['form' => trans('messages.options')]);

        if ($options == null) {
            $pageTitle = trans('messages.add_button_form', ['form' => trans('messages.options')]);
            $options = new Options;
        }

        return view('options.create', compact('pageTitle', 'options', 'auth_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OptionsRequest $request)
    {
        if (demoUserPermission()) {
            return  redirect()->back()->withErrors(trans('messages.demo_permission_denied'));
        }
        $data = $request->all();

        $data['is_featured'] = 0;
        if ($request->has('is_featured')) {
            $data['is_featured'] = 1;
        }
        $result = Options::updateOrCreate(['id' => $data['id']], $data);


        $message = trans('messages.update_form', ['form' => trans('messages.options')]);
        if ($result->wasRecentlyCreated) {
            $message = trans('messages.save_form', ['form' => trans('messages.options')]);
        }
        if ($request->is('api/*')) {
            return comman_message_response($message);
        }
        return redirect(route('options.index'))->withSuccess($message);
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
        $options = Options::find($id);
        $msg = __('messages.msg_fail_to_delete', ['name' => __('messages.options')]);

        if ($options != '') {
            $options->delete();
            $msg = __('messages.msg_deleted', ['name' => __('messages.options')]);
        }
        if (request()->is('api/*')) {
            return comman_message_response($msg);
        }
        return comman_custom_response(['message' => $msg, 'status' => true]);
    }
    public function action(Request $request)
    {
        $id = $request->id;

        $options  = Options::withTrashed()->where('id', $id)->first();
        $msg = __('messages.not_found_entry', ['name' => __('messages.options')]);
        if ($request->type == 'restore') {
            $options->restore();
            $msg = __('messages.msg_restored', ['name' => __('messages.options')]);
        }
        if ($request->type === 'forcedelete') {
            $options->forceDelete();
            $msg = __('messages.msg_forcedelete', ['name' => __('messages.options')]);
        }
        if (request()->is('api/*')) {
            return comman_message_response($msg);
        }
        return comman_custom_response(['message' => $msg, 'status' => true]);
    }
}
