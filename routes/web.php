<?php

Route::get('/', 'WelcomeController@index');

// НОВОСТИ
Route::get('/news/all', 'NewsController@showAll')->name('newsAll');
Route::get('/news/all/{offset}/{limit}', 'NewsController@showAll')->name('newsAllOffset');
Route::get('/news/{url}', 'NewsController@show')->name('news');

Route::get('/redirect/{to}', 'WelcomeController@redirect')->name('redirect');

Route::get('/matches', 'Sport\TournMatchesController@matchesAll')->name('matchesAll');

//Route::get('/match/{match_id}', 'Sport\TournPlayersController@eventsMatch'); /// TEST TODO удалить потом

// ЧЕМПИОНАТ
Route::group(['prefix'=>'tournament'], function() {
    Route::get('/all', 'Sport\TournamentController@showAll')->name('tournament_all');
    Route::get('/{url}', 'Sport\TournamentController@show')->name('tournament');
    Route::get('/{url}/matches', 'Sport\TournMatchesController@calendar')->name('tournament_calendar');
    Route::get('/{url}/match/{id}', 'Sport\TournMatchesController@show')->name('tournament_match');
    Route::get('/{url}/team/{id}', 'Sport\TournamentController@showTeam')->name('tournament_team');
    Route::get('/{url}/player/{url_player}', 'Sport\TournPlayersController@show')->name('tournament_player');
    Route::get('/{url}/forwards', 'Sport\TournPlayersController@forwards')->name('tournament_forwards');
    Route::get('/{url}/assistants', 'Sport\TournPlayersController@forwards')->name('tournament_assistants');
    Route::get('/{url}/defenders', 'Sport\TournPlayersController@forwards')->name('tournament_defenders');
});

// для панели с выбором структуры турнира
Route::get('/sport/{sport}/season/{season}/tournament/{tournament}', 'Sport\TournamentController@tournamentView')->name('tournament_view');
Route::get('/sport/{sport}/season/{season}/tournament/{tournament}/html/{generateHTML}', 'Sport\TournamentController@tournamentView')->name('tournament_view_html');

