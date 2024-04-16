@extends('layouts.app')
@section('content')
<div class="container-fluid bg-white">
        <div class="col-sm-12 sticky bg-white p-0 mt-4">
            <!--- BODY *** start *** -->
            <form action="{{ route('save-settings') }}" method="POST" id="settings-form">
                @csrf
                <div class="row">
                    <div class="col-sm-2 p-2" style="background:#FBC6B1;">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="p-0 text-right">PRE-QUALIFYING&nbsp;</th>
                                <td class="w-50">
                                    <input type="number" class="form border border-dark pre_qualifying" name="pre_qualifying">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-2 p-2" style="background:#FBC6B1;">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="p-0 text-right">QUALIFYING&nbsp;</th>
                                <td class="w-50">
                                    <input type="text" class="form border border-dark qualifying" name="qualifying">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-2 p-2" style="background:#FBC6B1;">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="p-0 text-right">MINIMUM&nbsp;QUALIFIER&nbsp;</th>
                                <td class="w-50">
                                    <input type="text" class="form border border-dark qvps" name="qvps">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-2 py-2" style="background:#9294C2;">
                        <table class="w-100 bg-transparent d-none">
                            <tr>
                                <th class="w-75 p-0">VOLUME AVERAGING TIME (seconds)</th>
                                <td class="p-0">
                                    <input type="number" class="form border border-dark volume_averaging_time" name="volume_averaging_time">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-2 py-2" style="background:#9294C2;">
                        <table class="w-100 bg-transparent d-none">
                            <tr>
                                <th class="w-75 p-0">LIVE PRICE AVERAGING (seconds)</th>
                                <td class="p-0">
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
                <div class="row p-1 alert alert-success my-0">
                        <div class="col-sm-1 p-0">
                            <select type="text" class="form symbol border border-dark h-25" name="symbol" id="symbol-filter">
                                <option value="USDT" selected>USDT</option>
                                <option value="BTC">BTC</option>
                                <option value="SOL">SOL</option>
                                <option value="BNB">BNB</option>
                                <option value="TUSD">TUSD</option>
                                <option value="ALL">ALL</option>
                            </select>
                        </div>
                        <div class="col-sm-1 p-0">
                            <select type="text" class="form price_type border border-dark h-25" name="price_type" id="price_type">
                                <option value="all">ALL</option>
                                <option value="above" selected>ABOVE</option>
                                <option value="below">BELOW</option>
                            </select>
                        </div>
                        <div class="col-sm-1 p-0">
                            <input type="text" class="form price_filter border border-dark h-25" name="price_filter" id="price_filter" placeholder="PRICE FILTER">
                        </div>
                        <div class="col-sm-1 p-0 px-2 d-none">
                            <input type="text" class="form text-sm symbol border border-dark" id="symbol" readonly>
                            <input type="text" class="form text-sm symbol border border-dark" id="status" readonly>
                            <input type="text" class="form text-sm symbol border border-dark" id="collection_status">
                        </div>
                        <div class="col-sm-2 p-0">
                            <button type="submit" class="btn btn-primary p-0 py-1 text-sm w-100 h-25" id="search" disabled>SEARCH</button>
                        </div>
                        <div class="col-sm-2 p-0">
                            <button type="button" class="btn btn-success p-0 py-1 text-sm w-100 h-25" id="sort">SORT BY RANK</button>
                        </div>
                        <div class="col-sm-1 p-0 d-none">
                            <button type="button" class="btn btn-success p-0 py-1 text-sm w-100 d-none" id="start">START <span id="elapsed"></span></button>
                        </div>
                        <div class="col-sm-1 p-0 d-none">
                            <button type="button" class="btn btn-info p-0 py-1 text-sm w-100 d-none" id="start-initial">INITIAL</button>
                            <button type="button" class="btn btn-info p-0 py-1 text-sm w-100 d-none" id="stop-initial">STOP INITIAL</button>
                            <button type="button" class="btn btn-info p-0 py-1 text-sm w-100 d-none" id="start-final">FINAL</button>
                            <button type="button" class="btn btn-info p-0 py-1 text-sm w-100 d-none" id="stop-final">STOP INITIAL</button>
                            <button type="button" class="btn btn-info p-0 py-1 text-sm w-100 d-none" id="restart">RESTART</button>
                            <button type="button" class="btn btn-info p-0 py-1 text-sm w-100 d-none" id="start-blocks">START BLOCKS</button>
                        </div>
                        <div class="col-sm-1 p-0 d-none">
                            <button type="button" class="btn btn-info p-0 py-1 text-sm w-100 d-none" id="reset">RESET</button>
                        </div>
                        <div class="col-sm-1 p-0 d-none">
                            <button type="button" class="btn btn-danger p-0 py-1 text-sm w-100 d-none" id="stop">STOP</button>
                        </div>
                        <div class="col-sm-2 custom d-none">
                            <select class="custom-symbols h-25 w-100" name="custom-symbol" id="custom-symbol">
                                @foreach($symbols as $symbol)
                                    <option value="{{ $symbol['symbol'] }}">{{ $symbol['symbol'] }}</option>
                                @endforeach
                            </select>
                            
                            <button type="button" class="btn btn-success add-custom-symbol p-0 px-2">+</button>
                        </div>
                        <div class="col-sm-3 border border-secondary elapsed d-none rounded-1">
                            <center>
                            Time Elapsed <span class="badge badge-success bg-success" id="elapsed"></span>
                            </center>
                        </div>
                </div>
            </form>
            <div class="row d-none m-0">
                <div class="col-sm-12">
                    <center>
                    <input type="radio" name="percentage_type" class="percentage_type" value="live" checked> Live Percentage Change &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="percentage_type" class="percentage_type" value="calculated"> Calculated Percentage Increase
                    </center>
                </div>
            </div>
        </div>
        <div class="row p-0 my-1 custom-tokens d-none alert alert-info" id="custom-symbols">
            <input type="hidden" id="choice" class="border border-0" readonly>
                <div class="col-sm-2">&bull; <span id="btc-label"></span><span id="btc"></span></div>
                <div class="col-sm-2">&bull; <span id="eth-label"></span><span id="eth"></span></div> 
                <div class="col-sm-2">&bull; <span id="sol-label"></span><span id="sol"></span></div>
                @if (count($customTokens) > 0)
                    @foreach($customTokens as $custom)
                        <div class="col-sm-2"><span class="remove-custom" style="cursor:pointer;" data-symbol="{{ $custom['symbol'] }}" id="custom{{ $custom['symbol'] }}">&bull; <span id="custom-symbol-{{ $custom['symbol'] }}">{{ $custom['symbol'] }} $</span><span id="custom-{{ $custom['symbol'] }}"></span></span></div>
                    @endforeach
                @endif
        </div>

    <div class="row">
        <div class="col-sm-12 p-0">
            <p class="bg-secondary mb-1 text-center text-white text-sm"><i class="feed-status"></i></p>
            <div id="list-container"></div>
        </div>
    </div>
    <!--- BODY *** end *** -->
    </div>
