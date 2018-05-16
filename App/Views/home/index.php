<h2 class="center">Page Index</h2>

<div class="chatbox">
  <div class="chatboxheader">Support technique</div>

  <div class="chatboxMessages">

    <span class="distantMessage">Bonjour, je suis Olivier du Support Pôle Emploi, en quoi puis-je vous être utile ?</span>
    <span class="localMessage">Help me ! J'essaie de faire l'inscription initiale,
    mais je n'y arrive pas...</span>
    <span class="distantMessage">Ne vous inquiétez pas %USER_LASTNAME%, ça va bien se passer ;)</span>

  </div>
  <div class="chatboxFooter">
    <input class="chatboxInput" type="text" placeholder="Répondre..."></input>
    <img src="https://png.icons8.com/color/260/send-letter.png" height="25px" width="25px">
  </div>
</div>

<br/>

<div id="help-content">

</div>

<div id='result-content'>

</div>

<p class="test">0</p>
<style>
    video, canvas {
        margin-left: 10px;
        margin-top: 880px;
        position: absolute;
    }
</style>
<div class="demo-frame">
    <div class="demo-container">
        <video id="video" width="320" height="240" preload autoplay loop muted></video>
        <canvas id="canvas" width="320" height="240"></canvas>
    </div>
</div>

<script>
    window.onload = function() {
        var video = document.getElementById('video');
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        var tracker = new tracking.ObjectTracker('face');
        tracker.setInitialScale(4);
        tracker.setStepSize(2);
        tracker.setEdgesDensity(0.1);
        tracking.track('#video', tracker, { camera: true });
        tracker.on('track', function(event) {
            context.clearRect(0, 0, canvas.width, canvas.height);
            event.data.forEach(function(rect) {
                alert('Bonjour !'); die();
                context.strokeStyle = '#a64ceb';
                context.strokeRect(rect.x, rect.y, rect.width, rect.height);
                context.font = '11px Helvetica';
                context.fillStyle = "#fff";
                context.fillText('x: ' + rect.x + 'px', rect.x + rect.width + 5, rect.y + 11);
                context.fillText('y: ' + rect.y + 'px', rect.x + rect.width + 5, rect.y + 22);
            });
        });
        var gui = new dat.GUI();
        gui.add(tracker, 'edgesDensity', 0.1, 0.5).step(0.01);
        gui.add(tracker, 'initialScale', 1.0, 10.0).step(0.1);
        gui.add(tracker, 'stepSize', 1, 5).step(0.1);
    };
</script>
