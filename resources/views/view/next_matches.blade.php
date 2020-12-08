@if($tournament)
    <div id="noqbot-upcomingmatch-slider" class="noqbot-upcomingmatch-slider noqbot-upcomingmatch">
        <div class="noqbot-pointtable-title-full">
            <div id="matches_name" class="noqbot-box">{{ $tournament->name }}</div>
        </div>
        <div class="swiper-wrapper">
            @forelse(/*$matches->sortByDesc('datetime')*/ $matches as $match)
                @if ($match->status_id != 2)
                    @continue
                @endif
                <div class="swiper-slide">
                    <div class="noqbot-ticket">
                        <time class="noqbot-matchdate" datetime="{{ $match->datetime }}">{{ date('d', strtotime($match->datetime)) }}<span>{{ Matches::monthName(date('n', strtotime($match->datetime))) }}</span></time>
                        <div class="noqbot-matchdetail">
                            <span class="noqbot-theme-tag">{{ $match->tour->name }}</span>
                            <h4>{{ $match->home->name }}<span> - </span>{{ $match->away->name }}</h4>
                            <ul class="noqbot-matchmetadata">
                                <li><address><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>{{ date('H:m', strtotime($match->datetime)) }}</address></li>
                                <li><address><i id="noqbot-news-clock-icon" class="fa fa-info-circle"></i>{{ $match->place->field->arena->name }}: {{ $match->place->field->name }}</address></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div>Нет предстоящих матчей в соревновании</div>
            @endforelse
        </div>
    </div>
@endif
