<div class="box box-1">
    <div class="box_header gray_border">
        <span class="box_title">Сыгранные матчи</span>
    </div>
    <div class="schedule_box">
        @forelse($prevMatches as $game)
            <div class="schedule">
                <div class="home_team"><span><a href=https://adatbank.mlsz.hu/club/52/0/20850/16/193801.html target=_blank>{{ $game->home->name }}</a></span></div>
                <div class="home_logo"><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/4/3520.gif" width="20" ></div>
                <div class="result-cont"><a href="https://ada1bank.mlsz.hu/match?itemId=1446324" target=_blank><div class="result"><span class="schedule-points">{{ $game->homescore }} - {{ $game->awayscore }}</span></div></a></div>
                <div class="away_logo"><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/12/11774.png" width="20"></div>
                <div class="away_team"><span><a href=https://adatbank.mlsz.hu/club/52/0/20850/16/193805.html target=_blank>{{ $game->away->name }}</a></span>
                </div>
                <div class="">
                    <a href="{{ url('/youtube') }}" target="_blank" class="match_video"><img src="{{ asset('/images/youtube_icon.png') }}" width=20  style="vertical-align: middle;"></a>
                </div>
            </div>
        @empty
            <div class="turn_number">
                <span>НЕТ СЫГРАННЫХ МАТЧЕЙ</span>
            </div>
        @endforelse
</div>
</div>
<div class="box box-2">
    <div class="box_header gray_border">
        <span class="box_title">Следующие матчи</span>
    </div>
    <div class="schedule_box">
        @forelse($nextMatches as $game)
        <div class="schedule">
            <div class="home_team"><span><a href="{{ route('tournament_match', [$tournament->url, $game->id]) }}" target="_blank">{{ $game->home->name }}</a></span></div> @if($game->home && $game->home->logo)@foreach($game->home->logo->thumb as $tt){{ $tt->fileName }} @endforeach @endif
                <div class="home_logo "><a href="{{ route('tournament_match', [$tournament->url, $game->id]) }}" target="_blank">@if($game->home && $game->home->logo)<img src="{{ asset($game->home->logo->thumb->first()->fileName) }}" width="20">@endif</a></div>
                <div class="result-cont"><div class="result">@if($game->datetime)<span class="schedule-date">{{ date('d.m', strtotime($game->datetime)) }}</span><span>{{ date('H:i', strtotime($game->datetime)) }}</span>@endif</div></div>
                <div class="away_logo "><a href="{{ route('tournament_match', [$tournament->url, $game->id]) }}" target="_blank">@if($game->away && $game->away->logo)<img src="{{ asset($game->away->logo->name) }}" width="20">@endif</a></div>
            <div class="away_team"><span><a href="{{ route('tournament_match', [$tournament->url, $game->id]) }}" target="_blank">{{ $game->away->name }}</a></span></div>
        </div>
        @empty
            <div class="turn_number">
                <span>НЕТ СЫГРАННЫХ МАТЧЕЙ</span>
            </div>
        @endforelse
    </div>
