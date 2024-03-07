document.addEventListener('DOMContentLoaded', () => {
    console.log('Document is ready');
    const startStreamBtn = document.getElementById('startStreamBtn');
    const localVideo = document.getElementById('localVideo');

    startStreamBtn.addEventListener('click', async () => {
        console.log('Start Stream button clicked');
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
            console.log('Got user media stream:', stream);
            localVideo.srcObject = stream;
        } catch (error) {
            console.error('Error accessing camera and microphone:', error);
        }
    });
});
