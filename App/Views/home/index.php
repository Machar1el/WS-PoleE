<h1 class="center">Page Index</h1>
<br />
<div class="alert alert-success" id="titre" style="display: none"><center><h2>Un assistant va prendre en charge votre demande, merci de patienter...</h2></center></div>
<div class="chatbox" style="display: none">
  <div class="chatboxheader">
      Support technique
  </div>

  <div class="chatboxMessages">

    <span class="distantMessage" id="1" style="display: none">Bonjour, je suis Olivier du Support Pôle Emploi, en quoi puis-je vous être utile ?</span>
    <span class="localMessage" id="2" style="display: none">Help me ! J'essaie de faire l'inscription initiale,
    mais je n'y arrive pas...</span>
    <span class="distantMessage" id="3" style="display: none">Ne vous inquiétez pas %USER_LASTNAME%, ça va bien se passer ;)</span>
    <span class="distantMessage" id="4" style="display: none">
        <div class="btn btn-danger" id="problem">
            Problème non réglé
        </div>
    </span>

  </div>
  <div class="chatboxFooter">
    <input class="chatboxInput" type="text" placeholder="Répondre...">
    <img src="https://png.icons8.com/color/260/send-letter.png" height="25px" width="25px">
  </div>
</div>

<br/>

<div id="help-content">
</div>

<div id='result-content'>
</div>
<style>
    video, canvas {
        margin-left: 10px;
        margin-top: 880px;
        position: absolute;
    }
    html, body {
        height: 100%;
        margin: 0;
    }

    #wrapper {
        min-height: 100%;
    }
</style>
<div class="demo-frame">
    <div class="demo-container">
        <video id="video" width="320" height="240" preload autoplay loop muted></video>
        <canvas id="canvas" width="320" height="240"></canvas>
    </div>
</div>
<div id="wrapper"></div>

<script>
    window.onload = function() {
        $('html, body').css({
            overflow: 'hidden',
            height: '100%'
        });
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
                $('#image').hide('slow');
                die();
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
