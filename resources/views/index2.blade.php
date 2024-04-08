@extends('layouts.app')
@section('content')
<div class="container-fluid w-100 bg-white">
    <div class="col-sm-12">
        <!--- BODY *** start *** -->
        <form action="{{ route('save-settings') }}" method="POST" id="settings-form">
        @csrf
        <div class="row mt-2">
            <div class="col-sm-4 p-2" style="background:#FBC6B1;">
                <table class="w-100 bg-transparent">
                    <tr>
                        <th colspan="3">PRE-QUALIFYING</th>
                        <th colspan="3">QUALIFYING</th>
                    </tr>
                    <tr>
                        <td><b><PRE-QUALIFYING/b></td>
                        <td class="w-25">
                            <input type="text" class="form border border-dark start_time" name="start_time">
                        </td>
                        <td>
                            <select name="start_time_unit" class="start_time_unit form border border-dark">
                                <option value="seconds">seconds</option>
                                <option value="minutes">minutes</option>
                                <option value="hours">hours</option>
                            </select>
                        </td>
                        <td><b></b></td>
                        <td class="w-25">
                            <input type="text" class="form border border-dark duration" name="duration">
                        </td>
                        <td>
                            <select name="duration_unit" class="duration_unit form border border-dark">
                                <option value="seconds">seconds</option>
                                <option value="minutes">minutes</option>
                                <option value="hours">hours</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-2 p-2" style="background:#FBC6B1;">
                <table class="w-100 bg-transparent">
                    <tr>
                        <th>PERCENTAGE QUALIFIER</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="number" class="form border border-dark percent_qualifier" name="percent_qualifier">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-1 p-2" style="background:#FBC6B1;">
                <table class="w-100 bg-transparent">
                    <tr>
                        <th>OPTION BLOCKS</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="number" class="form border border-dark options" name="options">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-3 p-2" style="background:#9294C2;">
                <table class="w-100 bg-transparent">
                    <tr>
                        <th colspan="6">LIVE PRICE AVERAGING (seconds)</th>
                    </tr>
                    <tr>
                        <td class="w-50">
                            <input type="number" class="form border border-dark live_averaging_time" name="live_averaging_time">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-2 p-0">
                <button type="submit" class="btn btn-success h-100 text-sm w-100 rounded-0" id="save-settings">SAVE SETTINGS</button>
            </div>
        </div>
        </form>
        <form action="{{ route('calculate') }}" method="POST" id="form2">
        @csrf
        <div class="row mt-2">
            <div class="col-sm-2 px-2">
                <select type="text" class="form symbol border border-dark" name="symbol" id="symbol-filter">
                    <option value="USDT" selected>USDT</option>
                    <option value="BTC">BTC</option>
                    <option value="SOL">SOL</option>
                    <option value="BNB">BNB</option>
                    <option value="TUSD">TUSD</option>
                    <option value="ALL">ALL</option>
                </select>
            </div>
            <div class="col-sm-1 p-0">
                <select type="text" class="form price_type border border-dark" name="price_type" id="price_type">
                    <option value="all">ALL</option>
                    <option value="above" selected>ABOVE</option>
                    <option value="below">BELOW</option>
                </select>
            </div>
            <div class="col-sm-2 p-0">
                <input type="text" class="form price_filter border border-dark" name="price_filter" id="price_filter" placeholder="PRICE FILTER">
            </div>
            <div class="col-sm-1 p-0 px-2 d-none">
                <input type="hidden" class="form text-sm symbol border border-dark" id="symbol" readonly>
                <input type="hidden" class="form text-sm symbol border border-dark" id="status" readonly>
            </div>
            <div class="col-sm-1 p-0">
                <button type="submit" class="btn btn-primary p-0 py-1 text-sm w-100" id="search" disabled>SEARCH</button>
            </div>
            <div class="col-sm-1 p-0">
                <button type="button" class="btn btn-success p-0 py-1 text-sm w-100" id="start">START <span id="elapsed"></span></button>
            </div>
            <div class="col-sm-1 p-0">
                <button type="button" class="btn btn-info p-0 py-1 text-sm w-100" id="reset">RESET</button>
            </div>
            <div class="col-sm-1 p-0">
                <button type="button" class="btn btn-danger p-0 py-1 text-sm w-100" id="stop">STOP</button>
            </div>
            <div class="col-sm-3  border border-dark">
            <div class="elapsed">
                <center>
                Time Elapsed <span class="badge badge-success bg-success" id="elapsed"></span>
                </center>
            </div>
            </div>
        </div>
        </form>
        <div class="row mt-2 d-none">
            <div class="col-sm-12">
                <center>
                <input type="radio" name="percentage_type" class="percentage_type" value="live" checked> Live Percentage Change &nbsp;&nbsp;&nbsp;
                <input type="radio" name="percentage_type" class="percentage_type" value="calculated"> Calculated Percentage Increase
                </center>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-12 custom d-none">
                <select class="custom-symbols" style="width:300px !important;" name="custom-symbol" id="custom-symbol">
                    @foreach($symbols as $symbol)
                        <option value="{{ $symbol['symbol'] }}">{{ $symbol['symbol'] }}</option>
                    @endforeach
                </select>
                
                <button type="button" class="btn btn-success add-custom-symbol">+</button>
            </div>
        </div>
        <div class="row mt-2 h5">
            <div class="col-sm-12">
                <p>
                    &bull; <span id="btc-label"></span><span id="btc"></span> 
                    &bull; <span id="eth-label"></span><span id="eth"></span> 
                    &bull; <span id="sol-label"></span><span id="sol"></span>
                    <span id="custom-symbols"></span>
                </p>
            </div>
        </div>
        <div id="list-container"></div>
    <!--- BODY *** end *** -->
    </div>