</div>
@if (!empty($setting))
<script>
$(function(){
@foreach($setting as $key => $value)
    @if (in_array($key, ['toggle_trades', 'toggle_volume', 'toggle_price','choice']))
        $('.{{$key}}').attr('checked', true);
    @else
        $('.{{$key}}').val('{{$value}}');
    @endif
@endforeach
});
</script>
@endif
<script>

function volumePercentage()
{
    var symbols = $('.symbols:not(.d-none)');
    var averaging_time = $('.volume_averaging_time').val();
    var qvpsValue = $('.qvps').val();
    var length = symbols.length;
    $.each(symbols, function(){
        length -= 1;
        var symbol = $(this).data('symbol');
        var initial = $('#symbol-'+symbol+'-initial-volume-value').html();
        var final = $('#symbol-'+symbol+'-final-volume-value').html();

        // var qvps = (parseFloat(final) / parseFloat(initial)) / parseInt(averaging_time);
        // var qvps = ((parseFloat(final) / parseFloat(initial)) * 100) / parseInt(averaging_time);
        var qvps = (parseFloat(final) / parseFloat(initial));

        if (isNaN(qvps) || !isFinite(qvps)) {
            qvps = 0;
        }

        if (isNaN(qvpsValue) || qvpsValue === undefined) {
            qvpsValue = 3.99;
        }

        if (parseFloat(qvps) < parseFloat(qvpsValue) || parseFloat(qvps) === 0) {
            $('#symbol-'+symbol).addClass('d-none');
        }

        $('#symbol-'+symbol+'-volume-average').html(qvps.toFixed(2));

        if (length < 1) {
            // Final iteration, check if any token is qualified...
            checkIfHasQualified();
        }
    });
}

