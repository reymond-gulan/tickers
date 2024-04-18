
<input type="hidden" id="block-count" value="{{ $options ?? 10 }}" readonly>
<div class="alert alert-success qualifying_status p-0 p-1 m-0 text-center" style="font-style:italic;font-weight:bold;"></div>
<table class="w-100 bg-transparent tokens-table d-none" id="table">
    <thead style="cursor:pointer;">
        <tr id="list-header" class="border-bottom border-secondary">
            <th></th>
            <th class="sym">SYMBOL</th>
            <th class="d-none"></th>
            <th class="d-none">PRE-QUALIFYING AVERAGE</th>
            <th class="d-none">QUALIFYING AVERAGE</th>
            <th class="volume_change">VOLUME CHANGE</th>
            <th class="d-none"></th>
            <th>QUALIFYING TIME</th>
            <th>CURRENT TIME</th>
            <th class="d-none">ELAPSED (seconds)</th>
            <th class="elapsed_time">ELAPSED TIME</th>
            <th>START PRICE</th>
            <th>LATEST PRICE</th>
            <th class="accum_change">ACCUM. CHANGE</th>
            <th class="change_percent" data-sort="desc">CHANGE %</th>
            <th class="change_per_second">CHANGE per SECOND</th>
        </tr>
    </thead>
    <tbody class="symbols-body">
        @foreach($symbols as $symbol)
            @php
                $symbol = $symbol['symbol'];
            @endphp
            <tr data-symbol="{{ $symbol }}" id="symbol-{{ $symbol }}" class="symbols border-bottom border-secondary">
                <td id="symbol-{{ $symbol }}-ranking" class="ranking"></td>
                <td class="text-center">
                    <b>
                    <a target="_blank" style="width:150px !important;" href="https://www.binance.com/en/trade/{{ $symbol }}?type=spot">
                        @if (!empty($sym) && $sym !== "ALL")
                            {{ str_replace($sym, "", $symbol) }}
                        @else
                            {{ $symbol }}
                        @endif
                    </a>
                    </b>
                </td>
                <td class="d-none">
                    <input class="form-control" id="symbol-{{ $symbol }}-volume" class="volume text-xs border-0">
                </td>
                <td class="d-none" id="symbol-{{ $symbol }}-initial-volume-value"><!--- INITIAL VOLUME VALUE --></td>
                <td class="d-none" id="symbol-{{ $symbol }}-final-volume-value"><!--- FINAL VOLUME VALUE --></td>
                <td class="text-center" id="symbol-{{ $symbol }}-volume-average"><!--- VOLUME AVERAGE (QVPS) --></td>
                <td class="d-none">
                    <input class="form-control" id="symbol-{{ $symbol }}-live-price" class="live-price">
                </td>
                <td class="text-center d-none"><span class="badge bg-secondary text-sm" id="symbol-{{ $symbol }}-time">{{ strtotime(now()->addSeconds($sub)) }}</span></td>
                <td class="text-center"><span class="badge bg-secondary text-sm" id="symbol-{{ $symbol }}-qualifying-time">{{ now()->addSeconds($sub)->format('h:i:s a') }}</span></td>
                <td class="text-center"><span class="badge bg-secondary text-sm" id="symbol-{{ $symbol }}-current-time"></span></td>
                <td class="text-center d-none" id="symbol-{{ $symbol }}-elapsed"></td>
                <td class="text-center" id="symbol-{{ $symbol }}-elapsed-time"></td>
                <td class="text-center" id="symbol-{{ $symbol }}-price"></td>
                <td class="text-center" id="symbol-{{ $symbol }}-latest"></td>
                <td class="text-center d-none" id="symbol-{{ $symbol }}-latest-price"></td>
                <td class="text-center h4" id="symbol-{{ $symbol }}-change"></td>
                <td class="text-center h4" id="symbol-{{ $symbol }}-change-percentage"></td>
                <td class="text-center h4" id="symbol-{{ $symbol }}-change-per-second"></td>
            </tr>
        @endforeach
    </tbody>
</table>