</div>
@if (!empty($setting))
<script>
$(function(){
@foreach($setting as $key => $value)
    @if (in_array($key, ['toggle_trades', 'toggle_volume', 'toggle_price']))
        $('.{{$key}}').attr('checked', true);
    @else
        $('.{{$key}}').val('{{$value}}');
    @endif
@endforeach
});
</script>
@endif
<script>

function volumePercentage(symbol, value)
{
    var volumeAverage = $('#symbol-'+symbol+'-volume-average');
    var average = volumeAverage.html();
    if (average !== "" && average !== undefined) 
    {
        var increase = percentageIncrease(new Number(average), value);
        volumeAverage.html(increase);
        var threshold = $('#volume-threshold').val();
        if (threshold === "") {
            console.log("1");
            if (new Number(increase) < 1) {
                $('#symbol-'+symbol).addClass('d-none');
            }
        } else {
            console.log("2");
            if (new Number(increase) < threshold) {
                $('#symbol-'+symbol).addClass('d-none');
            }
        }
    }
}


function percentageIncrease(initial = 0, final = 0)
{
    var difference = ((final - initial) / initial);
    var percentage = (difference * 100);

    if (percentage <= -100) {
        return 0;
    }

    return percentage.toFixed(2);
}

function getAverage(symbol, initial)
{
    var container = $('#symbol-'+symbol+'-live-price');
    var result = $(container).val().split(',');
    var count = 0;
    var value = 0;
    $.each(result, function(i, e){
        value += new Number(e);
        count += 1;
    });
    var final = (value / count);
    var increase = percentageIncrease(new Number(initial), new Number(final));

    var blocks = $('#block-count').val();

    for(i = 1; i <= blocks;)
    {
        if ($('#symbol-'+symbol+'-option'+i).html() == "") {
            var optionAverage = $('#symbol-'+symbol+'-option'+i);
            var previousBlock = (i - 1);
            var previous = $('#symbol-'+symbol+'-option'+previousBlock).html();
            if (i == 1) {
                optionAverage.removeClass('badge bg-success').removeClass('badge bg-danger');
            } else {
                if (parseFloat(increase) == 0) {
                    optionAverage.removeClass('badge bg-success').removeClass('badge bg-danger');
                } else if (parseFloat(previous) < parseFloat(increase)) {
                    optionAverage.addClass('badge bg-success').removeClass('bg-danger');
                } else if (parseFloat(previous) > parseFloat(increase)) {
                    optionAverage.removeClass('bg-success').addClass('badge bg-danger');
                } else {
                    optionAverage.removeClass('badge bg-success').removeClass('badge bg-danger');
                }
            }

            optionAverage.html(increase);
            break;
        }
        i++;
    }

    if ($('#symbol-'+symbol+'-live-price').val() !== "") {
        $('#symbol-'+symbol+'-live-price').val("");
    }
}

