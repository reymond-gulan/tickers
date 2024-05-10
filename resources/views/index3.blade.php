@extends('layouts.app')
@section('content')
<div class="container-fluid bg-white">
        <div class="col-sm-12 sticky bg-white p-0 mt-4">
            <!--- BODY *** start *** -->
            <form action="{{ route('save-settings') }}" method="POST" id="settings-form">
                @csrf
                <div class="row">
                    <div class="col-sm-3 bg-info">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="w-50 text-right">Initial Sampling (seconds):&nbsp;</th>
                                <td>
                                    <input type="number" class="form border border-dark pre_qualifying" name="pre_qualifying">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-3 bg-info" style="background:#FBC6B1;">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="w-50 text-right">Final Sampling (seconds):&nbsp;</th>
                                <td>
                                    <input type="text" class="form border border-dark qualifying" name="qualifying">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-3 bg-info">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="w-50">Time per block (seconds):</th>
                                <td>
                                    <input type="number" class="form border border-dark requalifying" name="requalifying">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-3 p-0">
                        <button type="submit" class="btn btn-success h-100 text-sm w-100 rounded-0" id="save-settings">SAVE SETTINGS</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3" style="background:#8cd98c">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="text-right">Minimum&nbsp;price change %&nbsp;</th>
                                <td class="w-50">
                                    <input type="text" class="form border border-dark qvps" name="qvps">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-3 px-0" style="background:#8cd98c">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="text-right">Sort by:</th>
                                <td class="w-75">
                                <select class="form border border-dark sort_by" name="sort_by">
                                        <option value="change_percent" selected>GAIN / LOSS</option>
                                        <option value="change_per_second">CHANGE % per SECOND</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-2 px-0" style="background:#8cd98c">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <td>
                                    <select class="form border border-dark sort_type" name="sort_type">
                                        <option value="asc">ascending</option>
                                        <option value="desc">descending</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-1 pt-1 px-0" style="background:#8cd98c">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="p-0 text-xs">
                                    <center>AUTO-SORT</center>
                                </th>
                                <td class="p-0">
                                    <select class="form border border-dark auto_sort p-0" name="auto_sort">
                                        <option value="no">no</option>
                                        <option value="yes">yes</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-3 pt-1" style="background:#8cd98c">
                        <div class="border border-secondary elapsed d-none rounded-1">
                            <center>
                            Time Elapsed <span class="badge badge-success bg-success" style="font-size:11px" id="elapsed"></span>
                            </center>
                        </div>
                    </div>
                    <div class="col-sm-1 py-2 d-none" style="background:#9294C2;">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="w-75 p-0">LIVE PRICE AVERAGING (seconds)</th>
                                <td class="p-0">
                                    <input type="number" class="form border border-dark live_averaging_time" name="live_averaging_time">
                                </td>
                            </tr>
                        </table>
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
                            <input type="text" class="form text-sm symbol border border-dark" id="perpetual">
                        </div>
                        <div class="col-sm-1 p-0">
                            <button type="submit" class="btn btn-success p-0 py-1 text-sm w-100 h-25" id="search" disabled>START</button>
                        </div>
                        <div class="col-sm-1 p-0">
                            <button type="button" class="btn btn-primary p-0 py-1 text-sm w-100 h-25" id="sort">SORT</button>
                        </div>
                        <div class="col-sm-1 p-0">
                            <button type="button" class="btn btn-danger p-0 py-1 text-sm w-100 h-25" id="refresh-timer" disabled>RESET</button>
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
                            <button type="button" class="btn btn-info p-0 py-1 text-sm w-100 d-none reset">RESET</button>
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
    var symbols = $('.symbols');
    var averaging_time = $('.volume_averaging_time').val();
    var qvpsValue = $('.qvps').val();
    var length = symbols.length;
    var perpetual = $('#perpetual').val();
    $.each(symbols, function(){
        length -= 1;
        var symbol = $(this).data('symbol');
        var initial = $('#symbol-'+symbol+'-initial-volume-value').html();
        var final = $('#symbol-'+symbol+'-final-volume-value').html();

        var qvps = percentageIncrease(parseFloat(initial), parseFloat(final));

        if (isNaN(qvps) || !isFinite(qvps)) {
            qvps = 0;
        }

        if (isNaN(qvpsValue) || qvpsValue === undefined) {
            qvpsValue = 3.99;
        }

        if (perpetual == "" || perpetual !== 'start') {
            if (parseFloat(qvps) < parseFloat(qvpsValue) || parseFloat(qvps) === 0) {
                $('#symbol-'+symbol).addClass('bg-danger');
            }
        }

        if (length < 1 && perpetual !== 'start') {
            // Final iteration, check if any token is qualified...
            checkIfHasQualified();
        }

        if (length < 1 && perpetual == 'start') {
            checkIfHasRequalified();
        }

        if (length < 1 && perpetual == 'start') {
            $('#start-initial').trigger('click');
        }
    });
}

