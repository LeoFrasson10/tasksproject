<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>@yield('title')</title>
    @yield('css')
  </head>
  <body>
    <nav class="teal">
      <div class="nav-wrapper">
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="hide-on-med-and-down">
          <li class="{{ request()->is('tarefas') ? 'active' : '' }}"><a href="{{ route('tasks') }}">Tarefas</a></li>
          <li class="{{ request()->is('colaboradores') ? 'active' : '' }}"><a href="{{ route('collaborators') }}">Colaboradores</a></li>
        </ul>
      </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
      <li class="{{ request()->is('tarefas') ? 'active' : '' }}"><a href="{{ route('tasks') }}">Tarefas</a></li>
      <li class="{{ request()->is('colaboradores') ? 'active' : '' }}"><a href="{{ route('collaborators') }}">Colaboradores</a></li>
    </ul>

    <br />
    @yield('content')
  </body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('.sidenav');
      var instances = M.Sidenav.init(elems, {
        edge: 'left',
        draggable: true

      });
    });
  </script>
  <script type='text/javascript' src='https://code.jquery.com/jquery-1.11.0.js'></script>
  <script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

  @yield('js')
</html>
