@foreach($options as $option )
<span class="badge badge-info">{{$option->name}}</span>
@endforeach
@if($has_more)
<span class="badge badge-info">...</span>
@endif