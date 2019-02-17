const currentPlaylist = new Array();
var audioElement;

class Audio
{
    currentPlaying;
    audio = document.createElement('audio');

    setTrack = (src) => {
        this.audio.src = src;
    }

    play = () => {
        this.audio.play();
    }
}