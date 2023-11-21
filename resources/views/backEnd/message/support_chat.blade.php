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
#chatting-list2 {
    background: #F6F6F6;
    max-height: 100vh;
    overflow-y: scroll;
}

#chatting-list2::-webkit-scrollbar {
    width: 0px;
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
                               <img src="{{asset($customer->image)}}">  @if($customer->unreadmessages_count > 0)<span>{{$customer->unreadmessages_count}}</span> @endif
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
           <div class="chat_body">
                <div class="chat_top_customer">
                    <div class="chat_top_cust_info">
                        <div class="c_img">
                            <img src="{{asset($customerInfo->image)}}" alt="">
                        </div>

                        <div class="c_name_info">
                             <p>{{$customerInfo->fullName}}</p>
                             <span>Last seen {{$last_seen}}</span>
                        </div>
                    </div>
                </div>
               <div id="chatting-list2">
                   @foreach($messages as $message)
                     <div class="chat_item">
                        @if($message->sender=='admin')
                        <div class="chat_right">
                            <div class="chat">
                                @if($message->message)
                                <div class="chat-box">
                                    <p>{{$message->message}}</p>
                                </div>
                                @endif
                                @if($message->file)
                                <div class="chat-file">
                                    <div class="file-img">
                                       <img src="{{asset('public/backend/assets/images/backup.png')}}">
                                    </div>
                                    <div class="file-name">
                                       <p>{{$message->file_name}}</p>
                                       <a href="{{asset($message->file)}}" download="{{asset($message->file)}}">Download Now</a>
                                    </div>
                                </div>
                                @endif
                                <div class="chat-time">
                                    <p>{{$message->created_at->format('Y-m-d H:i A')}}</p>
                                </div>
                            </div>
                            <div class="image">
                                <img src="{{asset($message->user?$message->user->image:'')}}" alt="">
                            </div>
                        </div>
                        @else
                        <div class="chat_left">
                            <div class="image">
                                <img src="{{asset($message->customer?$message->customer->image:'')}}" alt="">
                            </div>
                            <div class="chat">
                                @if($message->message)
                                <div class="chat-box">
                                    <p>{{$message->message}}</p>
                                </div>
                                 @endif
                                @if($message->file)
                                <div class="chat-file">
                                    <div class="file-img">
                                       <img src="{{asset('public/backend/assets/images/backup.png')}}">
                                    </div>
                                    <div class="file-name">
                                       <p>{{$message->file_name}}</p>
                                       <a href="{{asset($message->file)}}" download="{{asset($message->file)}}">Download Now</a>
                                    </div>
                                </div>
                                @endif
                                <div class="chat-time">
                                    <p>{{$message->created_at->format('Y-m-d H:i A')}}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                     </div>
                    @endforeach
               </div>
                 <div class="message_form">
                    <form id="send_message" enctype="multipart/form-data">
                         {{csrf_field()}}
                        <div class="form-group">
                            
                            <div class="image-upload">
                                <div id="frames"></div>
                              <label for="file-input">
                                <img src="{{asset('public/backend/assets/images/file-upload.png')}}" style="pointer-events: none;"/>
                              </label>
                              <input id="file-input" name="file" type="file"/>
                            </div>
                        </div>
                        <div class="form-group message_input">
                            <input type="text" required class=" form-control" placeholder="Type something..."  name="message">
                            <input type="hidden" name="customer_id" value="{{$customerInfo->id}}">
                            <input type="hidden" name="order_id" value="">
                            <button type="submit"><img src="{{asset('public/backend/assets/images/paper-plan.png')}}" alt=""></button>
                        </div>
                        <div class="form-group">
                            <a href="{{route('createinvoice',['customer_id'=>$customerInfo->id])}}" target="_blank" class="chat_btn">Custom Order</a>
                        </div>
                    </form>
                 </div> 
             </div>
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>
@endsection

@section('script')
<script>
    function fetchData() {
        var order_id = `0`;
        var customer_id = `{{$customerInfo->id}}`;
        $.ajax({
            type: "GET",
            data: {order_id: order_id,customer_id:customer_id },
            url: "{{route('messages')}}",
            success: function (messages) {
                if (messages) {
                    scrollToBottom();
                    $("#chatting-list2").html(messages);
                } else {
                    $("#chatting-list2").empty();
                }
            },
        });
    } 
    setInterval(fetchData, 4000); 
    $('#send_message').on('submit', function(event) {
      event.preventDefault();
      var form = this;
      var formData = new FormData(form);
      $.ajax({
        url: "{{route('message_send')}}",
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
        $('#send_message')[0].reset();
        $('.image-frame').remove();
        return fetchData();
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      });
    });
    function scrollToBottom() {
      $('#chatting-list2').scrollTop($('#chatting-list2')[0].scrollHeight);
    }
</script>
<script>
  $(document).ready(function() {
  $('#file-input').change(function() {
    $("#frames").html('');
    for (var i = 0; i < $(this)[0].files.length; i++) {
      var imageURL = window.URL.createObjectURL(this.files[i]);
      var imageElement = $('<img/>', {
        src: imageURL,
        width: "45px",
        height: "45px"
      });

      var closeButton = $('<span/>', {
        class: "close-button",
        html: "&times;",
        "data-url": imageURL
      });

      var frame = $('<div/>', {
        class: "image-frame"
      }).append(imageElement).append(closeButton);

      $("#frames").append(frame);
    }
  });

  $(document).on('click', '.close-button', function() {
    var imageURL = $(this).data('url');
    $(this).closest('.image-frame').remove();
    window.URL.revokeObjectURL(imageURL);
  });
});
</script>
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