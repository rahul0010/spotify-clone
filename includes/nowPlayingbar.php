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
    });

    const setTrack = (trackId, newPlaylist, play) => {
        audioElement.setTrack("assets/music/bensound-anewbeginning.mp3");
        if(play)
        {
            audioElement.play();
        }
    }
</script>

<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img src="https://androidapkcloud.com/wp-content/uploads/2017/09/Square-PhotoWithout.png" alt="" class="albumArtwork">
                </span>
                <div class="trackInfo">
                    <span class="trackName">
                        <span>Happy Birthday</span>
                    </span>
                    <span class="artist">
                        <span>Rahul Bharati</span>
                    </span>
                </div>
            </div>
        </div>
        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle">
                        <img src="./assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>
                    <button class="controlButton previous" title="Previous">
                        <img src="./assets/images/icons/previous.png" alt="Previous">
                    </button>
                    <button class="controlButton play" title="Play">
                        <img src="./assets/images/icons/play.png" alt="Play">
                    </button>
                    <button class="controlButton pause" title="Pause" style="display: none">
                        <img src="./assets/images/icons/pause.png" alt="Pause">
                    </button>
                    <button class="controlButton next" title="Next">
                        <img src="./assets/images/icons/next.png" alt="Next">
                    </button>
                    <button class="controlButton repeat" title="Repeat">
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
                <button class="controlButton volume" title="Volumne">
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