<!doctype html>
<html lang={{ app()->getLocale() }}>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">
    <link rel="shortcut icon" href="{{{ asset('img/favicon.png') }}}">

    <title>{{ config('app.name', 'Laravel') }}: A Micro Journal</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* Move down content because we have a fixed navbar that is 50px tall */
        body {
            padding-top: 50px;
            padding-bottom: 20px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <form class="navbar-form navbar-right" action="{{ route('login') }}" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <input type="text" placeholder="Email" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" class="form-control" name="password">
                </div>
                <button type="submit" class="btn btn-success">Sign in</button>
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</nav>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h1>Welcome to Micro Journaling</h1>
        <p>Micro journaling is recording small snippets of anything. It's easy because it only takes a minute or even a few seconds, but over time it adds up.
            A micro journal is also just a great way to organize lots of little random notes.</p>
        <p><a class="btn btn-primary btn-lg" href="/register" role="button">Register &raquo;</a></p>
    </div>
</div>

<div class="container">
    <!-- Row of columns -->
    <div class="row">
        <div class="col-md-4">
            <h2>TIL</h2>
            <p><em>Today I Learned</em></p>
            <p>Dec 12, 2017 - That coming up with sample content is hard to do.</p>
            <p>Dec 11, 2017 - That cat videos never get old.</p>
        </div>
        <div class="col-md-4">
            <h2>Life</h2>
            <p><em>Random Life Events</em></p>
            <p>Dec 11, 2017 - Got back from New York today.</p>
            <p>Dec 10, 2017 - Had pizza in Brooklyn.</p>
        </div>
        <div class="col-md-4">
            <h2>Car Maintenance</h2>
            <p><em>2014 Honda Accord</em></p>
            <p>Nov 25, 2017 - Oil change at 50k miles.</p>
            <p>June 17, 2017 - Oil change at 43k miles.</p>
        </div>
    </div>

    <hr>

    <!-- Row of columns -->
    <div class="row">
        <div class="col-md-4">
            <h2>Kids</h2>
            <p><em>All About the Kids</em></p>
            <p>Dec 12, 2017 - Jack lost a tooth!</p>
            <p>Dec 11, 2017 - Janie learned how to do a cartwheel!</p>
        </div>
        <div class="col-md-4">
            <h2>Story</h2>
            <p><em>Ongoing Story</em></p>
            <p>Dec 12, 2017 - One day the papa bear made organic steel cut oatmeal for breakfast but it was too hot to eat right away. So they took a walk in the forest while it cooled. Meanwhile...</p>
            <p>Dec 11, 2017 - There lived three bears.</p>
            <p>Dec 10, 2017 - Once upon a time...</p>
        </div>
        <div class="col-md-4">
            <h2>Goals</h2>
            <p><em>Self Improvement Goals</em></p>
            <p>Nov 25, 2017 - Do better</p>
            <p>June 17, 2017 - Be better</p>
            <p>May 2, 2017 - Get better</p>
        </div>
    </div>

    <hr>

    <footer>
        <p>&copy; 2017 Journl</p>
    </footer>
</div> <!-- /container -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>