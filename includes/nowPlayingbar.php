<?php
    $resultArray = array();
    $songQuery = mysqli_query($con, "select id from songs order by rand() limit 10");
    while($row = mysqli_fetch_array($songQuery))
    {
        array_push($resultArray, $row["id"]);
    }
    $jsonArray = json_encode($resultArray);
?>

<script>
    
    $(document).ready(()=>{
        currentPlaylist.push(...<?php echo $jsonArray; ?>)
        audioElement = new Audio();
        setTrack(currentPlaylist[0], currentPlaylist, false);
        updateVolumeProgressBar(audioElement.audio);

        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", (e) => {
            e.preventDefault();
        });

        $(".playbackBar .progressBar").mousedown(() => {
            mouseDown = true;
        });

        $(".playbackBar .progressBar").mouseup((e) => {
            timeFromOffset(e, $(".playbackBar .progressBar"));
            // console.log(this);
        });

        $(".playbackBar .progressBar").mousemove((e) => {
            if(mouseDown)
            {
                timeFromOffset(e, $(".playbackBar .progressBar"));
            }
        });

        
        $(".volumebar .progressBar").mousedown(() => {
            mouseDown = true;
        });

        $(".volumebar .progressBar").mouseup((e) => {
            volumeChange(e, $(".volumebar .progressBar"));
            // console.log(this);
        });

        $(".volumebar .progressBar").mousemove((e) => {
            if(mouseDown)
            {
                volumeChange(e, $(".volumebar .progressBar"));
            }
        });

        $(document).mouseup(() => {
            mouseDown = false;
        });
    });

    const volumeChange = (mouse, progressBar) => {
        let percentage = mouse.offsetX / $(progressBar).width();
        if(percentage <= 1 && percentage >= 0)
        {
            audioElement.audio.volume = percentage
        }
    }

    const timeFromOffset = (mouse, progressBar) => {
        let percentage = mouse.offsetX / $(progressBar).width() * 100;
        // console.log(percentage, $(progressBar).width())
        let seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
    }

    const nextSong = () => {
        if(repeat)
        {
            audioElement.setTime(0);
            playSong();
            return;
        }
        if(currentIndex == currentPlaylist.length - 1)
        {
            currentIndex = 0;
        }
        else
        {
            currentIndex++;
        }

        let trackToPlay = currentPlaylist[currentIndex];
        setTrack(trackToPlay, currentPlaylist, true)
    }

    const prevSong = () => {
        if(audioElement.audio.currentTime >= 5 || currentIndex == 0)
        {
            audioElement.setTime(0);
        }
        else
        {
            currentIndex--;
            setTrack(currentPlaylist[currentIndex], currentPlaylist, true)
        }
    }

    const setRepeat = () => {
        repeat = !repeat;
        let imageName = repeat ? "repeat-active.png" : "repeat.png";
        $(".controlButton.repeat img").attr("src",`assets/images/icons/${imageName}`);
    }

    const setMute = () => {
        audioElement.audio.muted = !audioElement.audio.muted;
        let imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
        $(".controlButton.volume img").attr("src",`assets/images/icons/${imageName}`);
    }

    const setShuffle = () => {
        shuffle = !shuffle;
        let imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
        $(".controlButton.shuffle img").attr("src",`assets/images/icons/${imageName}`);

        if(shuffle)
        {
            // Randomise playlists
            shuffleArray(shuffleArray)
        }
        else
        {
            //regular playlist
        }
    }

    function shuffleArray(a) {
        var j, x, i;
        for (i = a.length; i; i--) {
            j = Math.floor(Math.random() * i);
            x = a[i - 1];
            a[i - 1] = a[j];
            a[j] = x;
        }
    }

    const setTrack = (trackId, newPlaylist, play) => {

        if(newPlayList != currentPlaylist)
        {
            currentPlaylist = [...newPlayList];
            shufflePlaylist = currentPlaylist.slice();
            shuffleArray(shufflePlaylist);
        }
        currentIndex = currentPlaylist.indexOf(trackId);
        $.post('includes/handlers/ajax/getSongJson.php',{ songId: trackId }, (data) => {
            var track = JSON.parse(data);
            $(".trackName span").text(track.title);
            audioElement.setTrack(track);

            $.post('includes/handlers/ajax/getArtistJson.php',{ artistId: track.artist }, (data) => {
                var artist = JSON.parse(data);
                $(".artist span").text(artist.name);
            });

            $.post('includes/handlers/ajax/getAlbumJson.php',{ albumId: track.album }, (data) => {
                var album = JSON.parse(data);
                $(".albumLink img").attr('src',album.artworkPath);
            });
            if(play)
            {
                audioElement.play();
            }
        });
    }

    const playSong = () => {

        if(audioElement.audio.currentTime == 0)
        {
            $.post("includes/handlers/ajax/updatePlays.php", {songId: audioElement.currentPlaying.id});
        }
        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
        audioElement.play();
    }

    const pauseSong = () => {
        $(".controlButton.pause").hide();
        $(".controlButton.play").show();
        audioElement.pause();
    }
</script>

<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img alt="" class="albumArtwork">
                </span>
                <div class="trackInfo">
                    <span class="trackName">
                        <span></span>
                    </span>
                    <span class="artist">
                        <span></span>
                    </span>
                </div>
            </div>
        </div>
        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle" onclick="setShuffle();">
                        <img src="./assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>
                    <button class="controlButton previous" title="Previous" onclick="prevSong()">
                        <img src="./assets/images/icons/previous.png" alt="Previous">
                    </button>
                    <button class="controlButton play" title="Play" onclick="playSong();">
                        <img src="./assets/images/icons/play.png" alt="Play">
                    </button>
                    <button class="controlButton pause" title="Pause" style="display: none" onclick="pauseSong();">
                        <img src="./assets/images/icons/pause.png" alt="Pause">
                    </button>
                    <button class="controlButton next" title="Next" onclick="nextSong();">
                        <img src="./assets/images/icons/next.png" alt="Next">
                    </button>
                    <button class="controlButton repeat" title="Repeat" onclick="setRepeat();">
                        <img src="./assets/images/icons/repeat.png" alt="Repeat">
                    </button>
                </div>
                <div class="playbackBar">
                    <span class="progressTime current">0.00</span>
                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>
                    <span class="progressTime remaining">0.00</span>
                </div>
            </div>
        </div>
        <div id="nowPlayingRight">
            <div class="volumebar">
                <button class="controlButton volume" title="Volumne" onclick="setMute();">
                    <img src="./assets/images/icons/volume.png"  alt="Volume">
                </button>
                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>