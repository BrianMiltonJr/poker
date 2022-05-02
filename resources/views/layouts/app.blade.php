<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="favicon.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <title>Poker Application</title>
</head>
<body>
    <div class="flex bg-gray-500">
        <div class="flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto bg-gray-800">
          <h2 class="text-3xl font-semibold text-center text-blue-800">Ole Boys Club</h2>
          <div class="flex flex-col justify-between mt-6">
            <ul>
              <li>
                <a class="flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-400 " href="{{ route('game.index') }}">
                  <i class="fas fa-diamond"></i>  
                  <span class="mx-4 font-medium">Games</span>
                </a>
              </li>

              <li>
                <a class="flex items-center px-4 py-2 mt-5 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-400" href="{{ route('player.index') }}">
                  <i class="fas fa-users"></i>  
                  <span class="mx-4 font-medium">Players</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="p-4 m-8 overflow-y-auto">
            <div class="flex flex-col items-center justify-center p-2">
                @yield('content')
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    @yield('script')
</body>
</html>