</div>
<div class="box box-3"><div class="box_header gray_border">
        <span class="box_title">Таблица</span>
    </div>
    <div class="standings_box">

        <table>
            <thead>
            <tr>
                <th width="25">#</th>
                <th width="20"></th>
                <th align="left">Команда</th>
                <th>И</th>
                <th>В</th>
                <th>Н</th>
                <th>П</th>
                <th>Мячи</th>
                <th>О</th>
            </tr>
            </thead>
            <tbody id="main_league_standings">
            <tr onclick=window.open("https://adatbank.mlsz.hu/club/52/0/20850/17/193800.html","_blank")>
                <td class="standing_position">1</td>
                <td width="15" class=><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/13/12402.png" width="15"></td>
                <td class="standing_bold">FERENCVÁROSI TC</td>
                <td>15</td>
                <td>11</td>
                <td>3</td>
                <td>1</td>
                <td>15</td>
                <td class="standing_bold">36</td>
            </tr>
            <tr onclick=window.open("https://adatbank.mlsz.hu/club/52/0/20850/17/193799.html","_blank")>
                <td class="standing_top_position">2</td>
                <td width="15" class=><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/13/12379.png" width="15"></td>
                <td class="standing_bold">MOL FEHÉRVÁR FC</td>
                <td>16</td>
                <td>10</td>
                <td>2</td>
                <td>4</td>
                <td>14</td>
                <td class="standing_bold">32</td>
            </tr>
            <tr onclick=window.open("https://adatbank.mlsz.hu/club/52/0/20850/17/193805.html","_blank")>
                <td class="standing_top_position">3</td>
                <td width="15" class=><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/12/11774.png" width="15"></td>
                <td class="standing_bold">MEZŐKÖVESD ZSÓRY FC</td>
                <td>16</td>
                <td>8</td>
                <td>4</td>
                <td>4</td>
                <td>7</td>
                <td class="standing_bold">28</td>
            </tr>
            <tr onclick=window.open("https://adatbank.mlsz.hu/club/52/0/20850/17/193809.html","_blank")>
                <td class="">4</td>
                <td width="15" class=><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/12/11493.png" width="15"></td>
                <td class="standing_bold">PUSKÁS AKADÉMIA FC</td>
                <td>16</td>
                <td>7</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td class="standing_bold">25</td>
            </tr>
            <tr onclick=window.open("https://adatbank.mlsz.hu/club/52/0/20850/17/193798.html","_blank")>
                <td class="">5</td>
                <td width="15" class=><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/13/12347.png" width="15"></td>
                <td class="standing_bold">ÚJPEST FC</td>
                <td>16</td>
                <td>7</td>
                <td>3</td>
                <td>6</td>
                <td>1</td>
                <td class="standing_bold">24</td>
            </tr>
            <tr onclick=window.open("https://adatbank.mlsz.hu/club/52/0/20850/17/193803.html","_blank")>
                <td class="">6</td>
                <td width="15" class=><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/4/3420.gif" width="15"></td>
                <td class="standing_bold">BUDAPEST HONVÉD</td>
                <td>16</td>
                <td>7</td>
                <td>3</td>
                <td>6</td>
                <td>-1</td>
                <td class="standing_bold">24</td>
            </tr>
            <tr onclick=window.open("https://adatbank.mlsz.hu/club/52/0/20850/17/193808.html","_blank")>
                <td class="">7</td>
                <td width="15" class=><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/12/11498.png" width="15"></td>
                <td class="standing_bold">KISVÁRDA MASTER GOOD</td>
                <td>16</td>
                <td>6</td>
                <td>2</td>
                <td>8</td>
                <td>-4</td>
                <td class="standing_bold">20</td>
            </tr>
            <tr onclick=window.open("https://adatbank.mlsz.hu/club/52/0/20850/17/193802.html","_blank")>
                <td class="">8</td>
                <td width="15" class=><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/12/11492.png" width="15"></td>
                <td class="standing_bold">DVSC</td>
                <td>15</td>
                <td>6</td>
                <td>1</td>
                <td>8</td>
                <td>-5</td>
                <td class="standing_bold">19</td>
            </tr>
            <tr onclick=window.open("https://adatbank.mlsz.hu/club/52/0/20850/17/193804.html","_blank")>
                <td class="">9</td>
                <td width="15" class=><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/4/3320.gif" width="15"></td>
                <td class="standing_bold">DVTK</td>
                <td>16</td>
                <td>6</td>
                <td>1</td>
                <td>9</td>
                <td>-8</td>
                <td class="standing_bold">19</td>
            </tr>
            <tr onclick=window.open("https://adatbank.mlsz.hu/club/52/0/20850/17/193801.html","_blank")>
                <td class="">10</td>
                <td width="15" class=><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/4/3520.gif" width="15"></td>
                <td class="standing_bold">PAKSI FC</td>
                <td>16</td>
                <td>5</td>
                <td>2</td>
                <td>9</td>
                <td>-9</td>
                <td class="standing_bold">17</td>
            </tr>
            <tr onclick=window.open("https://adatbank.mlsz.hu/club/52/0/20850/17/193806.html","_blank")>
                <td class="standing_last_position">11</td>
                <td width="15" class=><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/12/11504.png" width="15"></td>
                <td class="standing_bold">ZTE FC</td>
                <td>16</td>
                <td>4</td>
                <td>5</td>
                <td>7</td>
                <td>1</td>
                <td class="standing_bold">17</td>
            </tr>
            <tr onclick=window.open("https://adatbank.mlsz.hu/club/52/0/20850/17/193807.html","_blank")>
                <td class="standing_last_position">12</td>
                <td width="15" class=><img src="https://adatbank.mlsz.hu/img/EgyesuletLogo/Logo/12/11546.png" width="15"></td>
                <td class="standing_bold">KAPOSVÁRI RÁKÓCZI FC</td>
                <td>16</td>
                <td>3</td>
                <td>0</td>
                <td>13</td>
                <td>-17</td>
                <td class="standing_bold">9</td>
            </tr>
            </tbody>
        </table>
        <div class="tab-more-cont"><a href="https://adatbank.mlsz.hu/league/52/0/20850/17.html" target=_blank rel="noreferrer" class="tab-more" title="Показать полную таблицу">Полная таблица<span class="fa fa-angle-right"></span></a></div>
    </div>
</div>
</div>
