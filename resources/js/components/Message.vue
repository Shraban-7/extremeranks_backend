<template>
	<div class="chat_inner">
	    <div class="chat_top_customer">
	        <div class="chat_top_cust_info">
	            <div class="c_img">
	                <img :src="'/seoproject/'+customer.image" alt="">
	            </div>

	            <div class="c_name_info">
	                 <p>{{customer.fullName}}</p>
	                 <span>Last seen 2hr ago</span>
	            </div>
	        </div>
	    </div>
	    <div class="chat_main_body">
	         <div class="chat_item" v-for="message in messages">

	            <div class="chat_left" v-if="message.sender=='admin'">
	                <div class="image">
	                    <img src="/public/backEnd/assets/images/user.png" alt="">
	                </div>
	                <div class="chat">
	                	<div class="chat-box">
	                		<p>{{message.message}}</p>
	                	</div>
	                	<div class="chat-time">
	                		<p>{{message.created_at}}</p>
	                	</div>
	                </div>
	            </div>
	            <div class="chat_right" v-else>
	                <div class="chat">
	                	<div class="chat-box">
	                		<p>{{message.message}}</p>
	                	</div>
	                	<div class="chat-time">
	                		<p>{{message.created_at}}</p>
	                	</div>
	                </div>
	                <div class="image">
	                    <img src="/public/backEnd/assets/images/user.png" alt="">
	                </div>
	            </div>
	         </div>
	         <div class="message_form">
	         	<form @submit.prevent="send_message">
	         		<div class="form-group">
	         			<div class="image-upload">
						  <label for="file-input">
						    <img src="/public/backEnd/assets/images/file-upload.png" style="pointer-events: none"/>
						  </label>
						  <input id="file-input" type="file" />
						</div>
	         		</div>
	         		<div class="form-group message_input">
	         			<input type="text" class=" form-control" placeholder="Type something..."   v-model="messageForm.message">
	         			<input type="hidden" :value="messageForm.customer_id=customer.id">
	         			<input type="hidden" :value="messageForm.order_id=order_info.order_id">
	         			<img src="/public/backEnd/assets/images/paper-plan.png" alt="">
	         		</div>
	         		<div class="form-group">
	         			<button type="submit" class="chat_btn">Send Now</button>
	         		</div>
	         	</form>
	         </div>   
	    </div>
	</div>
</template>
<style>
	.chat_main_body {
	    background: #F3F5FA;
	}
	.chat_item {
	    padding: 15px 15px;
	}
	.chat_left {
	    display: grid;
	    grid-template-columns: 50px auto;
	}
	.image img {
	    width: 30px;
	    height: 30px;
	}
	.chat-box p {
	    margin: 0;
	}
	.chat-box {
	    background: #fff;
	    padding: 15px;
	    border-radius: 5px;
	}
	.chat-time {
	    margin-top: 6px;
	    font-size: 12px;
	}
	.chat_right {
	    display: grid;
	    grid-template-columns: auto 50px;
	    text-align: right;
	}
	.chat_right .chat-box {
	    background: #2389FD;
	    color: #fff;
	}
	.chat_btn {
	    background: linear-gradient(133.68deg, #FFA301 5.17%, #FF4444 94.13%);
	    color: #fff;
	    border: 0;
	    border-radius: 4px;
	    padding: 8px 10px;
	    width: 100%;
	}

	.message_form form {
	    display: grid;
	    grid-template-columns: 45px auto 120px;
	    grid-gap: 10px;
	    align-items: center;
	}
	.message_form {
	    padding: 10px 10px;
	}
	.image-upload > input {
	  visibility:hidden;
	  width:0;
	  height:0
	}
	.image-upload {
	    background: #fff;
	    text-align: center;
	    height: 40px;
	    line-height: 40px;
	    border-radius: 5px;
	    border: 1px solid #ddd;
	}
	.form-group.message_input {
	    display: grid;
	    grid-template-columns: auto 30px;
	    background: #fff;
	    border: 1px solid #ddd;
	    align-items: center;
	    border-radius: 5px;
	}
	.message_input input {
	    height: 40px;
	    border: none;
	}

</style>

<script>
	import axios from 'axios';
	import Form from 'vform'
	export default{
		props: ['customer','user','order_info'],
		data:() => ({
			messages : [],
			messageForm: new Form({
 				order_id: '',
 				message: '',
 				customer_id: '',
			})
		}),	
		methods:{
			loadMessage(){
				axios.get('admin/messages/'+this.order_info.order_id).then(response=>{
                    this.messages = response.data;
                    
                }); 
			},
			async send_message () {
		      const response = await this.messageForm.post('/admin/message/send').then(response=>{
			      	this.messageForm.message = '';
			      	this.messages = response.data;
			      })
		    },
		    
		},
		mounted(){
            setInterval(() => {
              this.loadMessage();
            }, 2000);
            // Echo.private('message-channel')
	        //   .listen('SendMessage', (e) => {
	        //     this.messages.push({
	        //       message: e.message.message,
	        //       user: e.user
	        //     });
	        // })
        }
	}
</script>