<label>Trouver un membre</label>
<div class="row">
    <div class="col-8">
        <input type="text" name="search" id="search" class="form-control", placeholder="Nom, prénom, email ..">
    </div>
</div>
<br />
<br />
<div id="display_info" >
</div>
<script type="text/javascript">
    $( document ).ready(function() {
        $( document ).on( "keyup",'#search', function() {
            var search = $(this).val();
            if(search)
            {
                $.ajax({
                    type: 'post',
                    data: {
                        search : search
                    },
                    success: function (response) {
                        $( '#display_info' ).html(response);
                    }
                });
            }
            else
            {
                $( '#display_info' ).html(" ");
            }
        });
    });
</script>