@extends('layouts.app')
@section('content')
<style>
    body{
        background:#111 !important;
        overflow-y:hidden;
    }
    #list-container {
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        transform: rotate(-90deg);
        margin-left:-1230px;
        margin-top:300px;
    }
    .toggle-mobile, .toggle-settings{
        display:none;
    }
</style>
<div class="container-fluid">
    <div class="col-sm-12 stickyp-0 mt-4">
        <!--- BODY *** start *** -->
        <form action="" method="POST" id="form2">
            @csrf
            <div class="row p-1 my-0 justify-content-center">
                <div class="col-sm-2 p-0">
                    <select type="text" class="form symbol border border-dark" name="symbol" id="symbol-filter">
                        <option value="USDT" selected>USDT</option>
                        <option value="BTC">BTC</option>
                        <option value="SOL">SOL</option>
                        <option value="BNB">BNB</option>
                        <option value="TUSD">TUSD</option>
                        <option value="ALL">ALL</option>
                    </select>
                </div>
                <div class="col-sm-2 p-0">
                    <input type="hidden" id="status" readonly>
                    <button type="submit" class="btn btn-primary w-100 h-100 text-sm rounded-1 p-0" id="search">SEARCH</button>
                    <button type="button" class="btn btn-primary w-100 h-100 text-sm rounded-1 d-none" id="start">START</button>
                </div>
                <div class="col-sm-2 p-0">
                    <button type="button" class="btn btn-warning w-100 h-100 text-sm rounded-1 p-0" id="restart">RESTART</button>
                </div>
                <div class="col-sm-2 p-0">
                    <button type="button" class="btn btn-danger w-100 h-100 text-sm rounded-1 p-0" id="reload">RELOAD</button>
                </div>
            </div>
        </form>
    </div>
    <!--- BODY *** end *** -->

    <div class="row">
        <div class="col-sm-12">
            <div class="feed-status text-white"></div>
            <div id="list-container"></div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('[data-toggle="popover"]').popover();
        const url = "wss://stream.binance.com:9443/ws/";
        const ticker = "!ticker_1h@arr";
        const socket = new WebSocket(url + ticker);

        socket.addEventListener("error", (event) => {
            $('.feed-status').html("Connection cannot be established...");
        });

        socket.onmessage = function (event) {
            var data = JSON.parse(event.data);
            var status = $('#status').val();
            if (status == 'start') {
                $.each(data, function(i, e){
                    $('#symbol-'+e.s+'-current-price').html(e.h);
                    var html = "";

                    if (parseFloat(e.P) < 0) {
                        var change = (parseFloat(e.P));
                        html += '<p class="bg-red button symbol token-display"\
                                        data-symbol="'+e.s+'"\
                                        style="width:'+Math.abs(change)+'%;max-width:100%; font-size:3px;"\
                                        data-toggle="popover"\
                                        data-content="'+e.s+'"\
                                        data-trigger="focus"\
                                        data-placement="left"><span class="badge badge-negative"></span></p>';
                        $('#symbol-'+e.s+'-negative').html(html);
                    } else {
                        var change = (parseFloat(e.P));
                        html += '<p class="bg-success button symbol token-display"\
                                        data-symbol="'+e.s+'"\
                                        style="width:'+change+'%;max-width:100%; font-size:3px;"\
                                        data-toggle="popover"\
                                        data-content="'+e.s+'"\
                                        data-trigger="focus" data-placement="right"><span class="badge badge-positive"></span></p>';
                        $('#symbol-'+e.s+'-positive').html(html);
                    }
                });
            }
        };

        $(document).on('click', '#start', function(e){
            e.preventDefault();
            $('#status').val('start');
        });

        $(document).on('click', '#toggle-settings', function(){
            var panel = $('#settings-form');
            var panel2 = $('#form2');
            var nav = $('.navbar .container');

            if (panel.hasClass('d-none')) {
                panel.removeClass('d-none');
            } else {
                panel.addClass('d-none');
            }

            if (panel2.hasClass('d-none')) {
                panel2.removeClass('d-none');
            } else {
                panel2.addClass('d-none');
            }

            if (nav.hasClass('d-none')) {
                nav.removeClass('d-none');
            } else {
                nav.addClass('d-none');
            }
        });

        $(document).on('submit', '#form2', function(e){
            e.preventDefault();

            $('#search').html('Processing...');
            $('#search').attr('disabled', true);
            var symbol = $('select[name="symbol"]').val();
            $('#symbol').val(symbol);
            $.ajax({
                url:'{{route("coins-list-mobile")}}',
                method:'GET',
                data:{
                    symbol:symbol
                },
                success:function(response){
                    $('#list-container').html(response);
                    $('#search').html('SEARCH');
                    $('#search').attr('disabled', false);
                    $('#start').trigger('click');
                }, error:function(response){
                    alert("An error occurred. Re-submit request.");
                    $('#search').html('SEARCH');
                    $('#search').attr('disabled', false);
                }
            });
        });

        $(document).on('click', '.token-display', function(){
            var token = $(this).data('symbol');
            window.open('https://www.binance.com/en/trade/'+token+'?type=spot');
        });

        $(document).on('click', '#restart', function(){
            $('#form2').trigger('submit');
        });

        $(document).on('click', '#reload', function(){
            location.reload();
        });
    });
</script>
@endsection