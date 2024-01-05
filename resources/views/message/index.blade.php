@extends('layouts.appNew')
@section('content')
<div>
    <div class="w-1/2 mx-auto">
        <div class="mb-4">
            <input id="message" type="text" name="message" class="rounded-full border border-gray-400" placeholder="you message" >
        </div>
        <div class="mb-4">
            <button id="Send_btn" class="rounded-lg block w-48 bg-sky-400 text-white text-center py-2">Send</button>
        </div>
    </div>
    @if(isset($messages))
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
                    alert('success');

                    $('#block_message').prepend('<div class="text-sm pb-4 mb-4 border-b border-gray-300"><p>'+data['id']+'</p><p>'+data['body']+'</p><p class="text-right">'+data['time']+'</p></div>');
                },
            });

        });




    </script>

@endsection
