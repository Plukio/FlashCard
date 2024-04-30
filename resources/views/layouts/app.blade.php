<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <style>
        body {
            background-color: #FFA500;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        .navbox {
        position: fixed;
        flex-direction: row;
        margin: 20px 20px;
        top: 0;
        left: 0;
        right: 0;
        }

        .User-name {
        position: fixed;
        flex-direction: row;
        margin: 20px 20px;
        top: 9px;
        left: 100px;
        }

        .flashcard-container {
            width: 500px;
            height: 320px;
            perspective: 1000px;
            border-radius: 20px;
        }

        .flashcard {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.5s;
            cursor: pointer;
            display: flex;
            border-radius: 20px;
            background-color: #ffffff;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
        }

        .flashcard.flip {
            transform: rotateY(180deg);
        }

        .front, .back {
            width: 100%;
            height: 100%;
            position: absolute;
            backface-visibility: hidden;
            display: flex;
            color: #000;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
        }


        .back {
            transform: rotateY(180deg);
        }

        .details {
            margin-bottom: 10px;
            text-align: center;
        }

        .details label {
            font-weight: bold;
        }

        .details p {
            margin: 0;
        }

        .answer-buttons {
            display: flex;
            justify-content: space-between;
            width: 100%;
            position: absolute;
            bottom: 20px;
        }

        .answer-buttons button {
            width: 25%;
            padding: 10px 10px;
            background-color: #000;
            color: #FFA500;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 5px;
            margin-right: 5px;
            font-size: 16px;
            border-radius: 30px; 
        }

        .answer-buttons button:hover {
            background-color: #333;
            border-radius: 30px; 
        }

        .tag-container {
            position: absolute;
            top: 10px;
            left: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .tag {
            padding: 5px 10px;
            background-color: #eef;
            color: #777;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }

        .button-black-yellow {
        background-color: black;
        border: none; 
        color: #FFA500;
        padding: 10px 20px;
        border-radius: 50px; 
        cursor: pointer; 
        margin: 30px 20px;
        }

        .login-logout-botton {
        background-color: black;
        border: none; 
        color: #FFA500;
        border-radius: 50px; 
        padding: 10px 20px;
        cursor: pointer; 
       
        }

        .button-group {
        display: flex; 
        gap: 10px; 
        justify-content: center;
        }

    </style>
</head>

<body>

<div>
    @if(Auth::check())  <!-- Check if user is logged in -->
        <div class="User-name" style="flex-direction: row">
            <div class="user-name">
                {{ Auth::user()->name }} <!-- Display the logged-in user's name -->
            </div>
        </div>
        
        <div class="navbox" style="flex-direction: row">
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button onclick="location.href='{{ route('logout') }}'" type="submit" class="login-logout-botton">Log Out</a> 
                </form>
            </div>
        </div>
    @else  <!-- If user is not logged in -->
        <div class="navbox" style="flex-direction: row">
            <div>
                <button onclick="location.href='{{ route('login') }}'" type="submit" class="login-logout-botton">Log In</a> 
            </div>
        </div>
    @endif
</div>


<div class="content">
    @yield('content')
</div>

    <script>
        function flip() {
            const flashcard = document.getElementById('flashcard');
            flashcard.classList.toggle('flip');
        }

    </script>
</body>
</html>