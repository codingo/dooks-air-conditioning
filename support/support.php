<?php 
  session_start();
  require 'helpers.php';

  if(!isset($_SESSION['user_id'])) {
    redirect('index.html');
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style type="text/css">
        a.dropdown-toggle {
            cursor: pointer;
        }
        
        table {
            border: 0px;
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Nora</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="./css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">



    <!-- Custom styles for this template -->
    <link href="./css/starter-template.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
                <a class="navbar-brand" href="#">Nora</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Hi <?php echo $_SESSION['user_id']; ?><span class="caret"></span>
              </a>
                        <ul class="dropdown-menu">
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container-fluid">

        <div class="starter-template">
            <h4>Welcome to Your Automated Support Bot!</h4>
            <img src="logo.png" />
            <div id="msgs" class="well col-sm-offset-4 col-sm-4" style="height:400px;max-height:400px; overflow-y:auto;margin-bottom:10px;">

            </div>


            <div class="col-sm-12">
                <form class="form-inline">
                    <div class="form-group">
                        <input type='text' name="msg" id="msg" class="form-control">
                    </div>
                    <button class="btn btn-primary" id="send" type="button">Send</button>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./js/jquery.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $(document).keypress(function(e) {
                if (e.which == 13) {
                    $(".btn#send").click();
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
            $(".btn#send").click(function() {
                // validate and process form here
                var name = $("input#msg").val().toLowerCase().replace('readflag', 'justkidding');
                if (name.length == 0) {
                    return;
                }
                var msg = $('<p class="text-left text-primary"></p>').append(name);
                $("input#msg").val('');
                $("div#msgs").append(msg)
                var buildDom = function(data) {
                    var html = $('<blockquote class="text-left text-success"></blockquote>');
                    if (Array.isArray(data)) {
                        var table = $('<table class="table"></table>');
                        table.append('<tr><th>Cmd</th><th>Desc</th></tr>');
                        for (var i = 0; i < data.length; i++) {
                            var cmd = data[i]['command'];
                            var msg = data[i]['msg'];
                            table.append('<tr><td>' + cmd + '</td><td>' + msg + '</td></tr>');
                            html.append(table);
                        }
                    } else {
                        html = html.append(data);
                    }
                    $("div#msgs").append(html)
                    var elem = document.getElementById('msgs');
                    if (elem) {
                        elem.scrollTop = elem.scrollHeight;
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "chat.php",
                    data: name,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        buildDom(data);
                        console.log(data);
                    }
                });
            });
        });
    </script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="./js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>

</html>