function checkIfHasQualified()
{
    var symbols = $('.symbols:not(.d-none)');
    if (symbols.length > 0) {
        $('#collection_status').val('price');
        $('#start').trigger('click');
        $('#start-blocks').trigger('click');
    } else {
        console.log("No token was qualified. Restarting...");
        $('#collection_status').val('');
        $('#restart').trigger('click');
    }
}


function percentageIncrease(initial = 0, final = 0)
{
    var difference = ((final - initial) / initial);
    var percentage = (difference * 100);

    if (percentage <= -100 || isNaN(percentage)) {
        return 0;
    }

    return percentage.toFixed(2);
}

function getAverage(symbol, initial, target)
{
    if (target === 'initial_volume' || target === 'final_volume') {
        var container = $('#symbol-'+symbol+'-volume');
        var result = $(container).val().split(',');
        var count = 0;
        var value = 0;
        $.each(result, function(i, e){
            value += parseFloat(e);
            count += 1;
        });
        var increase = (value / count);

        if (isNaN(increase)) {
            increase = 0;
        }

        if (target == 'initial_volume') {
            $('#symbol-'+symbol+'-initial-volume-value').html(parseFloat(increase).toFixed(2));
        } else {
            $('#symbol-'+symbol+'-final-volume-value').html(parseFloat(increase).toFixed(2));
        }
        container.val('');
        return;
    }
    

    var container = $('#symbol-'+symbol+'-live-price');
    var liveAveragingTime = $('.live_averaging_time').val();
    var result = $(container).val().split(',');
    var count = 0;
    var value = 0;
    $.each(result, function(i, e){
        value += parseFloat(e);
        count += 1;
    });

    if (isNaN(liveAveragingTime) || liveAveragingTime === undefined || liveAveragingTime == "") {
        liveAveragingTime = 10;
    }

    var final = (value / count);
    var increase = percentageIncrease(parseFloat(initial), parseFloat(final));
    var qpps = ((parseFloat(final) / parseFloat(initial)) * 100) / parseInt(liveAveragingTime);

    var i = parseFloat($('#symbol-'+symbol+'-price').html());
    var j = parseFloat($('#symbol-'+symbol+'-latest').html());

    var change = (j - i);
    var elapsed = $('#symbol-'+symbol+'-elapsed').html();
    var change_percentage = percentageIncrease(i, j);
    var change_per_second = (change / parseInt(elapsed));
    
    // var change = (parseFloat(final) - parseFloat(initial));
    // var change_percentage = (parseFloat(final) / parseFloat(initial));
    // var change_per_second = (change_percentage / parseInt(liveAveragingTime));

    if (isNaN(qpps) || !isFinite(qpps)) {
        qpps = 0;
    }

    $('#symbol-'+symbol+'-qpps').html(qpps.toFixed(2));

    // var blocks = $('#block-count').val();
    // var choice = $('#choice').val();
    
    // if (choice == 'positive') {
    //     $('#table thead').addClass('text-success').removeClass('text-danger');
    // } else {
    //     $('#table thead').removeClass('text-success').addClass('text-danger');
    // }

    // for(i = 1; i <= blocks;i++)
    // {
    //     if ($('#symbol-'+symbol+'-option'+i).html() == "") {
            
    //         var optionAverage = $('#symbol-'+symbol+'-option'+i);
    //         var previousBlock = (i - 1);
    //         var previous = $('#symbol-'+symbol+'-option'+previousBlock).html();
    //         if (i == 1) {
    //             optionAverage.removeClass('badge bg-success').removeClass('badge bg-danger');
    //         } else {
    //             if (parseFloat(increase) == 0) {
    //                 optionAverage.removeClass('badge bg-success').removeClass('badge bg-danger');

    //                 // if (choice == 'positive') {
    //                 //     $('#symbol-'+symbol).addClass('d-none');
    //                 // }

    //             } else if (parseFloat(previous) < parseFloat(increase)) {
    //                 optionAverage.addClass('badge bg-success').removeClass('bg-danger');

    //                 // if (choice == 'negative') {
    //                 //     $('#symbol-'+symbol).addClass('d-none');
    //                 // }

    //             } else if (parseFloat(previous) > parseFloat(increase)) {
    //                 optionAverage.removeClass('bg-success').addClass('badge bg-danger');
                    
    //                 if (choice == 'positive') {
    //                     $('#symbol-'+symbol).addClass('d-none');
    //                 }

    //             } else {
    //                 optionAverage.removeClass('badge bg-success').removeClass('badge bg-danger');
    //             }
    //         }

    //         if (isNaN(increase)) {
    //             increase = 0;
    //         }
    
    //         $('#symbol-'+symbol+'-latest-price').html(increase);
    //         optionAverage.html(increase);
    //         break;
    //     }
    // }

    if (isNaN(increase)) {
        increase = 0;
    }

    var c = change.toFixed(5);
    var cp = change_percentage;
    var cps = change_per_second.toFixed(5);

    if (isNaN(c)) {
        c = 0;
    }

    if (isNaN(cp)) {
        cp = 0;
    }

    if (isNaN(cps)) {
        cps = 0;
    }

    $('#symbol-'+symbol+'-latest-price').html(increase);
    $('#symbol-'+symbol+'-change').html(c);
    $('#symbol-'+symbol+'-change-percentage').html(cp);
    $('#symbol-'+symbol+'-change-per-second').html(cps);

    if ($('#symbol-'+symbol+'-live-price').val() !== "") {
        $('#symbol-'+symbol+'-live-price').val("");
    }
}

