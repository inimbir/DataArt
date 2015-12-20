<!DOCTYPE html>
<html>
    <head>
        <title>Рейтинг ресторанов</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- Latest compiled and minified CSS -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <!-- Optional theme -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="css/bootstrap.min.css" type=text/css>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" type=text/css>
        <link rel="stylesheet" href="css/rate.css" type=text/css>
        <link rel="icon" type="image/png" href="favicon.ico">
        <!-- Latest compiled and minified JavaScript -->
        <script>
            var admin=0;
            <?php
                if(isset($usertype)) echo 'admin = ' . $usertype . ';'
            ?>
        </script>
        <script type="text/javascript" src="js/jquery-1.11.3.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/stars.js"></script>
        <script type="text/javascript" src="js/rating.js"></script>
    </head>
    <body>
        <div id="modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
      <!-- Заголовок модального окна -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Название ресторана</h4>
                    </div>
      <!-- Основное содержимое модального окна -->
                    <div class="modal-body">
                        <div class="container image">
                            <img src="img/2.jpg" class="img-responsive">
                        </div>
                        
                        <div class="row modal-marks">
                            <div id="modal-general" class="col-xs-6 col-md-3">
                                <span>Общая</span>
                                <div class="modal-stars">
                                    <center class="modal-center">
                                        <img src="img/star.png" class="modal-star img-responsive">
                                        <img src="img/star.png" class="modal-star img-responsive">
                                        <img src="img/star.png" class="modal-star img-responsive">
                                    </center>
                                </div>
                            </div>
                            <div id="modal-kitchen" class="col-xs-6 col-md-3">
                                <span>Кухня</span>
                                <div class="modal-stars">
                                    <center class="modal-center">
                                        <img src="img/star.png" class="modal-star img-responsive">
                                        <img src="img/star.png" class="modal-star img-responsive">
                                        <img src="img/star.png" class="modal-star img-responsive">
                                    </center>
                                </div>
                            </div>
                            <div id="modal-interier" class="col-xs-6 col-md-3">
                                <span>Интерьер</span>
                                <div class="modal-stars">
                                    <center class="modal-center">
                                        <img src="img/star.png" class="modal-star img-responsive">
                                        <img src="img/star.png" class="modal-star img-responsive">
                                        <img src="img/star.png" class="modal-star img-responsive">
                                    </center>
                                </div>
                            </div>
                            <div id="modal-service" class="col-xs-6 col-md-3">
                                <span>Сервис</span>
                                <div class="modal-stars">
                                    <center class="modal-center">
                                        <img src="img/star.png" class="modal-star img-responsive">
                                        <img src="img/star.png" class="modal-star img-responsive">
                                        <img src="img/star.png" class="modal-star img-responsive">
                                    </center>
                                </div>
                            </div>
                        </div>
                        
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vel arcu eu odio dictum gravida. Vivamus non justo efficitur, congue odio nec, interdum quam. Aliquam dictum, lacus id tempor feugiat, velit lorem faucibus erat, ut finibus lorem ante vitae turpis. Morbi commodo tristique enim a condimentum. In aliquet leo risus, sit amet luctus ex fermentum ut. Nullam nec dapibus elit. Etiam non dictum ligula. Duis fringilla dictum metus, id laoreet magna ultricies eu. Etiam vitae justo mollis, tempor dui at, congue turpis. Cras gravida ultrices mollis.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button id="modal-save" class="btn btn-success">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid wrap">
            <div class="container-fluid header pull-left">
                    <div class="logo pull-left">
                        <img src="img/logo-rating.png" class="img-responsive">
                    </div>
            </div>
            <div class="container-fluid">
                <div class="container">
                    <div class="navbar navbar-left nav">
                        <div class="order">
                            <ul>
                                <button id="general" type="button" class="btn btn-primary" >Общий</button>
                                <button id="kitchen" type="button" class="btn btn-primary">Кухня</button>
                                <button id="interier" type="button" class="btn btn-primary">Интерьер</button>
                                <button id="service" type="button" class="btn btn-primary">Сервис</button>
                            </ul>
                        </div>
                    </div>
                    <div class="container rating">
                        <div class="center-block container main">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>