<div class="noty_item">
  <h2>Notifications</h2>
</div>
@if(auth()->user()->hasRole('Superadmin'))
@foreach($allnotifications as $key=>$value)
<div class="noty_item @if($value->status == 'unread') unread @endif">
  <a href="{{url($value->link)}}">
   <p> {{$value->title}}
    </p>
  <span>{{$value->created_at->diffForHumans()}}</span>
  </a>
</div>
@endforeach
@else
@foreach($asignallnotifications as $key=>$value)
<div class="noty_item @if($value->status == 'unread') unread @endif">
  <a href="{{url($value->link)}}">
   <p> {{$value->title}}
    </p>
  <span>{{$value->created_at->diffForHumans()}}</span>
  </a>
</div>
@endforeach
@endif