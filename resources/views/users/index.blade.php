@extends('layouts.appNew')
@section('content')
    <div>
        @if(isset($users))
            <div class="w-1/2 mx-auto text-white py-2">
                <h3 class="py-2">Пользователи</h3>
            </div>
            <div id="block_message" class="w-1/2 mx-auto text-white py-6">
                @foreach($users as $user)
                    <div class="text-sm pb-4 mb-4 border-b border-gray-300">
                        <p>{{$user->id}}</p>
                        <p>{{$user->name}}</p>
                        <p onclick="Like({{$user->id}})" class="text-right cursor-pointer">Поставить лайк</p>
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

        var channel = pusher.subscribe('send_like{{$user_id}}');
        channel.bind('send_like', function(data) {
            var dataWebSocket=JSON.stringify(data['message']);

            alert(dataWebSocket);

        });



    </script>

<script>

    function Like(id){
        $.ajax({
            url: "{{route('users.like')}}",
            type:"POST",
            data:{
                "_token": "{{ csrf_token() }}",
                id:id,
            },
            success:function(data){
                if(data == "success"){
                    alert("Успешно");
                }
            },
        });

    }

</script>

@endsection
