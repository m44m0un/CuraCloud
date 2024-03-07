// assets/js/script.js

document.addEventListener('DOMContentLoaded', function () {
    const localVideo = document.getElementById('local-video');
    const remoteVideosContainer = document.getElementById('remote-videos');

    // Get user media (camera and audio)
    navigator.mediaDevices.getUserMedia({ video: true, audio: true })
        .then((stream) => {
            localVideo.srcObject = stream;

            // Your WebRTC logic goes here
        })
        .catch((error) => {
            console.error('Error accessing camera and microphone:', error);
        });
});
