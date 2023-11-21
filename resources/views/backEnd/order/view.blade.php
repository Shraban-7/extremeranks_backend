@extends('backEnd.layouts.master')
@section('title','Order Manage')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>


    .image-upload {
        position: relative !important;
    }
    
   .image-frame {
      display: inline-block;
      margin-right: 10px;
      position: relative;
    }
    
    .close-button {
      position: absolute;
      top: -10px;
      right: -10px;
      background-color: #fff;
      color: #ff0000;
      border-radius: 50%;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      width: 20px;
      height: 20px;
      line-height: 1;
      text-align: center;
      padding: 0;
      border: 1px solid #ff0000;
    }
    div#frames {
        position: absolute;
        top: -75px;
    }
    
.chat-file {
    background: #2389FD;
    border-radius: 5px;
    margin-top: 5px;
    padding: 8px 8px;
    text-align: left;
    display: grid;
    grid-template-columns: 70px 1fr;
}

.chat-file a {
    background: #fff;
    padding: 4px 10px;
    border-radius: 5px;
    font-size: 12px;
    cursor:pointer;
}
.file-name p {
    color: #fff;
    font-style: italic;
    font-size: 12px;
    margin-bottom: 5px;
}
.chat-file img {
    height: 50px;
    width: 50px;
    border: 1px solid #67c3f9;
    border-radius: 5px;
    margin-right: 7px;
}

.paid_btn {
    text-align: right;
}
</style>
@endsection
@section('content')
<div class="container-fluid">
   <div class="row cust_col_p">
       
      
    <div class="col-sm-8">
        
        <div class="card cust_card">
            
            <div class="card_head card_p">
            <div class="card_top">
                <div class="card_head_widget">
                    <p class="head_t">Order Activities</p>
                </div>
                <div class="card_head_widget text_right">
                </div>
            </div>
           </div>
            <div class="card-body">
                <div class="order_info_inner">
                    <div class="order_list">
                        <div class="cust_info">
                               <img src="{{asset($orderInfo->customer?$orderInfo->customer->image:'')}}" class="backend-image sm_img" alt="">
                                <p>{{$orderInfo->customer?$orderInfo->customer->fullName:''}}</p>
                        </div>
                    </div>
                    <div class="order_list">
                        <div class="status_inner">
                            <p>Status</p>  
                            <span class="inprogess" style="background:{{$orderInfo->ordertype?$orderInfo->ordertype->bg:''}}">{{$orderInfo->ordertype?$orderInfo->ordertype->name:''}}</span>
                        </div>
                    </div>
                    <div class="order_list">
                        <div class="status_inner">
                            <p>Price</p>  
                            <p class="order_price">${{$orderInfo->total}}</p>
                        </div>
                    </div>
                </div>

                <div class="order_d_according">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header cust_according_head" id="headingOne">
                        
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <div class="acc_img">
                           <img src="{{asset('public/backend')}}/assets/images/all_inbox.png" class="" alt="">
                        </div>
                        Order Requirement Details Here
                        </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Service/Package</td>
                                        <td>Price</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orderDetails as $key=>$value)
                                    <tr>
                                        <td> {{$value->category?$value->category->category_name:'Custom'}} - {{$value->package_name}}</td>
                                        <td>
                                            <p class="order_price">${{$value->price}}</p>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header cust_according_head" id="headingTwo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#chat" aria-expanded="true" aria-controls="collapseOne">
                        <div class="acc_img">
                           <img src="{{asset('public/backend')}}/assets/images/mark_chat_unread.png" class="" alt="">
                        </div>
                        Your Recent Inbox Conversations
                        </button>
                        </h2>
                        <div id="chat" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body chat_body">
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
                           <div id="chatting-list">
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
                                        <input type="hidden" name="order_id" value="{{$orderInfo->id}}">
                                        <button type="submit"><img src="{{asset('public/backend/assets/images/paper-plan.png')}}" alt=""></button>
                                    </div>
                                    <div class="form-group">
                                        <a href="{{route('createinvoice',['customer_id'=>$customerInfo->id])}}" target="_blank" class="chat_btn">Custom Order</a>
                                    </div>
                                </form>
                             </div> 
                         </div>
                     </div>
                    </div>
                    
                    
                    
                    
                 </div>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
        
        <div class="card cust_card">
            <div class="card_head_blue card_p">
            <div class="card_top card_top_2">
                <div class="card_head_widget">
                    <p class="head_t text-white">Delivery File</p>
                </div>
            </div>
           </div>
           
            <div class="timer_text">
                <p>When Complete your project then upload your project file.</p>
            </div>
            
            <div class="modal-body deliver_des" style="padding:10px;">
               <form action="{{route('deliveryfile_save')}}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <input type="hidden" value="{{$orderInfo->customer_id}}" name="customer_id">
                <input type="hidden" value="{{$orderInfo->id}}" name="id">
                
                <div class="form-group mb-3">
                    <label for="projectfile">Note</label>
                    <textarea name="note" class="summernote form-control"></textarea>
                </div>
                
                <div class="form-group mb-3">
                    <label for="projectfile">Project File</label>
                    <input type="file" name="projectfile" id="projectfile" class="form-control" required>
                    @error('delivery')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                 
                
                 <div class="form-group mb-3">
                    
                    <input type="checkbox" name="article_approval" id="final_delivery">
                    <label for="final_delivery">Is it final delivery?</label>
                    @error('final_delivery')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ final_delivery }}</strong>
                        </span>
                    @enderror
                </div>
                
                
                <div class="form-group mb-3">
                    <button class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
            
        </div> <!-- end card -->
           
           
            
            
        
    </div><!-- end col-->

    <div class="col-sm-4">
        <div class="card cust_card">
            <div class="card_head card_p">
            <div class="card_top card_top_2">
                <div class="card_head_widget">
                    <p class="head_t">Time Left To Deliver</p>
                </div>
                <div class="card_head_widget text_right">
                    
                </div>
            </div>
           </div>

            <div class="card-body">
                <div class="cust_itmer_inner" id="simple_timer"></div>
            </div> <!-- end card body-->
            <div class="timer_text">
                <p>There are many variations seo agenci of passages of messeng Lorem Ipsum available, on to but the majority have suffered alteration in some form</p>
                <a  class="text-white anchor" data-bs-toggle="modal" data-bs-target="#custom_modal">Extend Delivery Date </a>
            </div>
        </div> <!-- end card -->

        <div class="card cust_card">
            <div class="card_head card_p">
            <div class="card_top card_top_2">
                <div class="card_head_widget">
                    <p class="head_t">Order Details</p>
                </div>
                <div class="card_head_widget text_right">
                    
                </div>
            </div>
           </div>
            <div class="card-body">
                 <div class="order_details_inner">
                    <div class="d_item">
                        <div class="d_widget_left">
                           <p>Ordered By <span>:</span></p>
                        </div>
                        <div class="d_widget_right">
                           <p class="orderBy">{{$orderInfo->customer->fullName}}</p>
                        </div>
                    </div>
                    <div class="d_item">
                        <div class="d_widget_left">
                           <p>Delivery Date <span>:</span></p>
                        </div>
                        <div class="d_widget_right">
                           <p>  {{ date('d M,y h:i A', strtotime($orderInfo->delivery_date))}} </p>
                        </div>
                    </div>
                    <div class="d_item">
                        <div class="d_widget_left">
                           <p>Total Price <span>:</span></p>
                        </div>
                        <div class="d_widget_right">
                           <p class="order_d_p">${{$orderInfo->total}}</p>
                        </div>
                    </div>
                    <div class="d_item">
                        <div class="d_widget_left">
                           <p>Order Number <span>:</span></p>
                        </div>
                        <div class="d_widget_right">
                           <p># {{$orderInfo->order_id}}</p>
                        </div>
                    </div>

                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
        
        
        @if(auth()->user()->hasRole('Superadmin'))
        <div class="card cust_card">
            <div class="card_head card_p">
            <div class="card_top card_top_2">
                <div class="card_head_widget">
                    <p class="head_t">Asign Conversetion</p>
                </div>
            </div>
           </div>
            <div class="timer_text">
                <p>If you need to transfer support to another user for better service you can asign it.</p>
                <a  class="text-white anchor" data-bs-toggle="modal" data-bs-target="#asign_modal">Asign To Admin</a>
            </div>
        </div> <!-- end card -->
        @endif
        
        
        
        
     </div>
   </div>
