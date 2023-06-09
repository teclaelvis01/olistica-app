<x-master-layout>
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold">{{ $pageTitle ?? trans('messages.list') }}</h5>
                            @if($auth_user->can('option_groups list'))
                                <a href="{{ route('option-groups.index') }}" class="float-right btn btn-sm btn-primary"><i class="fa fa-angle-double-left"></i> {{ __('messages.back') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::model($option_groups,['method' => 'POST','route'=>'option-groups.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'option_groups'] ) }}
                            {{ Form::hidden('id') }}
                            <div class="row">
                                <div class="form-group col-md-4">
                                    {{ Form::label('name',trans('messages.name').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                    {{ Form::text('name',old('name'),['placeholder' => trans('messages.name'),'class' =>'form-control','required']) }}
                                    <small class="help-block with-errors text-danger"></small>
                                </div>

                                {{-- <div class="form-group col-md-4">
                                    {{ Form::label('name', __('messages.select_name',[ 'select' => __('messages.category') ]).' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                    <br />
                                    {{ Form::select('category_id', [optional($subcategory->category)->id => optional($subcategory->category)->name], optional($subcategory->category)->id, [
                                            'class' => 'select2js form-group category',
                                            'required',
                                            'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.category') ]),
                                            'data-ajax--url' => route('ajax-list', ['type' => 'category']),
                                        ]) }}
                                    
                                </div> --}}
                                
                                {{-- <div class="form-group col-md-4">
                                    {{ Form::label('status',trans('messages.status').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                    {{ Form::select('status',['1' => __('messages.active') , '0' => __('messages.inactive') ],old('status'),[ 'id' => 'role' ,'class' =>'form-control select2js','required']) }}
                                    <small class="help-block with-errors text-danger"></small>
                                </div> --}}


                             
                                
                                {{-- <div class="form-group col-md-12">
                                    {{ Form::label('description',trans('messages.description'), ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('description', null, ['class'=>"form-control textarea" , 'rows'=>3  , 'placeholder'=> __('messages.description') ]) }}
                                </div> --}}
                                <div class="form-group col-md-4">
                                {{ Form::label('name', __('messages.select_name',[ 'select' => __('messages.options') ]).' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                <br />
                                @php
                                $assigned_option = $option_groups->optionsAdded->mapWithKeys(function ($item) {
                                return [$item->options_id => optional($item->options)->name];
                                });
                                @endphp
                                {{ Form::select('options_id[]', $assigned_option, $option_groups->optionsAdded->pluck('options_id'), [
                                            'class' => 'select2js form-group options',
                                            'required',
                                            'multiple' => 'multiple',
                                            'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.options') ]),
                                            'data-ajax--url' => route('ajax-list', ['type' => 'options']),
                                        ]) }}
                            </div>
                            </div>
                            {{ Form::submit( trans('messages.save'), ['class'=>'btn btn-md btn-primary float-right']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>