// ВИДЖЕТЫ
Route::group(['prefix'=>'widgets'], function() {
    Route::get('/tournaments', 'WidgetsController@tournaments')->name('widgets_tournaments');
    Route::get('/matches/{id}', 'Sport\TournMatchesController@matches')->name('widgets_matches');
    Route::post('/tournaments/view', 'WidgetsController@tournamentView')->name('widgets_tournament');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'home','middleware'=>'auth'], function() {

    Route::get('/profile/{id}', 'HomeController@profile')->name('profile');
    Route::post('/profile/{id}', 'HomeController@profileUpdate')->name('profile_update');
    Route::get('/profile/{id}/delete', 'HomeController@userDelete');
    Route::get('/users', 'HomeController@users')->middleware('is_admin')->name('users');
    Route::get('/users/added', 'HomeController@usersAdded')->middleware('is_admin');

    // ОБЩЕЕ
    Route::get('/cookie', 'WelcomeController@cookie')->name('cookie');

    // НОВОСТИ
    Route::get('/news', 'NewsController@adminIndex')->name('admin_news');
    Route::get('/news/{id}', 'NewsController@adminShow');
    Route::post('/news', 'NewsController@save');
    Route::patch('/news', 'NewsController@update');
    Route::delete('/news', 'NewsController@remove');
    Route::post('/news/archive', 'NewsController@moveToArchive');

    // ЛЮДИ
    Route::get('/person', 'Sport\PersonController@adminIndex')->name('admin_person');
    Route::get('/person/load', 'Sport\PersonController@load')->name('person_ajaxload');
    Route::get('/person/bidload', 'Sport\PersonController@bidLoad')->name('person_ajaxbidload');
    Route::get('/person/{id}', 'Sport\PersonController@adminShow')->name('person_ajaxshow');
    Route::post('/person', 'Sport\PersonController@save')->name('person_save');
    Route::patch('/person', 'Sport\PersonController@update')->name('person_update');

    // ТУРНИРЫ
    Route::get('/tournament/{id}', 'Sport\TournamentController@adminShowTournament')->name('admin_showtournament');
    Route::get('/tournament/{id}/stages', 'Sport\TournamentController@tournStages')->name('admin_showstages'); // показать этапы соревнования
    Route::get('/tournament/{id}/teams', 'Sport\TournBidsController@teams')->name('admin_showbidteams');// команды в турнире
    Route::get('/tournament/{id}/calendar', 'Sport\TournMatchesController@adminIndex')->name('admin_calendar');// календарь в турнире
    Route::get('/tournament/{id}/settings', 'Sport\TournamentController@adminShowTournamentSettings')->name('admin_settings');// настройки в турнире
    Route::get('/tournament/{tourn_id}/team/{team_id}', 'Sport\TournMatchesController@adminTeamPlayers')->name('admin_teamplayers');// игроки в команде на настоящее время

    // МАТЧИ
    Route::post('/tournament/calendar', 'Sport\TournMatchesController@save')->name('admin_savematch');// добавить матч в календарь в турнире
    Route::delete('/tournament/calendar', 'Sport\TournMatchesController@remove')->name('admin_removematch');// удалить матч в календарь в турнире
    Route::patch('/tournament/calendar', 'Sport\TournMatchesController@update')->name('admin_editmatch');// изменить матч
    Route::put('/tournament/calendar/result', 'Sport\TournMatchesController@result')->name('admin_resultmatch');// ввести результат
    Route::put('/tournament/calendar/currentscore', 'Sport\TournMatchesController@scoreChange')->name('admin_savescore');// сохранить счёт
    Route::put('/tournament/calendar/currentfoul', 'Sport\TournMatchesController@foulChange')->name('admin_savefoul');// сохранить фолы в матче
    Route::put('/tournament/calendar/currentforma', 'Sport\TournMatchesController@formaChange')->name('admin_saveforma');// сохранить фолы в матче
    Route::patch('/tournament/calendar/state', 'Sport\TournMatchesController@stateMatch')->name('admin_statematch');// ввести результат
    Route::put('/tournament/calendar/cancel', 'Sport\TournMatchesController@cancelResult')->name('admin_cancelresultmatch');// отменить результат
    Route::get('/tournament/match/{id}', 'Sport\TournMatchesController@protocol')->name('admin_protocolmatch');// загрузить протол матча для редактирования
    Route::post('/match/team/save', 'Sport\TournMatchesController@saveTeam')->name('admin_saveteammatch');// сохранить состав команды
    Route::post('/match/event/save', 'Sport\TournMatchesController@saveEvent')->name('admin_saveeventmatch');// сохранить событие в матче
    Route::post('/match/minute/save', 'Sport\TournMatchesController@saveGKMinute')->name('admin_saveminutematch');// сохранить минуты игрока в матче
    Route::post('/match/viewers/save', 'Sport\TournMatchesController@saveViewers')->name('admin_saveviewersmatch');// сохранить количество зрителей
    Route::post('/match/shots/save', 'Sport\TournMatchesController@saveShots')->name('admin_saveshotsmatch');// сохранить количество ударов
    Route::post('/match/mvp/save', 'Sport\TournMatchesController@saveMVP')->name('admin_savemvpmatch');// сохранить MVP в матч
    Route::post('/match/bestdefender/save', 'Sport\TournMatchesController@saveDefender')->name('admin_savedefendermatch');// сохранить MVP в матч
    Route::delete('/match/event/remove', 'Sport\TournMatchesController@removeEvent')->name('admin_removeeventmatch');// удалить событие в матче

    // ЗАЯВКИ
    Route::get('/tournament/{id}/bids', 'Sport\TournBidsController@adminIndex')->name('admin_showbids');
    Route::get('/tournament/{id}/bids/load', 'Sport\TournBidsController@load')->name('bid_ajaxload');
    Route::post('/tournament/{id}/bids', 'Sport\TournBidsController@save')->name('bid_save');
    Route::post('/tournament/settings', 'Sport\TournamentController@settingSave')->name('setting_add');        // добавить настройку к чемпионату
    Route::put('/tournament/settings', 'Sport\TournamentController@settingChange')->name('setting_change');    // изменить настройку к чемпионату
    Route::delete('/tournament/settings', 'Sport\TournamentController@settingRemove')->name('setting_remove');  // удалить настройку из чемпионата
    Route::get('/tournament/team/{team}', 'Sport\TeamController@adminTournamentTeam')->name('admin_showteam'); // карточка команды в турнире
    Route::get('/tournament/team/{team}/bid/{bid}', 'Sport\TeamController@adminTournamentBidTeam')->name('admin_showbidteam'); // карточка команды в турнире
    Route::post('/tournament/team/{team}/bid/{bid}', 'Sport\TournBidsController@adminSavePerson')->name('admin_savebidteamperson'); // добавить участника (игрок, тренер) к заявке
    Route::delete('/tournament/team/{team}/bid/{bid}', 'Sport\TournBidsController@adminRemovePerson')->name('admin_removebidteamperson'); // удалить участника (игрок, тренер) к заявке
    Route::patch('/tournament/team/{team}/bid/{bid}', 'Sport\TournBidsController@adminCancelRemovePerson')->name('admin_cancelremovebidteamperson'); // вернуть участника (игрок, тренер) в команду. отменить отзаявку

    //  ДИСКВАЛИФИКАЦИИ
    Route::get('/tournament/{id}/disq', 'Sport\TournDisqController@adminIndex')->name('admin_showdisq');    // список дисквалифицированных
    Route::patch('/tournament/disq', 'Sport\TournDisqController@change')->name('admin_tourndisqplayerchange');    // изменить параметры дисквалификации
    Route::post('/tournament/disq', 'Sport\TournDisqController@disqAddPlayer')->name('admin_tournadddisqplayer');    // добавить новую дисквалификации
    Route::delete('/tournament/disq', 'Sport\TournDisqController@disqDeletePlayer')->name('admin_tourndeletedisqplayer'); // удалить дисквалификацию

    Route::get('/admin', 'AdminController@admin')
        ->middleware('is_admin')
        ->name('admin');

    Route::get('/tournlist', 'Sport\TournListController@index')->name('tournlist');
    Route::get('/tournlist/{id}', 'Sport\TournListController@delete')->name('tournlist_delete');
    Route::post('/tournlist', 'Sport\TournListController@store');

    // загрузка фото
    Route::get('/images/load', 'Images\ImageController@load');
    Route::post('/images/load', 'Images\ImageController@upload');
    Route::post('/images/upload_desc', 'Images\ImageController@uploadDesc');

    // новости
    Route::get('/news/all', 'NewsController@newsAll');
    Route::post('/news/images/load', 'NewsController@loadPhotos')->name('loadNewsPhoto');

    // формы с вьюхами
    Route::group(['prefix'=>'views','middleware'=>'auth'], function() {
        Route::post('/match/team', 'Sport\TournMatchesController@teamView')->name('admin_teammatchview');// вьюха для ввода состава команды
        Route::post('/match/playedminute', 'Sport\TournMatchesController@playerMinuteView')->name('admin_playedminutehview');// вьюха для ввода состава команды
        Route::post('/match/edit', 'Sport\TournMatchesController@editView')->name('admin_editmatchview');// вьюха для ввода изменений
        Route::post('/match/result', 'Sport\TournMatchesController@resultView')->name('admin_resultmatchview');// вьюха для ввода результата
        Route::post('/match/forma', 'Sport\TournMatchesController@formaView')->name('admin_formamatchview');   // вьюха для ввода формы команды
        Route::post('/tournament/settings', 'Sport\TournamentController@settingsView')->name('admin_tournsettingsview'); // вьюха для ввода настроек
        Route::post('/tournament/disqplayer', 'Sport\TournDisqController@disqPlayerView')->name('admin_tourndisqplayerview'); // вьюха для вывода параметров дисквалификации игрока
        Route::post('/tournament/disqaddplayer', 'Sport\TournDisqController@disqAddPlayerView')->name('admin_tournadddisqplayerview'); // вьюха для ввода новой дисквалификации игрока
    });
});