function priceFilter()
{
    var symbols = $('.symbols:not(".d-none")');
    $.each(symbols, function(){
        var symbol = $(this).data('symbol');
        var price_filter = $('#price_filter').val();
        var price_type = $('#price_type').val();
        if (price_filter !== '') {
            var price = $('#symbol-'+symbol+'-price').html();
            if (price_type == 'above' && parseFloat(price) < parseFloat(price_filter)) {
                $('#symbol-'+symbol).addClass('d-none');
            } else if (price_type == 'below' && parseFloat(price) > parseFloat(price_filter)) {
                $('#symbol-'+symbol).addClass('d-none');
            }
        }
    });
}

function addRanking()
{
    var symbols = $('.symbols:not(.d-none)');
    var i = 0;

    $.each(symbols, function(){
        i += 1;
        var symbol = $(this).data('symbol');
        $('#symbol-'+symbol+'-ranking').html(i);
    });
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

function collectVolume(symbol, value) 
{
    var container = $('#symbol-'+symbol+'-volume');
    var volume = container.val();

    if (volume != "") {
        container.val(volume+','+value);
    } else {
        container.val(value);
    }
}

function hhmmss(symbol, totalSeconds)
{
    let hours = Math.floor(totalSeconds / 3600);
    totalSeconds %= 3600;
    let minutes = Math.floor(totalSeconds / 60);
    let seconds = totalSeconds % 60;

    minutes = String(minutes).padStart(2, "0");
    hours = String(hours).padStart(2, "0");
    seconds = String(seconds).padStart(2, "0");
    
    $('#symbol-'+symbol+'-elapsed-time').html(hours + ":" + minutes + ":" + seconds);
}

    $(function(){

        var interval, startTime, averaging, initialAveraging, finalAveraging;
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
                $('.custom-tokens').removeClass('d-none');
                $.each(data, function(i, e){
                    var collection_status = $('#collection_status').val();
                    var custom = $('#custom-'+e.s);

                    if ($('#symbol-'+e.s+'-price').html() == "") {
                        $('#symbol-'+e.s+'-price').html(e.c);
                    }

                    if (custom.html() !== undefined) {
                        if (new Number(custom.html()) > e.c) {
                            custom.addClass('text-danger').removeClass('text-success');
                        } else {
                            custom.removeClass('text-danger').addClass('text-success');
                        }
                        custom.html(e.c);
                    }

                    if (e.s == 'BTCUSDT') { 
                        var btc = $('#btc').html();
                        if (new Number(btc) > e.c) {
                            $('#btc').addClass('text-danger').removeClass('text-success');
                        } else {
                            $('#btc').removeClass('text-danger').addClass('text-success');
                        }
                        $('#btc-label').html('BTC $');
                        $('#btc').html(parseFloat(e.c).toFixed(2));
                    }

                    if (e.s == 'ETHUSDT') {
                        var eth = $('#eth').html(); 
                        if (new Number(eth) > e.c) {
                            $('#eth').addClass('text-danger').removeClass('text-success');
                        } else {
                            $('#eth').removeClass('text-danger').addClass('text-success');
                        }
                        $('#eth-label').html('ETH $');
                        $('#eth').html(parseFloat(e.c).toFixed(2));
                    }

                    if (e.s == 'SOLUSDT') {
                        var sol = $('#sol').html();
                        if (new Number(sol) > e.c) {
                            $('#sol').addClass('text-danger').removeClass('text-success');
                        } else {
                            $('#sol').removeClass('text-danger').addClass('text-success');
                        }
                        $('#sol-label').html('SOL $');
                        $('#sol').html(parseFloat(e.c).toFixed(2));
                    }
                    
                    if ($('#symbol-'+e.s+'-price').html() !== undefined && $('#symbol-'+e.s+'-price').html() == "") {
                        $('#symbol-'+e.s+'-price').html(parseFloat(e.c).toFixed(2));
                    }

                    if (collection_status === 'volume') {
                        // collectVolume(e.s, parseFloat(e.v)); // Base Asset Volume
                        collectVolume(e.s, parseFloat(e.q)); // Quote Asset Volume
                    } else if (collection_status === 'price') {
                        collectValues(e.s, parseFloat(e.c));
                    }

                    $('#symbol-'+e.s+'-latest').html(e.c);
                    var current = new Date().toLocaleString();
                    var time = current.substring(10, (new String(current).length));
                    $('#symbol-'+e.s+'-current-time').html(time.toLowerCase());

                    var start_time = $('#symbol-'+e.s+'-time').html();
                    var end_time = $.now();
                    var diff =  (parseInt(end_time / 1000) - start_time);
                    if (diff !== undefined && diff > 0) {
                        $('#symbol-'+e.s+'-elapsed').html(diff);
                        hhmmss(e.s, diff);
                    }
                });

                $('.feed-status').html('receiving token feeds ('+data.length+'/s)...');
            }
        };

        $(document).on('submit', '#form2', function(e){
            e.preventDefault();

            if (confirm("Start new search?")) {
                $('#search').html('Processing...');
                $('#search').attr('disabled', true);
                $('#collection_status').val('volume');
                $('.elapsed').addClass('d-none');
                $('.tokens-table').addClass('d-none');

                clearInterval(interval);
                clearInterval(averaging);

                var symbol = $('#symbol-filter').val();
                $('#symbol').val(symbol);

                var choice = $('.choice:checked').val();
                $('#choice').val(choice);

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
                        $('#start-initial').trigger('click');
                        $('#collection_status').val('volume');
                        $('.custom').removeClass('d-none');
                    }, error:function(response){
                        alert("An error occurred. Re-submit request.");
                        $('#search').html('SEARCH');
                        $('#search').attr('disabled', false);
                    }
                });
            }
            
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

        $(document).on('click', '#restart', function(){
            $('.qualifying_status').html("No token was qualified, restarting...");
            clearInterval(finalAveraging);
            clearInterval(initialAveraging);
            clearInterval(interval);
            clearInterval(averaging);
            $('#form2').trigger('submit');
        });

        $(document).on('click', '#start', function(){
            console.log("Start button triggered...");
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
            $('.sort-qvps').trigger('click');
        });

        $(document).on('click', '#start-blocks', function(){
            var symbols = $('.symbols');
            var live_averaging_time = $('.live_averaging_time').val();
            var duration;
            $('.qualifying_status').html($('.symbols:not(.d-none)').length+" tokens qualified...");
            $('.tokens-table').removeClass('d-none');

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

                        if (initial == "") {
                            $('#symbol-'+symbol).addClass('d-none');
                        }
                        getAverage(symbol, initial);
                    });
                    priceFilter();
                }, 1000);
            }
        });

        $(document).on('click', '#start-initial', function(){
            $('.qualifying_status').append("Initial volume collection initialized... ");
            $('#status').val('start');
            var symbols = $('.symbols');
            // var averaging_time = $('.volume_averaging_time').val();
            var averaging_time = $('.pre_qualifying').val();
            var duration;

            if (averaging_time == "") {
                duration = 60000;
            } else {
                duration = new Number(averaging_time) * 1000;
            }

            console.log("Duration: "+duration);

            if (symbols.length > 0) {
                initialAveraging = setInterval(function(){
                    console.log("Initial volume averaging triggered...");

                    $.each(symbols, function(){
                        var symbol = $(this).data('symbol');
                        getAverage(symbol, "", 'initial_volume');
                    });

                    $('#stop-initial').trigger('click');
                }, duration);
            }
        });

        $(document).on('click', '#stop-initial', function(){
            console.log("Initial volume collection and averaging stopped... ");
            clearInterval(initialAveraging);
            $('#start-final').trigger('click');
        });

        $(document).on('click', '#start-final', function(){
            $('.qualifying_status').append("Final volume collection initialized... ");
            $('#status').val('start');
            var symbols = $('.symbols');
            // var averaging_time = $('.volume_averaging_time').val();
            var averaging_time = $('.qualifying').val();
            var duration;

            if (averaging_time == "") {
                duration = 60000;
            } else {
                duration = new Number(averaging_time) * 1000;
            }

            console.log("Duration: "+duration);

            if (symbols.length > 0) {
                finalAveraging = setInterval(function(){
                    console.log("Final volume averaging triggered...");

                    $.each(symbols, function(){
                        var symbol = $(this).data('symbol');
                        getAverage(symbol, "", 'final_volume');
                    });

                    $('#stop-final').trigger('click');
                }, duration);
            }
        });

        $(document).on('click', '#stop-final', function(){
            console.log("Final volume collection and averaging stopped... ");
            clearInterval(finalAveraging);
            volumePercentage();
        });

        $(document).on('click', '.qualifying_status', function(){
            $('.qualifying_status').html("");
            $('.qualifying_status').addClass("d-none");
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

        $('#search').attr('disabled', false);
        $('.custom-symbols').select2();

        $('.add-custom-symbol').on('click', function(){
            var symbol = $('#custom-symbol').val();
            var html = "";
            var custom = $('#custom-symbol-'+symbol).html();

            $.ajax({
                url:"{{ route('custom-token-save') }}",
                method:'POST',
                data:{
                    symbol:symbol
                },
                dataType:'json',
                success:function(response){
                    if (response) {
                        if (custom === undefined) {
                            html += ' <div class="col-sm-2"><span class="remove-custom" style="cursor:pointer;" data-symbol="'+symbol+'" id="custom'+symbol+'">&bull; <span id="custom-symbol-'+symbol+'">'+symbol+' $</span><span id="custom-'+symbol+'"></span></span></div>';
                            $('#custom-symbols').append(html);
                        }
                    }
                }
            });

        });

        $(document).on('click','.remove-custom', function(){
            var symbol = $(this).data('symbol');

            $.ajax({
                url:"{{ route('custom-token-remove') }}",
                method:'POST',
                data:{
                    symbol:symbol
                },
                dataType:'json',
                success:function(response){
                    if (response) {
                        $('#custom'+symbol).remove();
                    }
                }
            });
        });

        $(document).on('click','#sort', function(){
            $('.sort').trigger('click');
            addRanking();
        });
        var sticky = $('.sticky').offset().top;   
        $(window).scroll(function(){
            if($(window).scrollTop() > sticky) {
                $('.sticky').css({'position':'fixed','top':'0px'});
                $('.sticky').removeClass('mt-4');
            } else {
                $('.sticky').addClass('mt-4');
                $('.sticky').css({'position':'relative'});
            }
                
        });
    });
</script>
@endsection