function checkIfHasQualified()
{
    var symbols = $('.symbols:not(.bg-danger)');
    if (symbols.length > 0) {
        $('#collection_status').val('price');
        $('#start').trigger('click');
        $('#start-blocks').trigger('click');
        $('#perpetual').val("start");
        $('#refresh-timer').attr('disabled', false);
    } else {
        console.log("No token was qualified. Restarting...");
        $('#collection_status').val('');
        $('#restart').trigger('click');
    }
}

function checkIfHasRequalified()
{
    var symbols = $('.symbols.bg-danger');
    var qvpsValue = $('.qvps').val();
    $.each(symbols, function(){
        var symbol = $(this).data('symbol');
        var qvps = $('#symbol-'+symbol+'-volume-average').html();
        if (parseFloat(qvps) > parseFloat(qvpsValue)) {
            $('#symbol-'+symbol).removeClass('bg-danger');
            var current = new Date().toLocaleString();
            var time = current.substring(10, (new String(current).length));
            $('#symbol-'+symbol+'-qualifying-time').html(time.toLowerCase());
            var now = parseInt($.now() / 1000);
            $('#symbol-'+symbol+'-time').html(now);
        }
    });
    $('.qualifying_status').remove();
    // $('.qualifying_status').html($('.symbols:not(.bg-danger)').length+" token/s...");
}


function percentageIncrease(initial = 0, final = 0, raw = "")
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
    var liveAveragingTime = $('.requalifying').val();
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

    var i = parseFloat($('#symbol-'+symbol+'-price').html());
    var j = parseFloat($('#symbol-'+symbol+'-latest').html());

    var elapsed = $('.qualifying').val();
    var change = (j - i);
    var change_per_second = (change / parseInt(elapsed));

    if (isNaN(increase)) {
        increase = 0;
    }

    var cps = change_per_second.toFixed(10);

    if (isNaN(cps)) {
        cps = 0;
    }

    $('#symbol-'+symbol+'-latest-price').html(increase);

    $('#symbol-'+symbol+'-change-per-second').html(cps);

    var html = "";

    var sort_by = $('.sort_by').val();

    if (sort_by === 'change_per_second') {
        if (Math.sign(cps) === 1) {
            html += '<p class="m-0 bar" data-symbol="'+symbol+'" style="height:15px !important;cursor:pointer;width:'+(parseFloat(cps) * 10)+'% !important;background:green;max-width:100%;"></p>';
        } else if (Math.sign(cps) === -1) {
            html += '<p class="m-0 bar" data-symbol="'+symbol+'" style="height:15px !important;cursor:pointer;width:'+(Math.abs(cps) * 10)+'% !important;background:red;max-width:100%;"></p>';
        }
        $('#symbol-'+symbol+'-indicator').html(html);  
    }

    priceFilter();

    if ($('#symbol-'+symbol+'-live-price').val() !== "") {
        $('#symbol-'+symbol+'-live-price').val("");
    }

    // $('#symbol-'+symbol+'-price').removeClass('text-danger');
    // var latest_price = $('#symbol-'+symbol+'-latest').html();
    // var start_price = $('#symbol-'+symbol+'-price').html();
    // if (parseFloat(start_price) > parseFloat(latest_price)) {
    //     $('#symbol-'+symbol+'-price').html(latest_price);
    //     $('#symbol-'+symbol+'-price').addClass('text-danger');
    // }
}

