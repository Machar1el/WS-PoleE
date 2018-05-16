<h2 class="center">Page Index</h2>
<p class="test">0</p>
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
    $(function(){ // you can wrap it here with in document ready block
        var test = $('.test').val();
        var test2 = 0;
        $("body").click(function(){
            $('.test').html(test++);
            test2++;
            if(test2 > 20) {
                alert('STOP CLIC');
                test2 = 0;
            }
        });

        setTimeout(
            function()
            {
                 test2 = 0;
            }, 8000);
    });
</script>