function collectValues(symbol, value) 
{
    var container = $('#symbol-'+symbol+'-live-price');
    var volume = container.val();

    if (volume != "") {
        container.val(volume+','+value);
    } else {
        container.val(value);
    }
}
    $(function(){

        $('.navbar .container').addClass('d-none');

        $(document).on('mouseenter', '.navbar', function(){
            $('.navbar .container').removeClass('d-none');
        });
        $(document).on('mouseleave', '.navbar', function(){
            $('.navbar .container').addClass('d-none');
        });


        const url = "wss://stream.binance.com:9443/ws/";
        const ticker = "!ticker_1h@arr";
        const socket = new WebSocket(url + ticker);

        socket.onmessage = function (event) {
            var data = JSON.parse(event.data);
            var status = $('#status').val();
            
            if (status == 'start') {
                $.each(data, function(i, e){

                    var price_filter = $('#price_filter').val();
                    var price_type = $('#price_type').val();
                    var custom = $('#custom-'+e.s);

                    if (custom.html() !== undefined) {
                        if (new Number(custom.html()) > e.c) {
                            custom.addClass('text-danger').removeClass('text-success');
                        } else {
                            custom.removeClass('text-danger').addClass('text-success');
                        }
                        custom.html(e.c);
                    }

                    if (price_filter !== '') {
                        var price = $('#symbol-'+e.s+'-price').html();
                        $('#symbol-'+e.s).removeClass('d-none');
                        if (price_type == 'above' && parseFloat(price) < parseFloat(price_filter)) {
                            $('#symbol-'+e.s).addClass('d-none');
                        } else if (price_type == 'below' && parseFloat(price) > parseFloat(price_filter)) {
                            $('#symbol-'+e.s).addClass('d-none');
                        }
                    }

                    if (e.s == 'BTCUSDT') { 
                        var btc = $('#btc').html();
                        if (new Number(btc) > e.c) {
                            $('#btc').addClass('text-danger').removeClass('text-success');
                        } else {
                            $('#btc').removeClass('text-danger').addClass('text-success');
                        }
                        $('#btc-label').html('BTC $');
                        $('#btc').html(e.c);
                    }

                    if (e.s == 'ETHUSDT') {
                        var eth = $('#eth').html(); 
                        if (new Number(eth) > e.c) {
                            $('#eth').addClass('text-danger').removeClass('text-success');
                        } else {
                            $('#eth').removeClass('text-danger').addClass('text-success');
                        }
                        $('#eth-label').html('ETH $');
                        $('#eth').html(e.c);
                    }

                    if (e.s == 'SOLUSDT') {
                        var sol = $('#sol').html();
                        if (new Number(sol) > e.c) {
                            $('#sol').addClass('text-danger').removeClass('text-success');
                        } else {
                            $('#sol').removeClass('text-danger').addClass('text-success');
                        }
                        $('#sol-label').html('SOL $');
                        $('#sol').html(e.c);
                    }
                    
                    if ($('#symbol-'+e.s+'-price').html() !== undefined && $('#symbol-'+e.s+'-price').html() == "") {
                        $('#symbol-'+e.s+'-price').html(e.c);
                    }
                    collectValues(e.s, e.c);
                });
                
                $('.sort').trigger('click');
            }
        };

        var interval, startTime, averaging;

        $(document).on('submit', '#form2', function(e){
            clearInterval(interval);
            clearInterval(averaging);

            e.preventDefault();
            $('#search').html('Processing...');
            $('#search').attr('disabled', true);
            var symbol = $('#symbol-filter').val();
            $('#symbol').val(symbol);
            $.ajax({
                url:'{{route("coins-list")}}',
                method:'GET',
                data:{
                    symbol:symbol
                },
                success:function(response){
                    $('#list-container').html(response);
                    $('#search').html('SEARCH');
                    $('#search').attr('disabled', false);
                    $('#start').removeClass('d-none');
                    $('#stop').removeClass('d-none');
                    $('#start').trigger('click');
                    $('.custom').removeClass('d-none');
                }, error:function(response){
                    alert("An error occurred. Re-submit request.");
                    $('#search').html('SEARCH');
                    $('#search').attr('disabled', false);
                }
            });
        });

        $(document).on('click', '#toggle-settings', function(){
            var panel = $('#settings-form');
            var panel2 = $('#form2');

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
        });

        $(document).on('submit', '#settings-form', function(e){
            e.preventDefault();
            $.ajax({
                url:"{{ route('save-settings') }}",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                dataType:'json',
                beforeSend:function(){
                    $('#save-settings').html('Processing, please wait...');
                },
                success:function(){
                    $('#save-settings').html('SAVE SETTINGS');
                    alert('Settings successfully saved.');
                }
            });
        });

        $(document).on('click', '#start', function(){
            $('#status').val('start');
            $('#start').html('START');
            $('#start').addClass('btn-success').removeClass('btn-warning');
            $('.elapsed').removeClass('d-none');
            startTime = new Date();
            interval = setInterval(function () {
                var time = new Date((new Date()) - startTime);
                var seconds = time.getSeconds();
                var minutes = time.getMinutes();

                if (seconds.toString().length > 1) {
                    seconds = seconds;
                } else {
                    seconds = '0'+seconds;
                }

                if (minutes.toString().length > 1) {
                    minutes = minutes;
                } else {
                    minutes = '0'+minutes;
                }

                var elapsed = minutes +':'+ seconds;
                $('#elapsed').html(elapsed);
            }, 1000);

            var symbols = $('.symbols');
            var live_averaging_time = $('.live_averaging_time').val();
            var duration;

            if (live_averaging_time == "") {
                duration = 60000;
            } else {
                duration = new Number(live_averaging_time) * 1000;
            }

            if (symbols.length > 0) {
                averaging = setInterval(function(){
                    $.each(symbols, function(){
                        var symbol = $(this).data('symbol');
                        var initial = $('#symbol-'+symbol+'-price').html();
                        getAverage(symbol, initial);
                    });
                }, duration);
            }
        });

        $(document).on('click', '#reset', function(){
            var symbols = $('.symbols');
            clearInterval(interval);
            startTime = new Date();
            interval = setInterval(function () {
                var time = new Date((new Date()) - startTime);
                var seconds = time.getSeconds();
                var minutes = time.getMinutes();

                if (seconds.toString().length > 1) {
                    seconds = seconds;
                } else {
                    seconds = '0'+seconds;
                }

                if (minutes.toString().length > 1) {
                    minutes = minutes;
                } else {
                    minutes = '0'+minutes;
                }

                var elapsed = minutes +':'+ seconds;
                $('#elapsed').html(elapsed);
            }, 1000);

            if (symbols.length > 0) {
                $.each(symbols, function(){
                    var symbol = $(this).data('symbol');
                    var value = $('#symbol-'+symbol+'-price').html();
                    $('#symbol-'+symbol+'-price').html(value);
                });
            }
        });

        $(document).on('click', '#stop', function(){
            $('#status').val('stop');
            $('#start').html('RESUME');
            $('#start').removeClass('btn-success').addClass('btn-warning');
            clearInterval(interval);
        });

        $(document).on('click', '.remove', function(){
            var symbol = $(this).data('symbol');

            if (confirm("Are you sure? Click OK to proceed.")) {
                $('#symbol-'+symbol).addClass('d-none');
            }
        });

        // $('#toggle-settings').trigger('click');
        $('#search').attr('disabled', false);
        $('.custom-symbols').select2();

        $('.add-custom-symbol').on('click', function(){
            var symbol = $('#custom-symbol').val();
            var html = "";
            var custom = $('#custom-symbol-'+symbol).html();

            if (custom === undefined) {
                html += ' <span class="remove-custom" style="cursor:pointer;" data-symbol="'+symbol+'" id="custom'+symbol+'">&bull; <span id="custom-symbol-'+symbol+'">'+symbol+' $</span><span id="custom-'+symbol+'"></span></span>';
                $('#custom-symbols').append(html);
            }
        });

        $(document).on('click','.remove-custom', function(){
            var symbol = $(this).data('symbol');
            $('#custom'+symbol).remove();
        });
    });
</script>
@endsection