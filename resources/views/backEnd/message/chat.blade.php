
<div class="chat_inner">
    <div class="chat_main_body">
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
</div>
 