</div>

<!-- Extend Delivery modal -->
<div class="modal fade" id="custom_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Extend Delivery Date</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form action="{{route('order.delivery_extende')}}" method="POST">
                @csrf
                <input type="hidden" value="{{$orderInfo->id}}" name="order_id">
                <div class="form-group mb-3">
                    <label for="">Select Date</label>
                    <input type="text" value="{{$orderInfo->orderdetail->delivery}}" class="custom_date form-control" name="delivery" placeholder="2023-07-20">
                    @error('delivery')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Asign user modal -->

<div class="modal fade" id="asign_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">You can asign user</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form action="{{route('order_asign')}}" method="POST">
                @csrf
                <input type="hidden" value="{{$orderInfo->order_id}}" name="order_id">
                <input type="hidden" value="{{$orderInfo->id}}" name="id">
                <div class="form-group mb-3">
                    <label for="">Select Admin</label>
                    <select  class="select2 form-control" name="admin_id">
                        @foreach($asign_users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                    @error('delivery')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





@endsection

@section('script')
<script>
var countDownDate = new Date("{{date('M d,Y h:i:s', strtotime($orderInfo->delivery_date))}}").getTime();
var x = setInterval(function() {
  var now = new Date().getTime();
  var distance = countDownDate - now;
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  document.getElementById("simple_timer").innerHTML = "<div class='timer_item'> <h4>" + days + "</h4>"+ "<p>days</p> </div>" +"<div class='timer_item'> <h4>" + hours + "</h4>"+ "<p>hours</p> </div>"  +"<div class='timer_item'> <h4>" + minutes + "</h4>"+ "<p>minutes</p> </div>" + "<div class='timer_item'> <h4>" + seconds + "</h4>"+ "<p>seconds</p> </div>" ;
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("simple_timer").innerHTML = "EXPIRED";
    $(".cust_itmer_inner").addClass('expired');
  }
}, 1000);
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr(".custom_date", {});
</script>

<script>
    function fetchData() {
        var order_id = `{{$orderInfo->id}}`;
        $.ajax({
            type: "GET",
            data: {order_id: order_id },
            url: "{{route('messages')}}",
            success: function (messages) {
                if (messages) {
                    scrollToBottom();
                    $("#chatting-list").html(messages);
                } else {
                    $("#chatting-list").empty();
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
      $('#chatting-list').scrollTop($('#chatting-list')[0].scrollHeight);
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
@endsection