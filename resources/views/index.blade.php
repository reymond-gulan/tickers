@extends('layouts.app')
@section('content')
<div class="container-fluid bg-white">
        <div class="col-sm-12 sticky bg-white p-0 mt-4">
            <!--- BODY *** start *** -->
            <form action="{{ route('save-settings') }}" method="POST" id="settings-form">
                @csrf
                <div class="row">
                    <div class="col-sm-1 pt-2 text-sm" style="background:#FBC6B1;">
                        <center><b>Global Settings:</b></center>
                    </div>
                    <div class="col-sm-4 bg-info">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="p-0 text-right col-sm-6 text-sm">Time per sampling block (seconds):&nbsp;</th>
                                <td>
                                    <input type="number" class="form border border-dark time_per_block" name="time_per_block">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-3 bg-info">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="p-0 text-right col-sm-4">System on/off:&nbsp;</th>
                                <td class="col-sm-4">
                                    <button type="button" class="btn btn-success p-0 text-sm w-100" id="start-now">Start</button>
                                    <button type="button" class="btn btn-success p-0 text-sm w-100 d-none" id="start">Start</button>
                                </td>
                                <td class="col-sm-4">
                                    <button type="button" class="btn bg-red p-0 text-sm w-100" id="stop">Stop</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-2 bg-info">
                            <table class="w-100 bg-transparent">
                                <tr>
                                    <th class="p-0 text-right col-sm-6">Manual data reset:&nbsp;</th>
                                    <td>
                                        <button type="button" class="btn btn-success p-0 text-sm w-100" id="reset">Reset data feed</button>
                                    </td>
                                </tr>
                            </table>
                    </div>
                    <div class="col-sm-2 bg-info">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <td class="text-white">
                                    <div class="row">
                                    <input type="hidden" id="status" readonly>
                                    <input type="hidden" id="time-elapsed" value="0" readonly>
                                    <input type="hidden" id="time-elapsed-negative" value="0" readonly>
                                    <button type="submit" class="btn btn-success h-100 text-sm rounded-0" id="save-settings">SAVE SETTINGS</button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5 p-2" style="background:#8cd98c">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="p-0 text-right">Price Filter:&nbsp;</th>
                                <td>
                                    <select class="form border border-dark price_filter_type_positive" name="price_filter_type_positive">
                                        <option value="above">above</option>
                                        <option value="below">below</option>
                                    </select>
                                </td>
                                <td style="width:10%;">
                                    <input type="text" class="form border border-dark price_filter_positive" name="price_filter_positive">
                                </td>
                                <th class="p-0 text-right">Symbol Sorting:&nbsp;</th>
                                <td>
                                    <select class="form border border-dark symbol_sorting_positive" name="symbol_sorting_positive">
                                        <option value="asc">A-Z</option>
                                        <option value="desc">Z-A</option>
                                    </select>
                                </td>
                                <th class="p-0 text-right">CPS:&nbsp;</th>
                                <td>
                                    <select class="form border border-dark cps_sorting_positive" name="cps_sorting_positive">
                                        <option value="asc">ascending</option>
                                        <option value="desc">descending</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="p-0 text-right">Time:&nbsp;</th>
                                <td>
                                    <input type="text" class="form border border-dark averaging_time_positive" name="averaging_time_positive">
                                </td>
                                <th class="p-0 text-right">Minimum Gain:&nbsp;</th>
                                <td>
                                    <input type="text" class="form border border-dark minimum_gain_positive" name="minimum_gain_positive">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-2 bg-info p-0">
                        <div class="border border-secondary elapsed d-none rounded-1">
                            <center>Time Elapsed<br /> <span class="badge badge-secondary" id="elapsed"></span></center>
                        </div>
                    </div>
                    <div class="col-sm-5 p-2" style="background:#ff8080">
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="p-0 text-right">Price Filter:&nbsp;</th>
                                <td>
                                    <select class="form border border-dark price_filter_type_negative" name="price_filter_type_negative">
                                        <option value="above">above</option>
                                        <option value="below">below</option>
                                    </select>
                                </td>
                                <td style="width:10%;">
                                    <input type="text" class="form border border-dark price_filter_negative" name="price_filter_negative">
                                </td>
                                <th class="p-0 text-right">Symbol Sorting:&nbsp;</th>
                                <td>
                                    <select class="form border border-dark symbol_sorting_negative" name="symbol_sorting_negative">
                                        <option value="asc">A-Z</option>
                                        <option value="desc">Z-A</option>
                                    </select>
                                </td>
                                <th class="p-0 text-right">CPS:&nbsp;</th>
                                <td>
                                    <select class="form border border-dark cps_sorting_negative" name="cps_sorting_negative">
                                        <option value="asc">ascending</option>
                                        <option value="desc">descending</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <table class="w-100 bg-transparent">
                            <tr>
                                <th class="p-0 text-right">Time:&nbsp;</th>
                                <td>
                                    <input type="text" class="form border border-dark averaging_time_negative" name="averaging_time_negative">
                                </td>
                                <th class="p-0 text-right">Minimum Gain:&nbsp;</th>
                                <td>
                                    <input type="text" class="form border border-dark minimum_gain_negative" name="minimum_gain_negative">
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
                    <div class="col-sm-2 px-1 d-none">
                        <button type="submit" class="btn btn-primary w-100 h-100 text-sm rounded-1" id="search">SEARCH</button>
                    </div>
                    <div class="col-sm-2 custom">
                        <select class="custom-symbols h-25" name="custom-symbol" id="custom-symbol">
                            @foreach($symbols as $symbol)
                                <option value="{{ $symbol['symbol'] }}">{{ $symbol['symbol'] }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-success add-custom-symbol p-0 px-2">+</button>
                    </div>
                </form>
        </div>
        <div class="row p-0 my-1 custom-tokens d-none" id="custom-symbols">
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
        <div class="alert alert-warning restart mt-1 p-1 d-none">
            <center>
                <b>Restarting...</b>
            </center>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <table class="w-100 bg-transparent" id="table">
                    <thead style="cursor:pointer;">
                        <tr id="list-header" class="border-bottom border-secondary">
                            <th style="width:50px !important;">SYMBOL</th>
                            <th style="width:80px !important;">CURRENT PRICE</th>
                            <th class="sort" style="text-align:left !important;width:50px !important;"></th>
                            <th style="width:100px !important;"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="symbols-body text-xs" id="positive-tokens">
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="w-100 bg-transparent text-xs" id="table">
                    <thead style="cursor:pointer;">
                        <tr id="list-header" class="border-bottom border-secondary">
                            <th style="width:50px !important;">SYMBOL</th>
                            <th style="width:80px !important;">CURRENT PRICE</th>
                            <th class="sort-negative" style="text-align:left !important;width:50px !important;"></th>
                            <th style="width:100px !important;"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="symbols-body" id="negative-tokens">
                    </tbody>
                </table>
            </div>
            <div id="list-container" class="col-sm-4"></div>
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
function filterZeroes()
{
    var symbols = $('.symbols');
    $.each(symbols, function(){
        var symbol = $(this).data('symbol');
        var price_change = $('#symbol-'+symbol+'-price-change-percent').html();

        if (price_change === "") {
            $('.symbols').addClass('bg-danger');
            $('#symbol-'+symbol).removeClass('bg-danger');
        }
    });
}

function priceFilter()
{
    var symbols = $('.symbols');
    $.each(symbols, function(){
        var symbol = $(this).data('symbol');
        if (price_filter !== '') {
            var price_filter = $('#price_filter').val();
            var price_type = $('#price_type').val();
            var price = $('#symbol-'+symbol+'-price').html();
            if (price_type == 'above' && parseFloat(price) < parseFloat(price_filter)) {
                $('#symbol-'+symbol).addClass('bg-danger');
            } else if (price_type == 'below' && parseFloat(price) > parseFloat(price_filter)) {
                $('#symbol-'+symbol).addClass('bg-danger');
            }
        }
    });
}

    $(function(){
        $('.custom-symbols').select2();
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
            var time_elapsed = $('#time-elapsed').val();
            var time_elapsed_negative = $('#time-elapsed-negative').val();

            if (status == 'start') {
                var averaging_time_positive = $('.averaging_time_positive').val();
                var averaging_time_negative = $('.averaging_time_negative').val();

                var price_filter_type_positive = $('.price_filter_type_positive').val();
                var price_filter_type_negative = $('.price_filter_type_negative').val();

                var price_filter_positive = $('.price_filter_positive').val();
                var price_filter_negative = $('.price_filter_negative').val();

                var symbol_filter = $('#symbol-filter').val();

                $('.custom-tokens').removeClass('d-none');
                $.each(data, function(i, e){
                    var collection_status = $('#collection_status').val();
                    var custom = $('#custom-'+e.s);

                    if ($('.symbol-'+e.s+'-price').html() == "") {
                        $('.symbol-'+e.s+'-price').html(e.c);
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


                    if (parseInt(time_elapsed) == parseInt(averaging_time_positive)) {

                        var cps_sorting_positive = $('.cps_sorting_positive').val();
                        $('.sort').attr('data-sort', cps_sorting_positive);

                        $('#positive-tokens').html("");
                        $('#symbol-'+e.s+'-current-price').html(e.c);
                        $('#symbol-'+e.s+'-price-change-percent').html(e.P);
                        
                        var minimum_gain_positive = parseFloat($('.minimum_gain_positive').val());

                        var symbol = e.s;
                        var change = parseFloat(e.P);
                        var html = '';
                        var hasString = symbol.indexOf(symbol_filter);

                        if (hasString > 0) {
                            setTimeout(function(){
                                if (e.P !== "" && Math.sign(change) === 1) {
                                    if (change > minimum_gain_positive) {
                                        html += '<tr class="border-bottom border-secondary symbols" data-symbol="'+symbol+'" id="symbol-'+symbol+'">\
                                                <td class="text-center">\
                                                    <b>\
                                                    <a target="_blank" style="width:150px !important;" href="https://www.binance.com/en/trade/'+symbol+'?type=spot">'+symbol+'</a>\
                                                    </b>\
                                                </td>\
                                                <td class="text-center" id="symbol-'+symbol+'-price">'+e.c+'</td>\
                                                <td style="text-align:left !important;" class="text-center">'+e.P+'</td>\
                                                <td class="p-0">\
                                                    <p class="m-0" style="height:15px !important;width:'+(parseFloat(e.P) * 10)+'% !important;background:green;max-width:100%;"></p>\
                                                </td>\
                                            </tr>';
                                        $('#positive-tokens').append(html);
                                    }
                                }
                            }, 10);

                            setTimeout(function(){
                                if (price_filter_positive !== '') {
                                    if (price_filter_type_positive == 'above') {
                                        if (parseFloat(e.c) < parseFloat(price_filter_positive)) {
                                            $('#positive-tokens #symbol-'+symbol).addClass('bg-danger');
                                        }
                                    } else {
                                        if (parseFloat(e.c) > parseFloat(price_filter_positive)) {
                                            $('#positive-tokens #symbol-'+symbol).addClass('bg-danger');
                                        }
                                    }
                                }
                            }, 100);

                            setTimeout(function(){
                                $('.sort').trigger('click');
                            }, 100);
                        }

                        
                    }

                    if (parseInt(time_elapsed_negative) == parseInt(averaging_time_negative)) {
                        var cps_sorting_negative = $('.cps_sorting_negative').val();
                        $('.sort-negative').attr('data-sort', cps_sorting_negative);

                        $('#negative-tokens').html("");
                        $('#symbol-'+e.s+'-current-price').html(e.c);
                        $('#symbol-'+e.s+'-price-change-percent').html(e.P);;
                        var minimum_gain_negative = $('.minimum_gain_negative').val();

                        var symbol = e.s;
                        var change = parseFloat(e.P);
                        var html2 = '';

                        var hasString = symbol.indexOf(symbol_filter);

                        if (hasString > 0) {
                            setTimeout(function(){
                                if (e.P !== "" && Math.sign(change) === -1) {
                                    if (parseFloat(e.P) > parseFloat(minimum_gain_negative)) {
                                        html2 += '<tr id="symbol-'+symbol+'" data-symbol="'+symbol+'" class="symbols border-bottom border-secondary">\
                                                <td class="text-center">\
                                                    <b>\
                                                    <a target="_blank" style="width:150px !important;" href="https://www.binance.com/en/trade/'+symbol+'?type=spot">'+symbol+'</a>\
                                                    </b>\
                                                </td>\
                                                <td class="text-center" id="symbol-'+symbol+'-price">'+e.c+'</td>\
                                                <td style="text-align:left !important;" class="text-center">'+e.P+'</td>\
                                                <td class="p-0">\
                                                    <p class="m-0" style="height:15px !important;width:'+(Math.abs(e.P) + 10)+'% !important;background:red;max-width:100%;"></p>\
                                                </td>\
                                            </tr>';
                                        
                                        $('#negative-tokens').append(html2);
                                    }
                                }
                            }, 10);

                            setTimeout(function(){
                                if (price_filter_negative !== '') {
                                    if (price_filter_type_negative == 'above') {
                                        if (parseFloat(e.c) < parseFloat(price_filter_negative)) {
                                            $('#negative-tokens #symbol-'+symbol).addClass('bg-danger');
                                        }
                                    } else {
                                        if (parseFloat(e.c) > parseFloat(price_filter_negative)) {
                                            $('#negative-tokens #symbol-'+symbol).addClass('bg-danger');
                                        }
                                    }
                                }
                            }, 100);

                            setTimeout(function(){
                                $('.sort-negative').trigger('click');
                            }, 100);
                        }


                        }
                });
                $('.feed-status').html('receiving token feeds ('+data.length+'/s)...');
            }
        };

        $(document).on('click', '#start-now', function(e){
            e.preventDefault();
            $('#form2').trigger('submit');
        });

        var interval;

        $(document).on('click', '#stop', function(){
            clearInterval(interval);
        });

        $(document).on('click', '#reset', function(){
            $('#form2').trigger('submit');
        });

        $(document).on('submit', '#form2', function(e){
            clearInterval(interval);

            setTimeout(function(){
                $('.restart').addClass('d-none');
                $('#negative-tokens').html("");
                $('#positive-tokens').html("");
            }, 2000);

            e.preventDefault();
            $('#search').html('Processing...');
            $('#search').attr('disabled', true);
            var symbol = $('select[name="symbol"]').val();
            $('#symbol').val(symbol);
            $.ajax({
                url:'{{route("coins-list2")}}',
                method:'GET',
                data:{
                    symbol:symbol
                },
                success:function(response){
                    $('#list-container').html(response);
                    $('#search').html('SEARCH');
                    $('#search').attr('disabled', false);
                    $('#start').trigger('click');
                    $('#time-elapsed').val(0);
                    $('#time-elapsed-negative').val(0);
                }, error:function(response){
                    alert("An error occurred. Re-submit request.");
                    $('#search').html('SEARCH');
                    $('#search').attr('disabled', false);
                }
            });
        });

        $(document).on('click', '#start', function(){
            $('#status').val('start');
            $('#start').html('START');
            $('#start').addClass('btn-success').removeClass('btn-warning');
            $('.elapsed').removeClass('d-none');

            startTime = new Date();
            var averaging_time_positive = (parseFloat($('.averaging_time_positive').val()) + 1);
            var averaging_time_negative = (parseFloat($('.averaging_time_negative').val()) + 1);

            interval = setInterval(function () {
                var time_elapsed = $('#time-elapsed').val();
                var time_elapsed_negative = $('#time-elapsed-negative').val();
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

                time_elapsed = (parseInt(time_elapsed) + 1);
                time_elapsed_negative = (parseInt(time_elapsed_negative) + 1);
                $('#time-elapsed').val(time_elapsed);
                $('#time-elapsed-negative').val(time_elapsed_negative);

                if (parseInt((time_elapsed)) == parseInt(averaging_time_positive)) {
                    $('#time-elapsed').val(1);
                }

                if (parseInt((time_elapsed_negative)) == parseInt(averaging_time_negative)) {
                    $('#time-elapsed-negative').val(1);
                }
            }, 1000);
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
    });
</script>
@endsection