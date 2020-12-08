<div id="noqbot-playerscrollbar" class="noqbot-players noqbot-playerscrollbar">
    <div class="noqbot-pointtable-title-full">
        <div class="noqbot-box">{{ $tournament->name }}</div>
    </div>
    @forelse($players['forwards'] as $pl)
    <div class="noqbot-player">
        <div id="noqbot-block-container" class="col-sm-9 col-xs-12 pull-right">
            <div class="noqbot-playcontent">
			<div class="noqbot-posttitle-bestplayers"><h3><a href="{{ route('tournament_forwards', [$tournament->url]) }}">Лучший бомбардир</a></h3></div>
			<div><h3 style="margin: 4px 0;"><a href="{{ route('tournament_player', [$tournament->url, $pl->bid->person->url]) }}">{{ $pl->bid->family }} {{ $pl->bid->name }} {{ $pl->bid->surname }}</a></h3></div>
			<div id="noqbot-block-container" class="col-sm-8 col-xs-12"><h4 class="noqbot-team-name"><a href="{{ route('tournament_team',[$tournament->url, $pl->bid->team->url]) }}"><b>{{ $pl->bid->team->name }}</b></a></h4></div>
			<div id="noqbot-block-container" class="col-sm-4 col-xs-12 pull-right">
			<div class="noqbot-statistic noqbot-goals">
			<span class="noqbot-icon icon-Icon1"></span>
			<h2><span class="noqbot-statistic-count" data-from="0" data-to="15" data-speed="8000" data-refresh-interval="50">{{ $pl->games }}</span></h2>
			</div>
			<div class="noqbot-statistic noqbot-activeplayers">
			<span class="noqbot-icon icon-Icon2"></span>
			<h2><span class="noqbot-statistic-count" data-from="0" data-to="11" data-speed="8000" data-refresh-interval="50">{{ $pl->football->mvpdefenders }}</span></h2>
			</div>
			</div>
            </div>
        </div>
        <div id="noqbot-block-container" class="col-sm-3 col-xs-12" style="padding-left: 0; padding-right: 15px;">
            <div class="card profile-card-5">
                <div class="background-block"></div>
                <div class="profile-thumb-block">
                    @if($pl->bid->photo)
                        @foreach($pl->bid->photo->thumb as $photo)
                            @if($photo->thumb_id == 9)
                                <img src="{{ $photo->filename }}" alt="{{ $pl->bid->family }} {{ $pl->bid->name }} {{ $pl->bid->surname }} - команда {{ $pl->bid->team->name }}" class="profile"/>
                                @break
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    @break
    @empty
        <div><h3 style="margin: 4px 0;">Нет игроков</h3></div>
    @endforelse
    @forelse($players['assistants'] as $pl)
        <div class="noqbot-player">
            <div id="noqbot-block-container" class="col-sm-9 col-xs-12 pull-right">
                <div class="noqbot-playcontent">
				<div class="noqbot-posttitle-bestplayers"><h3><a href="{{ route('tournament_assistants', [$tournament->url]) }}">Лучший ассистент</a></h3></div>
				<div><h3 style="margin: 4px 0;"><a href="{{ route('tournament_player', [$tournament->url, $pl->bid->person->url]) }}">{{ $pl->bid->family }} {{ $pl->bid->name }} {{ $pl->bid->surname }}</a></h3></div>
				<div id="noqbot-block-container" class="col-sm-8 col-xs-12"><h4 class="noqbot-team-name"><a href="{{ route('tournament_team',[$tournament->url, $pl->bid->team->url]) }}"><b>{{ $pl->bid->team->name }}</b></a></h4></div>
				<div id="noqbot-block-container" class="col-sm-4 col-xs-12 pull-right">
				<div class="noqbot-statistic noqbot-goals">
				<span class="noqbot-icon icon-Icon1"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="15" data-speed="8000" data-refresh-interval="50">{{ $pl->games }}</span></h2>
				</div>
				<div class="noqbot-statistic noqbot-activeplayers">
				<span class="noqbot-icon icon-Icon2"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="11" data-speed="8000" data-refresh-interval="50">{{ $pl->football->mvpdefenders }}</span></h2>
				</div>
				</div>
                </div>
            </div>
            <div id="noqbot-block-container" class="col-sm-3 col-xs-12" style="padding-left: 0; padding-right: 15px;">
                <div class="card profile-card-5">
                    <div class="background-block"></div>
                    <div class="profile-thumb-block">
                        @if($pl->bid->photo)
                            @foreach($pl->bid->photo->thumb as $photo)
                                @if($photo->thumb_id == 9)
                                    <img src="{{ $photo->filename }}" alt="{{ $pl->bid->family }} {{ $pl->bid->name }} {{ $pl->bid->surname }} - команда {{ $pl->bid->team->name }}" class="profile"/>
                                    @break
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @break
    @empty
        <div><h3 style="margin: 4px 0;">Нет игроков</h3></div>
    @endforelse
    @forelse($players['defenders'] as $pl)
        <div class="noqbot-player">
            <div id="noqbot-block-container" class="col-sm-9 col-xs-12 pull-right">
                <div class="noqbot-playcontent">
				<div class="noqbot-posttitle-bestplayers"><h3><a href="{{ route('tournament_defenders', [$tournament->url]) }}">Лучший по системе "гол+пас"</a></h3></div>
				<div><h3 style="margin: 4px 0;"><a href="{{ route('tournament_player', [$tournament->url, $pl->bid->person->url]) }}">{{ $pl->bid->family }} {{ $pl->bid->name }} {{ $pl->bid->surname }}</a></h3></div>
				<div id="noqbot-block-container" class="col-sm-8 col-xs-12"><h4 class="noqbot-team-name"><a href="{{ route('tournament_team',[$tournament->url, $pl->bid->team->url]) }}"><b>{{ $pl->bid->team->name }}</b></a></h4></div>
				<div id="noqbot-block-container" class="col-sm-4 col-xs-12 pull-right">
				<div class="noqbot-statistic noqbot-goals">
				<span class="noqbot-icon icon-Icon1"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="15" data-speed="8000" data-refresh-interval="50">{{ $pl->games }}</span></h2>
				</div>
				<div class="noqbot-statistic noqbot-activeplayers">
				<span class="noqbot-icon icon-Icon2"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="11" data-speed="8000" data-refresh-interval="50">{{ $pl->football->mvpdefenders }}</span></h2>
				</div>
				</div>
                </div>
            </div>
            <div id="noqbot-block-container" class="col-sm-3 col-xs-12" style="padding-left: 0; padding-right: 15px;">
                <div class="card profile-card-5">
                    <div class="background-block"></div>
                    <div class="profile-thumb-block">
                        @if($pl->bid->photo)
                            @foreach($pl->bid->photo->thumb as $photo)
                                @if($photo->thumb_id == 9)
                                    <img src="{{ $photo->filename }}" alt="{{ $pl->bid->family }} {{ $pl->bid->name }} {{ $pl->bid->surname }} - команда {{ $pl->bid->team->name }}" class="profile"/>
                                    @break
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @break
    @empty
        <div><h3 style="margin: 4px 0;">Нет игроков</h3></div>
    @endforelse
	@forelse($players['defenders'] as $pl)
        <div class="noqbot-player">
            <div id="noqbot-block-container" class="col-sm-9 col-xs-12 pull-right">
                <div class="noqbot-playcontent">
				<div class="noqbot-posttitle-bestplayers"><h3><a href="{{ route('tournament_defenders', [$tournament->url]) }}">Лучший защитник</a></h3></div>
				<div><h3 style="margin: 4px 0;"><a href="{{ route('tournament_player', [$tournament->url, $pl->bid->person->url]) }}">{{ $pl->bid->family }} {{ $pl->bid->name }} {{ $pl->bid->surname }}</a></h3></div>
				<div id="noqbot-block-container" class="col-sm-8 col-xs-12"><h4 class="noqbot-team-name"><a href="{{ route('tournament_team',[$tournament->url, $pl->bid->team->url]) }}"><b>{{ $pl->bid->team->name }}</b></a></h4></div>
				<div id="noqbot-block-container" class="col-sm-4 col-xs-12 pull-right">
				<div class="noqbot-statistic noqbot-goals">
				<span class="noqbot-icon icon-Icon1"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="15" data-speed="8000" data-refresh-interval="50">{{ $pl->games }}</span></h2>
				</div>
				<div class="noqbot-statistic noqbot-activeplayers">
				<span class="noqbot-icon icon-Icon2"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="11" data-speed="8000" data-refresh-interval="50">{{ $pl->football->mvpdefenders }}</span></h2>
				</div>
				</div>
                </div>
            </div>
            <div id="noqbot-block-container" class="col-sm-3 col-xs-12" style="padding-left: 0; padding-right: 15px;">
                <div class="card profile-card-5">
                    <div class="background-block"></div>
                    <div class="profile-thumb-block">
                        @if($pl->bid->photo)
                            @foreach($pl->bid->photo->thumb as $photo)
                                @if($photo->thumb_id == 9)
                                    <img src="{{ $photo->filename }}" alt="{{ $pl->bid->family }} {{ $pl->bid->name }} {{ $pl->bid->surname }} - команда {{ $pl->bid->team->name }}" class="profile"/>
                                    @break
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @break
    @empty
        <div><h3 style="margin: 4px 0;">Нет игроков</h3></div>
    @endforelse
	@forelse($players['defenders'] as $pl)
        <div class="noqbot-player">
            <div id="noqbot-block-container" class="col-sm-9 col-xs-12 pull-right">
                <div class="noqbot-playcontent">
				<div class="noqbot-posttitle-bestplayers"><h3><a href="{{ route('tournament_defenders', [$tournament->url]) }}">Лучший вратарь</a></h3></div>
				<div><h3 style="margin: 4px 0;"><a href="{{ route('tournament_player', [$tournament->url, $pl->bid->person->url]) }}">{{ $pl->bid->family }} {{ $pl->bid->name }} {{ $pl->bid->surname }}</a></h3></div>
				<div id="noqbot-block-container" class="col-sm-8 col-xs-12"><h4 class="noqbot-team-name"><a href="{{ route('tournament_team',[$tournament->url, $pl->bid->team->url]) }}"><b>{{ $pl->bid->team->name }}</b></a></h4></div>
				<div id="noqbot-block-container" class="col-sm-4 col-xs-12 pull-right">
				<div class="noqbot-statistic noqbot-goals">
				<span class="noqbot-icon icon-Icon1"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="15" data-speed="8000" data-refresh-interval="50">{{ $pl->games }}</span></h2>
				</div>
				<div class="noqbot-statistic noqbot-activeplayers">
				<span class="noqbot-icon icon-Icon2"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="11" data-speed="8000" data-refresh-interval="50">{{ $pl->football->mvpdefenders }}</span></h2>
				</div>
				</div>
                </div>
            </div>
            <div id="noqbot-block-container" class="col-sm-3 col-xs-12" style="padding-left: 0; padding-right: 15px;">
                <div class="card profile-card-5">
                    <div class="background-block"></div>
                    <div class="profile-thumb-block">
                        @if($pl->bid->photo)
                            @foreach($pl->bid->photo->thumb as $photo)
                                @if($photo->thumb_id == 9)
                                    <img src="{{ $photo->filename }}" alt="{{ $pl->bid->family }} {{ $pl->bid->name }} {{ $pl->bid->surname }} - команда {{ $pl->bid->team->name }}" class="profile"/>
                                    @break
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @break
    @empty
        <div><h3 style="margin: 4px 0;">Нет игроков</h3></div>
    @endforelse
</div>
<!-- <div class="noqbot-btnbox">
    <a class="noqbot-btn" href="#"><span>Подробнее...</span></a>
    <div class="noqbot-themebtnnext"><span class="fa fa-angle-down"></span></div>
    <div class="noqbot-themebtnprev"><span class="fa fa-angle-up"></span></div>
</div> -->
