@php
    $final = false;
@endphp

@foreach($table as $stage)
    @if($loop->count > 1)<h3 class="noqbot-pointtable-title">{{ $stage['name'] }}</h3>@endif
    @if($stage['type'] == 'table')
        <div class="swiper-slide">
            <div class="noqbot-pointtable-title">
                <div class="noqbot-box"></div>
                <div class="noqbot-box">КОМАНДА</div>
                @if($tournament->status_id != 2)
                    <div class="noqbot-box">И</div>
                    <div class="noqbot-box">В</div>
                    <div class="noqbot-box">Н</div>
                    <div class="noqbot-box">П</div>
                    <div class="noqbot-box">МЯЧИ</div>
                    <div class="noqbot-box">О</div>
                @endif
            </div>
        </div>
        <div id="noqbot-pointstable-slider" class="noqbot-pointstable-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    @foreach($stage['table'] as $tt)
                        <div class="noqbot-pointtable">
                            <div class="noqbot-box">@if($tt['place'] > 0) {{ $tt['place'] }} @endif</div>
                            <div class="noqbot-box">{{ $tt['name'] }}</div>
                            @if($tournament->status_id != 2)
                                <div class="noqbot-box">{{ $tt['games'] }}</div>
                                <div class="noqbot-box">{{ $tt['win'] }}</div>
                                <div class="noqbot-box">{{ $tt['nic'] }}</div>
                                <div class="noqbot-box">{{ $tt['los'] }}</div>
                                <div class="noqbot-box">{{ $tt['zab'] }}-{{ $tt['prop'] }}</div>
                                <div class="noqbot-box">{{ $tt['points'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        @foreach($stage['table'] as $tt)
            <div class="noqbot-pointtable">
                <div class="noqbot-box">@if($tt['place'] > 0) {{ $tt['place'] }} @endif</div>
                <div class="noqbot-box">{{ $tt['name'] }}</div>
            </div>
        @endforeach
    @endif
@endforeach
