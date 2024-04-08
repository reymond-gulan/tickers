@extends('layouts.app')
@section('content')
<div class="container-fluid bg-dark text-success p-1">
    <center><b class="text-sm" id="collect-data"></b></center>
</div>
<script>
function request(route, data, method = "POST")
{
    $.ajax({
        url:route,
        method:method,
        data:{
            ticker:data,
        },
        dataType:'json',
        beforeSend:function(){
            $('#collect-data').prepend('Receiving feeds --- ');
        },
        success:function(response){
            $('#collect-data').prepend(response);
        }
    });
}
    $(function(){
        $('.navbar').addClass('d-none');

        const url = "wss://stream.binance.com:9443/ws/";
        const rawStreams = "!ticker@arr";
        const ticker = "!ticker_1h@arr";
        const socket = new WebSocket(url + ticker);

        socket.onmessage = function (event) {
            var data = event.data;
            console.log(data);
            var route = '{{route("market-ticker")}}';
            request(route, data);
        };
    });
</script>
@endsection