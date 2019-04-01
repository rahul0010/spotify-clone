var currentPlaylist = new Array();
var shufflePlaylist = new Array();
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;

const formatTime = (second) => {
    let time = Math.round(second)
    let minutes = Math.floor(time / 60);
    let seconds = time - (minutes * 60);
    let extraZero = (seconds < 10) ? "0" : "";

    return minutes + ":" + extraZero + seconds;
}

const updateTimeProgressBar = (audio) => {
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

    let progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css("width", progress + "%");
}

const updateVolumeProgressBar = (audio) => {
    let volume = audio.volume * 100;
    $(".volumebar .progress").css("width", volume + "%");
}

const openPage = (url) => {
    if(url.indexOf('?') == -1)
    {
        url+='?';
    }
    var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn)
    $("#mainContent").load(encodedUrl);
    $("body").scrollTop(0);
    history.pushState(null,null,url);
}

class Audio
{
    currentPlaying;
    audio = document.createElement('audio');

    constructor()
    {
        this.audio.addEventListener('canplay', () => {
            $(".progressTime.remaining").text(formatTime(this.audio.duration));
        });

        this.audio.addEventListener('timeupdate', () => {
            if(this.audio.duration)
            {
                updateTimeProgressBar(this.audio);
            }
        });

        this.audio.addEventListener('volumechange', () => {
            updateVolumeProgressBar(this.audio);
        });

        this.audio.addEventListener('ended',()=>{
            nextSong();
        });
    }

    setTrack = (track) => {
        this.currentPlaying = track;
        this.audio.src = track.path;
    }

    play = () => {
        this.audio.play();
    }

    pause = () => {
        this.audio.pause();
    }

    setTime = (seconds ) => {
        this.audio.currentTime = seconds;
    }
}