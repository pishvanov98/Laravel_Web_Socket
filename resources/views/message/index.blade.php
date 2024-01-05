@extends('layouts.appNew')
@section('content')
<div>
    <div class="w-1/2 mx-auto py-2">
        <div class="mb-4">
            <input id="message" type="text" name="message" class="rounded-full border border-gray-400" placeholder="you message" >
        </div>
        <div class="mb-4">
            <button id="Send_btn" class="rounded-lg block w-48 bg-sky-400 text-white text-center py-2">Send</button>
        </div>
    </div>
    @if(isset($messages))
        <div class="w-1/2 mx-auto text-white py-2">
            <h3 class="py-2">Message</h3>
        </div>
        <div id="block_message" class="w-1/2 mx-auto text-white py-6">
            @foreach($messages as $message)
                <div class="text-sm pb-4 mb-4 border-b border-gray-300">
                    <p>{{$message->id}}</p>
                    <p>{{$message->body}}</p>
                    <p class="text-right">{{$message->created_at}}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('a07c9f36b2d06535ddf8', {
        cluster: 'eu'
    });

    var channel = pusher.subscribe('store_message');
    channel.bind('store_message', function(data) {
        var dataWebSocketUser=JSON.stringify(data['user']);

        if(dataWebSocketUser == {{$user}}) {// если это текущий пользователь веб сокет не будет обновлять
            return;
        }

            var dataWebSocketId=JSON.stringify(data['message']['id']);
            var dataWebSocketBody=JSON.stringify(data['message']['body']);
            dataWebSocketBody = dataWebSocketBody.replace(/^"|"$/g, '');
            var dataWebSocketTime=JSON.stringify(data['time']);
            dataWebSocketTime = dataWebSocketTime.replace(/^"|"$/g, '');

            $('#block_message').prepend('<div class="text-sm pb-4 mb-4 border-b border-gray-300"><p>'+dataWebSocketId+'</p><p>'+dataWebSocketBody+'</p><p class="text-right">'+dataWebSocketTime+'</p></div>');

    });



</script>
    <script>


        $('#Send_btn').on('click',function (){

            var message=$('#message').val();

            $.ajax({
                url: "{{route('message.store')}}",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    message:message,
                },
                success:function(data){
                    $('#message').val('');
                    $('#block_message').prepend('<div class="text-sm pb-4 mb-4 border-b border-gray-300"><p>'+data['id']+'</p><p>'+data['body']+'</p><p class="text-right">'+data['time']+'</p></div>');
                },
            });

        });




    </script>

@endsection
