@extends('backEnd.layouts.master')
@section('title','Support list')
@section('css')
<style>
.support_customer {
    max-height: 100vh;
    overflow-y: scroll;
}
.support_customer::-webkit-scrollbar {
    width: 5px;
}
.support_customer::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 5px; 
}
.support_customer {
    scrollbar-width: thin;
}
.support_customer::-moz-scrollbar-thumb {
    background-color: #888; 
    border-radius: 5px;
}
.support_customer ul li a {
    display: grid;
    grid-template-columns: 50px auto;
    grid-gap: 15px;
    padding: 8px 8px;
    border-bottom: 1px solid #ddd;
    color: #222;
    align-items: center;
}

.support_customer ul li a img {
    width: 50px;
    height: 50px;
    border-radius: 50px;
}

.support_customer ul li {
    list-style: none;
    position:relative;
}

.support_customer ul li span {
    position: absolute;
    top: 4px;
    left: 47px;
    background: #FF4444;
    height: 15px;
    width: 15px;
    line-height: 15px;
    color: #fff;
    font-size: 12px;
    text-align: center;
    border-radius: 50px;
}
.support_customer ul {
    margin: 0;
    padding: 0;
}
</style>
@endsection
@section('content')
<div class="container-fluid">
   <div class="row cust_col_p">
       <div class="col-sm-4">
        <div class="card cust_card">
            <div class="card_head card_p">
            <div class="card_top card_top_2">
                <div class="card_head_widget">
                    <p class="head_t">Support Customer</p>
                </div>
            </div>
           </div>
            <div class="card-body">
               <div class="support_customer unread_supportmsg">
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
               </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
     </div>
    <div class="col-sm-8">
        <div class="card cust_card">
            <div class="card_head card_p">
            <div class="card_top">
                <div class="card_head_widget">
                    <p class="head_t">Support Message</p>
                </div>
                <div class="card_head_widget text-center">
                   
                </div>
            </div>
           </div>
            <div class="card-body text-center">
                 <p class="mt-3"><strong>No Message</strong></p>
                 <p>Start Conversetion</p>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>

<script>
        let refreshInterval;
        function startAutoRefresh() {
            refreshInterval = setInterval(fetchMessage, 2000);
        }
        function stopAutoRefresh() {
            clearInterval(refreshInterval);
        }
        function fetchMessage() {
            $.ajax({
                type: "GET",
                url: "{{ route('unread_supportmsg') }}",
                success: function (data) {
                    if (data) {
                        $(".unread_supportmsg").html(data);
                    } else {
                        
                    }
                },
            });
        }
        startAutoRefresh();
        $(".unread_supportmsg").mouseenter(stopAutoRefresh);
        $(".unread_supportmsg").mouseleave(startAutoRefresh);
    </script> 
@endsection