<style type="text/css">
    #help {
    }
</style>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>WS-PoleEmploie</title>
    <link href="<?= PATH ?>/Public/css/bootstrap.css" rel="stylesheet">
    <link href="<?= PATH ?>/Public/css/styles.css?v=<?=time();?>" rel="stylesheet">
    <script src="<?= PATH ?>/Public/js/jquery-2.2.4.js"></script>
    <script src="<?= PATH ?>/Public/js/bootstrap.js"></script>
    <script src="<?= PATH ?>/Public/js/tracking.js-master/build/tracking-min.js"></script>
    <script src="<?= PATH ?>/Public/js/tracking.js-master/build/data/face-min.js"></script>
    <script>
        function dispachEvent(level, url) {
                switch(level) {
                    case "0":
                        $.ajax({
                            type: 'post',
                            url: url,
                            data: {
                                level: level
                            },
                            success: function (response) {
                                $('#help-content').html(response);
                            }
                        });
                        break;
                    case "1":
                        break;
                    case "2":
                        break;
                    case "3":
                        break;
                    default:
                }
        }

        $(document).ready(function() {
            var level = $('#level').val();
            var test = $('.test').val();
            var url = $('#url').val();
            var test2 = 0;
            $('#help').click(function() {
                dispachEvent(level, url);
            });
            $("body").click(function(){
                $('.test').html(test++);
                test2++;
                if(test2 > 10) {
                    dispachEvent(level, url);
                    test2 = 0;
                }
            });
            setTimeout(
                function() {
                    test2 = 0;
                }, 8000);
        });

        $(document).ajaxStop(function() {
            $('#validate').click(function() {
                var level = "1";
                var url = $('#url').val();

                $('#level').val(1);
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        level: level
                    },
                    success: function (response) {
                        $('#result-content').html(response);
                    }
                });
            });
        });
    </script>
</head>
<body>
<img id="image" style="width:98%; z-index:1000; position: fixed; top: 75%; left: 50%; transform: translate(-50%, -50%);" src="http://blog.lefigaro.fr/social/2011/03/24/POLE_EMPLOI.jpg">
    <div class="container">
        <nav class="navbar navbar-default" style="margin-top: 20px">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= PATH ?>/home/index">Accueil</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <?php if(\App\Model\UserRepository::loggedAdmin()): ?>
                            <li><a href="<?= PATH ?>/admin/index">Admin</a></li>
                        <?php endif ?>
                        <?php if(\App\Model\UserRepository::logged()): ?>
                            <li><a href="<?= PATH ?>/user/profil">Profil</a></li>
                        <?php endif ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pole emploie et vous <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Conseils</a></li>
                                <li><a href="#">Vos allocations</a></li>
                                <li><a href="#">Vos aides</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Pôle emploi et vous</a></li>
                                <li><a href="#">Mon parcours info</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Vos services en ligne</a></li>
                                <li><a href="#">Découvrir le marché du travail</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                            <li><a id="help" href="#">Aide <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <input id="level" type="hidden" value="<?= $_SESSION['level'] ?>"/>
        <input id="url" type="hidden" value="<?= $_SESSION['url'] ?>"/>

        <?php echo $content; ?>
    </div>
</body>
