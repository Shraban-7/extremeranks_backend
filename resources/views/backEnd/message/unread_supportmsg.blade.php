<ul>
   @foreach($customers as $key=>$customer)
   <li>
       <a href="{{route('support_chat',['customer_id'=>$customer->id])}}">
           <img src="{{asset($customer->image)}}"> @if($customer->unreadmessages_count > 0)<span>{{$customer->unreadmessages_count}}</span> @endif
           <p>{{$customer->fullName}}</p>
       </a>
    </li>
    @endforeach
</ul>