function priceFilter()
{
    var price_filter = $('#price_filter').val();
    if (price_filter !== '') {
        var symbols = $('.symbols:not(".bg-danger")');
        $.each(symbols, function(){
            var symbol = $(this).data('symbol');
            var price_type = $('#price_type').val();
            var price = $('#symbol-'+symbol+'-price').html();
            if (price_type == 'above' && parseFloat(price) < parseFloat(price_filter)) {
                $('#symbol-'+symbol).addClass('bg-danger');
            } else if (price_type == 'below' && parseFloat(price) > parseFloat(price_filter)) {
                $('#symbol-'+symbol).addClass('bg-danger');
            }
        });
    }
}

function addRanking()
{
    var symbols = $('.symbols:not(.bg-danger)');
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
        const ticker = "!ticker_1d@arr";
        const socket = new WebSocket(url + ticker);

        socket.addEventListener("error", (event) => {
            $('.feed-status').html("Connection cannot be established...");
        });
        // Feeds

        socket.onmessage = function (event) {
            var data = JSON.parse(event.data);
            var status = $('#status').val();
            var sort_by = $('.sort_by').val();
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
                        // collectVolume(e.s, parseFloat(e.q)); // Quote Asset Volume
                    } else if (collection_status === 'price') {
                        collectValues(e.s, parseFloat(e.c));
                        $('#symbol-'+e.s+'-volume-average').html(e.P);
                    }

                    collectVolume(e.s, parseFloat(e.v));

                    $('#symbol-'+e.s+'-latest').html(e.c);

                    var start_price = $('#symbol-'+e.s+'-price').html();

                    if (start_price !== "") {
                        var gain_loss = percentageIncrease(parseFloat(start_price), parseFloat(e.c));
                        $('#symbol-'+e.s+'-change-percentage').html(gain_loss);
                    }


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

                    $('#symbol-'+e.s+'-price-change-percentage').html(e.P);

                    if (sort_by == 'change_percent') {
                        var change_percent = parseFloat(e.P);
                        var change_percent = percentageIncrease(parseFloat(start_price), parseFloat(e.c));
                        var html = "";
                        if (change_percent !== "" && Math.sign(change_percent) === 1) {
                            html += '<p class="m-0 bar" data-symbol="'+e.s+'" style="height:15px !important;cursor:pointer;width:'+(parseFloat(change_percent) * 3)+'% !important;background:green;max-width:100%;"></p>';
                        } else if (change_percent !== "" && Math.sign(change_percent) === -1) {
                            html += '<p class="m-0 bar" data-symbol="'+e.s+'" style="height:15px !important;cursor:pointer;width:'+(Math.abs(change_percent) * 3)+'% !important;background:red;max-width:100%;"></p>';
                        }
                        $('#symbol-'+e.s+'-indicator').html(html);
                    }
                });

                $('.feed-status').html('receiving token feeds ('+data.length+'/s)...');
            }
        };

        $(document).on('submit', '#form2', function(e){
            e.preventDefault();
            $('#search').html('Processing...');
            $('#search').attr('disabled', true);
            $('#collection_status').val('volume');
            $('.elapsed').addClass('d-none');
            $('.tokens-table').addClass('d-none');
            $('.reset').trigger('click');
            $('#perpetual').val("");
            $('.qualifying_status').html('...');

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
                    $('#search').html('START');
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

        $(document).on('click', '.reset', function(){
            clearInterval(finalAveraging);
            clearInterval(initialAveraging);
            clearInterval(interval);
            clearInterval(averaging);
        });

        $(document).on('click', '#refresh-timer', function(){
            $('#refresh-timer').html('Refreshing...');
            $('#refresh-timer').attr('disabled', true);
            clearInterval(finalAveraging);
            clearInterval(initialAveraging);
            $('#start-initial').trigger('click');
            setTimeout(function(){
                $('#refresh-timer').html('RESET SUCCESSFUL');
                $('#refresh-timer').attr('disabled', false);
            }, 2000);

            setTimeout(function(){
                $('#refresh-timer').html('RESET');
                $('#refresh-timer').attr('disabled', false);
            }, 4000);
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

                setTimeout(function(){
                    addRanking();
                    priceFilter();
                }, 100);

            }, 1000);
            $('.sort-qvps').trigger('click');
        });

        $(document).on('click', '#start-blocks', function(){
            $('#start-initial').trigger('click');
            var symbols = $('.symbols');
            var live_averaging_time = $('.requalifying').val();
            var duration;
            $('.qualifying_status').remove();
            // $('.qualifying_status').html($('.symbols:not(.bg-danger)').length+" token/s qualified...");
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
                        priceFilter();
                    });
                    
                    setTimeout(function(){
                        $('#sort').trigger('click');
                        var sort_by = $('.sort_by').val();
                        if (sort_by == 'change_percent') {
                            $('.change_percent').addClass('bg-success text-white');
                            $('.change_per_second').removeClass('bg-success text-white');
                        } else {
                            $('.change_per_second').addClass('bg-success text-white');
                            $('.change_percent').removeClass('bg-success text-white');
                        }
                    }, 2000);

                }, duration);
            }
        });

        $(document).on('click', '#start-initial', function(){
            var perpetual = $('#perpetual').val();
            if (perpetual == "") {
                $('.qualifying_status').append("Initial sampling initialized... ");
                var averaging_time = $('.pre_qualifying').val();
            } else {
                var averaging_time = $('.requalifying').val();
            }
            
            $('#status').val('start');
            var symbols = $('.symbols');
            var duration;

            if (averaging_time == "") {
                duration = 60000;
            } else {
                duration = new Number(averaging_time) * 1000;
            }

            if (symbols.length > 0) {
                initialAveraging = setInterval(function(){
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
            var perpetual = $('#perpetual').val();
            if (perpetual == "") {
                $('.qualifying_status').append("Final sampling initialized... ");
                var averaging_time = $('.qualifying').val();
            } else {
                var averaging_time = $('.requalifying').val();
            }

            $('#status').val('start');
            var symbols = $('.symbols');
            var duration;

            if (averaging_time == "") {
                duration = 60000;
            } else {
                duration = new Number(averaging_time) * 1000;
            }

            if (symbols.length > 0) {
                finalAveraging = setInterval(function(){
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
            // $('.qualifying_status').html("");
            // $('.qualifying_status').addClass("d-none");
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
                priceFilter();
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
            var auto_sort = $('.auto_sort').val();

            if (auto_sort == 'yes') {
                var sort_by = $('.sort_by').val();
                if (sort_by === 'change_per_second') {
                    $('.change_per_second').trigger('click');
                } else {
                    $('.change_percent').trigger('click');
                }
            }
            setTimeout(function(){
                addRanking();
            }, 1000);
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

        $(document).on('change','#price_filter, #price_type', function(){
            var price_filter = $('#price_filter').val();
            if (price_filter !== "") {
                priceFilter();
            }
        });

        $(document).on('click','.bar', function(){
            var symbol = $(this).data('symbol');
            window.open('https://www.binance.com/en/trade/'+symbol+'?type=spot');
        });
    });
</script>
@endsection