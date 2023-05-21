
<?php
    $auth_user= authSession();
?>
{{ Form::open(['route' => ['option_groups.destroy', $option_groups->id], 'method' => 'delete','data--submit'=>'option_groups'.$option_groups->id]) }}
<div class="d-flex justify-content-end align-items-center">
    @if(!$option_groups->trashed())


        @if($auth_user->can('option_groups delete'))
        <a class="mr-3" href="{{ route('option_groups.destroy', $option_groups->id) }}" data--submit="option_groups{{$option_groups->id}}" 
            data--confirmation='true' 
            data--ajax="true"
            data-datatable="reload"
            data-title="{{ __('messages.delete_form_title',['form'=>  __('messages.option_groups') ]) }}"
            title="{{ __('messages.delete_form_title',['form'=>  __('messages.option_groups') ]) }}"
            data-message='{{ __("messages.delete_msg") }}'>
            <i class="far fa-trash-alt text-danger"></i>
        </a>
        @endif
    @endif
    @if(auth()->user()->hasAnyRole(['admin']) && $option_groups->trashed())
        <a href="{{ route('option_groups.action',['id' => $option_groups->id, 'type' => 'restore']) }}"
            title="{{ __('messages.restore_form_title',['form' => __('messages.option_groups') ]) }}"
            data--submit="confirm_form"
            data--confirmation='true'
            data--ajax='true'
            data-title="{{ __('messages.restore_form_title',['form'=>  __('messages.option_groups') ]) }}"
            data-message='{{ __("messages.restore_msg") }}'
            data-datatable="reload"
            class="mr-2">
            <i class="fas fa-redo text-secondary"></i>
        </a>
        <a href="{{ route('option_groups.action',['id' => $option_groups->id, 'type' => 'forcedelete']) }}"
            title="{{ __('messages.forcedelete_form_title',['form' => __('messages.option_groups') ]) }}"
            data--submit="confirm_form"
            data--confirmation='true'
            data--ajax='true'
            data-title="{{ __('messages.forcedelete_form_title',['form'=>  __('messages.option_groups') ]) }}"
            data-message='{{ __("messages.forcedelete_msg") }}'
            data-datatable="reload"
            class="mr-2">
            <i class="far fa-trash-alt text-danger"></i>
        </a>
    @endif
</div>
{{ Form::close() }}