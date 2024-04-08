@extends('layouts.app')
@section('content')
<div class="container-fluid w-100">
    <div class="col-sm-12">
        <!--- BODY *** start *** -->
        <form action="{{ route('save-settings') }}" method="POST" id="settings-form">
        @csrf
        <div class="row mt-2">
            <div class="col-sm-3 p-2" style="background:#F79B7F;">
                <table class="w-100 bg-transparent">
                    <tr>
                        <th>Weight Factor Number</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="form border border-dark wfn" name="wfn">
                        </td>
                        <!-- <td><b>Volume:</b></td>
                        <td>
                            <input type="text" class="form border border-dark wfn_volume" name="wfn_volume">
                        </td>
                        <td><b>Price:</b></td>
                        <td>
                            <input type="text" class="form border border-dark wfn_price" name="wfn_price">
                        </td>
                        <td><b>Trades:</b></td>
                        <td>
                            <input type="text" class="form border border-dark wfn_trades" name="wfn_trades">
                        </td> -->
                    </tr>
                </table>
            </div>
            <div class="col-sm-5 p-2" style="background:#FBC6B1;">
                <table class="w-100 bg-transparent">
                    <tr>
                        <th colspan="6">Past Averaging</th>
                    </tr>
                    <tr>
                        <td><b>Start:</b></td>
                        <td>
                            <input type="text" class="form border border-dark start_time" name="start_time">
                        </td>
                        <td>
                            <select name="start_time_unit" class="start_time_unit form border border-dark">
                                <option value="seconds">seconds</option>
                                <option value="minutes">minutes</option>
                                <option value="hours">hours</option>
                            </select>
                        </td>
                        <td><b>Duration:</b></td>
                        <td>
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
            <div class="col-sm-2 p-2" style="background:#9294C2;">
                <table class="w-100 bg-transparent">
                    <tr>
                        <th colspan="6">Live Averaging</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="form border border-dark live_averaging_time" name="live_averaging_time">
                        </td>
                        <td>
                            <select name="live_averaging_time_unit" class="live_averaging_time_unit form border border-dark">
                                <option value="seconds">seconds</option>
                                <option value="minutes">minutes</option>
                                <option value="hours">hours</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-2 p-2" style="background:#9294C2;">
                <table class="w-100 bg-transparent">
                    <tr>
                        <th colspan="2">Screen Refresh Frequency</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="form border border-dark srf_time" name="srf_time">
                        </td>
                        <td>
                            <select name="srf_time_unit" class="srf_time_unit form border border-dark">
                                <option value="seconds">seconds</option>
                                <option value="minutes">minutes</option>
                                <option value="hours">hours</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3 p-2" style="background:#FBC6B1;">
                <table class="w-100 bg-transparent">
                    <tr>
                        <th colspan="2">Toggle Averaging</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" class="toggle_volume" name="toggle_volume"> Volume
                            &nbsp;&nbsp;&nbsp;
                            <input type="checkbox" class="toggle_price" name="toggle_price"> Price
                            &nbsp;&nbsp;&nbsp;
                            <input type="checkbox" class="toggle_trades" name="toggle_trades"> Trades
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-9 p-2" style="background:#FBC6B1;">
                <table class="w-100 bg-transparent">
                    <tr>
                        <th colspan="2">Alert 1</th>
                        <th colspan="2">Alert 2</th>
                        <th colspan="2">Alert 3</th>
                        <th colspan="2">Alert 4</th>
                        <th colspan="2">Alert 5</th>
                    </tr>
                    <tr>
                        @for($i = 1; $i <= 5; $i++)
                        <td>
                            <input type="text" class="form border border-dark alert{{ $i }}" name="alert{{ $i }}">
                        </td>
                        <td>
                            <select name="alert{{ $i }}_type" class="alert{{ $i }}_type form border border-dark">
                                <option value="beep">Beep</option>
                                <option value="flash">Flash</option>
                                <option value="beep_flash">Beep &amp; Flash</option>
                            </select>
                        </td>
                        @endfor
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-8"></div>
            <div class="col-sm-4 p-0">
                <button type="submit" class="btn btn-success p-0 px-5 text-sm w-100" id="save-settings">SAVE SETTINGS</button>
            </div>
        </div>
        </form>
        <form action="{{ route('calculate') }}" method="POST" id="form2">
        @csrf
        <div class="row">
            <div class="col-sm-8 p-0 px-2">
                <input type="text" class="form text-sm symbol border border-dark" name="symbol" id="symbol-filter" placeholder="SYMBOL FILTER...">
                <input type="hidden" class="form text-sm symbol border border-dark" id="symbol" readonly>
            </div>
            <div class="col-sm-2 p-0">
                <button type="submit" class="btn btn-primary p-0 px-5 text-sm w-100" id="start">START</button>
                <button type="button" class="btn btn-warning p-0 px-5 text-sm w-100 d-none" id="resume">RESUME</button>
            </div>
            <div class="col-sm-2 p-0">
                <input type="hidden" id="screen-refresh" readonly>
                <button type="button" class="d-none btn btn-primary p-0 px-5 text-sm w-100" id="trigger-live">TRIGGER LIVE</button>
                <button type="button" class="btn btn-danger p-0 px-5 text-sm w-100 d-none" id="stop">STOP</button>
            </div>
        </div>
        </form>
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
function list(symbol, list)
{
    $.ajax({
        url:'{{route("calculate")}}',
        method:'GET',
        data:{
            symbol:symbol,
            list:list
        },
        dataType:'json',
        success:function(response){
            console.log(response);
            if (list) {
                $('#list-container').html(response.html);
                $('#start').html('START');
                $('#start').attr('disabled', false);
                $('#screen-refresh').val(response.screenRefresh);
                $('#trigger-live').trigger('click');
                $('#stop').removeClass('d-none');
            } else {
                var tickers = response.tickers;
                $.each(tickers, function(i, e){
                    var momentum = (e.volume * e.price) * e.wfn;
                    var momentumWidth;
                    if (momentum < 1) {
                         momentumWidth = 0;
                    } else {
                        var length = momentum.toFixed().length;
                        length = 100 * length;
                        momentumWidth = momentum / length;
                    }
                    var html = '<p class="my-0" style="background:#BDB6DE;width:'+momentumWidth.toFixed()+'%;max-width:100%;">'+momentum.toFixed(5)+'</p>';
                    $('#price-change-'+i).html(e.price);
                    $('#volume-change-'+i).html(e.volume);
                    $('#momentum-'+i).html(html);
                });

                // $('#sort').trigger('click');
            }
        }, error:function(response){
            alert("An error occurred. Re-submit request.");
            $('#start').html('START');
            $('#start').attr('disabled', false);
        }
    });
}

    $(function(){
        $(document).on('submit', '#form2', function(e){
            e.preventDefault();
            $('#start').html('Processing, please wait...');
            $('#start').attr('disabled', true);
            var symbol = $('#symbol-filter').val();
            $('#symbol').val(symbol);
            list(symbol, true);
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

        var interval;
        $(document).on('click', '#trigger-live', function(){
            var screenRefresh = $('#screen-refresh').val();
            interval = setInterval(function(){
                list($('#symbol').val(), false);
                $('#list-header').addClass('text-success');
            }, screenRefresh);
        });

        $(document).on('click', '#stop', function(){
            clearInterval(interval);
            $('#list-header').removeClass('text-success');
            $('#start').addClass('d-none');
            $('#resume').removeClass('d-none');
        });

        $(document).on('click', '#resume', function(){
            list($('#symbol').val(), false);
            $('#trigger-live').trigger('click');
            $('#start').removeClass('d-none');
            $('#resume').addClass('d-none');
        });
    });
</script>
@endsection