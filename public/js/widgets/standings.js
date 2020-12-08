
var doRequest = function(data) {
    return $.ajax({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: base_meccs_center_url, data: data, type: 'post', cache: false, async: true });
}

function getActualTurnNextTurnAndStandings(league_id) {
    var requestData = { tourn_id: league_id };
    doRequest(requestData).then(function(responseData) {
        $("#kiemelt_ligak").empty();
        $("#kiemelt_ligak").append(responseData);
        //console.log(responseData)
        $("#kiemelt_liga_nev").text($("#kiemeltSelector option:selected").text());
        resultIEBugfix();
        sendHeight();
    });
}

function resultIEBugfix(){
    $(".result").wrap("<div class='flexAlignCenter'></div>");
}

function sendHeight() {
    var heightClass = main_class !== undefined ? main_class : false;
    // sends height to parent iframe
    if(heightClass){
        var body = document.body,
            html = document.documentElement;

        var main_elem = document.querySelector('.'+heightClass);

        var height = Math.max( main_elem.scrollHeight, main_elem.offsetHeight );

        window.parent.postMessage({
            'height': height,
            'location': window.location.href
        }, "*");
    }
}

$(document).ready(function(){
    resultIEBugfix();

    window.addEventListener('resize', function(){
        sendHeight();
    })
    window.dispatchEvent(new Event('resize'));
});
