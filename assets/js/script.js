const currentPlaylist = new Array();
var audioElement;
var mouseDown = false;

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
}