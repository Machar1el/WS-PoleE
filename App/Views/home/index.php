<h2 class="center">Page Index</h2>
<p class="test">0</p>
<p></p>
<script>
    $(function(){ // you can wrap it here with in document ready block
        var test = $('.test').val();
        var test2 = 0;
        $("body").click(function(){
            $('.test').html(test++);
            test2++;
            if(test2 > 20) {
                alert('STOP CLIC FDP');
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