// Игроки
Route::get('/person/{url}', 'Sport\PersonController@person')->name('person');

Route::group(['prefix'=>'api'], function() {
    Route::get('/sports', 'Sport\TournamentController@sports')->name('api_sports');
    Route::get('/sports/all', 'Sport\TournamentController@sportsAll')->name('api_sports_all');
    Route::get('/leagues', 'Sport\LeaguesController@all')->name('api_leagues');
    Route::get('/tournaments/topmatches/{limit}', 'Sport\TournMatchesController@lentaAllSport')->name('api_tournaments_lentaallsport'); // лента для всех видов спорта (для моб.приложения)
    Route::get('/tournaments/{league}/all', 'Sport\TournamentController@tournaments')->name('api_tournaments');
    Route::get('/tournaments/{league}/sport/{sport}/season/{season}', 'Sport\TournamentController@tournamentsSeasonSport')->name('api_tournaments_seasonsport');
    Route::get('/tournaments/{championats}/matches/lastfirst', 'Sport\TournMatchesController@lentaMatches')->name('api_tournaments_matches');

    Route::get('/tournaments/{championat}/teams', 'Sport\TournamentController@tournamentTeams')->name('api_tournaments_teams');
    Route::get('/tournament/{id}/stages', 'Sport\TournamentController@tournStages')->name('api_tournaments_stages'); // показать этапы соревнования
    Route::get('/tournament/{id}/struct', 'Sport\TournamentController@tournStagesTree')->name('api_tournaments_struct'); // показать этапы соревнования
    Route::get('/tournament/{id}/stage/{stage_id}/table', 'Sport\TournamentController@tournTable')->name('api_tournaments_table'); // показать турнирную таблицу этапа соревнования
    Route::get('/tournament/{id}/table', 'Sport\TournamentController@table')->name('api_tournaments_currenttable'); // показать турнирную таблицу текущего этапа соревнования
    Route::get('/tournament/{id}/grid', 'Sport\TournamentController@grid')->name('api_tournaments_grid'); // показать турнирную сетку для плейофф
    Route::get('/tournament/{id}/place', 'Sport\TournamentController@tournPlace')->name('api_tournaments_place'); // показать места окончившегося турнира
    Route::get('/tournament/{id}/tableplace', 'Sport\TournMatchesController@matchStage')->name('api_tournaments_tableplace'); // показать места в продолж.турнире
    Route::get('/tournament/{id}/matches', 'Sport\TournMatchesController@matches')->name('api_tournament_matches');    // все матчи соревнования
    Route::get('/tournament/{id}/disq', 'Sport\TournDisqController@disq')->name('api_tournament_disq');    // дисквалифицированные игроки в соревновании
    Route::get('/tournament/{id}/players/bestforwards', 'Sport\TournPlayersController@topPlayers')->name('api_tournament_forwards');    // лучшие форварды
    Route::get('/tournament/{id}/players/bestassistants', 'Sport\TournPlayersController@topAssistants')->name('api_tournament_assistants');// лучшие ассистенты
    Route::get('/tournament/{id}/players/bestpoints', 'Sport\TournPlayersController@topBombardirs')->name('api_tournament_points');// лучшие по гол + пас
    Route::get('/tournament/{id}/players/bestdefenders', 'Sport\TournPlayersController@topDefenders')->name('api_tournament_defenders');// лучшие защитники
    Route::get('/tournament/{id}/players/bestplayers', 'Sport\TournPlayersController@topBestPlayers')->name('api_tournament_topplayers');// лучшие топ игроки
    Route::get('/tournament/{id}/players/goalkeepers', 'Sport\TournPlayersController@topBestGoalkeepers')->name('api_tournament_topgoalkeepers');// лучшиие вратари турнира
    Route::get('/tournament/{id}/players/yellowcards', 'Sport\TournPlayersController@yellowCards')->name('api_tournament_yellowcards');// ЖК турнира
    Route::get('/tournament/{id}/players/redcards', 'Sport\TournPlayersController@redCards')->name('api_tournament_redcards');// ЖК турнира

    Route::get('/tournaments/{championat}/teams/{team}/matches', 'Sport\TournMatchesController@matchesTeam')->name('api_tournament_team_matches'); // матчи команды в турнире
    Route::get('/matches/{match_id}/team/{team}/players', 'Sport\TournPlayersController@playersMatchTeam')->name('api_tournament_match_players'); // матчи команды в турнире
    Route::get('/match/{match_id}/protocol', 'Sport\TournMatchesController@matchProtocol')->name('api_match_protocol'); // протокол матча

    Route::get('/seasons/all', 'Sport\SeasonsController@seasons')->name('api_seasons');
    Route::get('/seasons/league/{id}', 'Sport\SeasonsController@league')->name('api_seasons_leagues');

    // Документация
    Route::get('/doc', 'Api\DocApiController@index')->name('api_doc');

    Route::get('/doc/sports', 'Api\DocApiController@sports')->name('api_doc_sports');

    Route::get('/doc/leagues', 'Api\DocApiController@leagues')->name('api_doc_leagues');

    Route::get('/doc/seasons', 'Api\DocApiController@seasons')->name('api_doc_seasons');
    Route::get('/doc/seasons/all', 'Api\DocApiController@seasonsAll')->name('api_doc_seasons_all');
    Route::get('/doc/seasons/league', 'Api\DocApiController@seasonsLeague')->name('api_doc_seasons_league');

    Route::get('/doc/tournaments', 'Api\DocApiController@tournaments')->name('api_doc_tournaments');
    Route::get('/doc/tournaments/all', 'Api\DocApiController@tournamentsAll')->name('api_doc_tournaments_all');
    Route::get('/doc/tournaments/sportseason', 'Api\DocApiController@tournamentsSeasonSport')->name('api_doc_tournaments_season_sport');
    Route::get('/doc/tournaments/teams', 'Api\DocApiController@tournamentsTeams')->name('api_doc_tournaments_teams');
    Route::get('/doc/tournaments/stages', 'Api\DocApiController@tournamentsStages')->name('api_doc_tournaments_stages');
    Route::get('/doc/tournaments/struct', 'Api\DocApiController@tournamentsStruct')->name('api_doc_tournaments_struct');
    Route::get('/doc/tournaments/table', 'Api\DocApiController@tournamentsTable')->name('api_doc_tournaments_table');
    Route::get('/doc/tournaments/place', 'Api\DocApiController@tournamentsPlace')->name('api_doc_tournaments_place');

    Route::get('/doc/matches', 'Api\DocApiController@matches')->name('api_doc_matches');
    Route::get('/doc/matches/lastfirst', 'Api\DocApiController@lastfirst')->name('api_doc_matches_lastfirst');
    
});

    
    // ФОТОГАЛЕРЕЯ
    
    Route::get('/photogallery', 'PhotoController@photogallery');
    
