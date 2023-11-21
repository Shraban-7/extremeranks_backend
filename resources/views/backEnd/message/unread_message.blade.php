 @if(auth()->user()->hasRole('Superadmin'))
    <li class="dropdown notification-list topbar-dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <img src="{{asset('public/backend')}}/assets/images/comment-customer.png" alt="" width="37">
           <span class="count_number">{{$ureadmessage->count()}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-lg">

            <!-- item-->
            <div class="dropdown-item noti-title">
                <h5 class="m-0">Uread Message
                </h5>
            </div>

            <div class="noti-scroll" data-simplebar>
                @foreach($ureadmessage as $umessage)
                <!-- item-->
                @if($umessage->order_id != null)
                <a href="{{url('admin/order/details/'.$umessage->order_id)}}" class="dropdown-item notify-item active">
                    <div class="notify-icon">
                        <img src="{{asset($umessage->customer->image)}}" class="img-fluid rounded-circle" alt="" /> </div>
                    <p class="notify-details">{{$umessage->customer->fullName}}</p>
                    <p class="text-muted mb-0 user-msg">
                        <small>{{$umessage->message}}</small>
                    </p>
                </a>
                @else
                <a href="{{url('admin/support/chat?order_id=0'.'&customer_id='.$umessage->customer_id)}}" class="dropdown-item notify-item active">
                    <div class="notify-icon">
                        <img src="{{asset($umessage->customer->image)}}" class="img-fluid rounded-circle" alt="" /> </div>
                    <p class="notify-details">{{$umessage->customer->fullName}}</p>
                    <p class="text-muted mb-0 user-msg">
                        <small>{{$umessage->message}}</small>
                    </p>
                </a>
                @endif
                @endforeach
            </div>

            <!-- All-->

        </div>
    </li>
    @else
    <li class="dropdown notification-list topbar-dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <img src="{{asset('public/backend')}}/assets/images/comment-customer.png" alt="" width="37">
           <span class="count_number">{{$asignureadmessage->count()}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-lg">

            <!-- item-->
            <div class="dropdown-item noti-title">
                <h5 class="m-0">Uread Message
                </h5>
            </div>

            <div class="noti-scroll" data-simplebar>
                @foreach($asignureadmessage as $asumessage)
                <!-- item-->
                <a href="{{url('admin/order/details/'.$asumessage->order_id)}}" class="dropdown-item notify-item active">
                    <div class="notify-icon">
                        <img src="{{asset($asumessage->customer->image)}}" class="img-fluid rounded-circle" alt="" /> </div>
                    <p class="notify-details">{{$asumessage->customer->fullName}}</p>
                    <p class="text-muted mb-0 user-msg">
                        <small>{{$asumessage->message}}</small>
                    </p>
                </a>
                @endforeach
            </div>

            <!-- All-->

        </div>
    </li>
    @endif
    
    @if(auth()->user()->hasRole('Superadmin'))
    <li class="dropdown notification-list topbar-dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <img src="{{asset('public/backend')}}/assets/images/bell-customer.png" alt="" width="30">
           <span class="count_number">{{$unreadnotifications->count()}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-lg">

            <!-- item-->
            <div class="dropdown-item noti-title">
                <h5 class="m-0">Uread Notification 
                </h5>
            </div>

            <div class="noti-scroll" data-simplebar>
                @foreach($unreadnotifications as $unotification)
                <!-- item-->
                <a href="{{url($unotification->link)}}" class="dropdown-item notify-item active">
                    <p class="text-muted mb-0 user-msg">
                        <small>{{$unotification->title}}</small>
                    </p>
                </a>
                @endforeach
            </div>

            <!-- All-->

        </div>
    </li>
    @else
    <li class="dropdown notification-list topbar-dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <img src="{{asset('public/backend')}}/assets/images/bell-customer.png" alt="" width="30">
           <span class="count_number">{{$asignunreadnotifications->count()}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-lg">

            <!-- item-->
            <div class="dropdown-item noti-title">
                <h5 class="m-0">Uread Notification 
                </h5>
            </div>

            <div class="noti-scroll" data-simplebar>
                @foreach($asignunreadnotifications as $asunotification)
                <!-- item-->
                <a href="{{url($asunotification->link)}}" class="dropdown-item notify-item active">
                    <p class="text-muted mb-0 user-msg">
                        <small>{{$asunotification->title}}</small>
                    </p>
                </a>
                @endforeach
            </div>

            <!-- All-->

        </div>
    </li>
    @endif