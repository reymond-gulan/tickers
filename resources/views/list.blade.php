
<input type="hidden" id="block-count" value="{{ $options ?? 10 }}" readonly>
<div class="alert alert-success qualifying_status p-0 p-1 m-0 text-center" style="font-style:italic;font-weight:bold;"></div>
<table class="w-100 bg-transparent tokens-table d-none" id="table">
    <thead style="cursor:pointer;">
        <tr id="list-header" class="border-bottom border-dark">
            <th style="width:30px;"></th>
            <th style="width:60px !important;" class="sym">SYMBOL</th>
            <th class="d-none"></th>
            <th class="d-none">PRE-QUALIFYING <br />AVERAGE</th>
            <th class="d-none">QUALIFYING <br />AVERAGE</th>
            <th style="width:60px !important;" class="volume_change">PRICE <br />CHANGE</th>
            <th class="d-none"></th>
            <th class="d-none">QUALIFYING TIME</th>
            <th class="d-none">CURRENT TIME</th>
            <th class="d-none">ELAPSED (seconds)</th>
            <th class="elapsed_time d-none">ELAPSED TIME</th>
            <th style="width:60px !important;">START<br /> PRICE</th>
            <th style="width:60px !important;">LATEST<br /> PRICE</th>
            <th style="width:60px !important;" class="accum_change">ACCUMULATED<br /> CHANGE</th>
            <th style="width:60px !important;" class="change_percent">GAIN/LOSS</th>
            <th style="width:60px !important;" class="change_per_second">CHANGE % per SECOND</th>
            <th class="d-none"></th>
            <th class="sort d-none"></th>
            <th class="dummy-sort"></th>
        </tr>
    </thead>
    <tbody class="symbols-body">
        @foreach($symbols as $key => $symbol)
            @php
                $symbol = $symbol['symbol'];
            @endphp
            <tr data-symbol="{{ $symbol }}" id="symbol-{{ $symbol }}" class="symbols border-bottom border-dark">
                <td class="text-center" id="symbol-{{ $symbol }}-ranking" class="ranking"></td>
                <td class="text-center">
                    <b>
                    <a target="_blank" href="https://www.binance.com/en/trade/{{ $symbol }}?type=spot">
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
                <td class="text-center d-none"><span class="badge bg-secondary text-sm" id="symbol-{{ $symbol }}-qualifying-time">{{ now()->addSeconds($sub)->format('h:i:s a') }}</span></td>
                <td class="text-center d-none"><span class="badge bg-secondary text-sm" id="symbol-{{ $symbol }}-current-time"></span></td>
                <td class="text-center d-none" id="symbol-{{ $symbol }}-elapsed"></td>
                <td class="text-center d-none" id="symbol-{{ $symbol }}-elapsed-time"></td>
                <td class="text-center" id="symbol-{{ $symbol }}-price"></td>
                <td class="text-center" id="symbol-{{ $symbol }}-latest"></td>
                <td class="text-center d-none" id="symbol-{{ $symbol }}-latest-price"></td>
                <td class="text-center h4" id="symbol-{{ $symbol }}-change"></td>
                <td class="text-center h4" id="symbol-{{ $symbol }}-change-percentage"></td>
                <td class="text-center h4" id="symbol-{{ $symbol }}-change-per-second"></td>
                <td class="text-center h4 d-none" id="symbol-{{ $symbol }}-price-change-percentage"></td>
                <td class="text-center h4 d-none" id="symbol-{{ $symbol }}-price-change-percent"></td>
                <td id="symbol-{{ $symbol }}-indicator"></td>
            </tr>
        @endforeach
    </tbody>
</table>