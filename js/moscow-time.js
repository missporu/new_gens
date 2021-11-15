function moscowTime() {
    var d = new Date();
    d.setHours( d.getHours() + 3, d.getMinutes() + d.getTimezoneOffset() );
    return d.toTimeString().substring( 0, 8 );
}

onload = function () {
    setInterval( function () {
        document.getElementById( "server_time" ).innerHTML = moscowTime();
    }, 100 );
}