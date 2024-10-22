<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
<div class="message">
    <h1>500</h1>
    <h3>Внутрення ошибка сервера</h3>
</div>

<style>
    $light-text-color: #C8FFF4;
    $dark-text-color: #03DAC6;

    html,
    body {
        height: 100%;
        margin: 0;
    }

    body {
        background: linear-gradient(#111, #333, #111);
        background-repeat: no-repeat;
        background-size: cover;
        color: #eee;
        position: relative;
        font-family: 'Roboto', sans-serif;
    }

    .message {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        text-align: center;

        h1, h2, h3 {
            margin: 0;
            line-height: .8;
        }

        h2, h3 {
            font-weight: 300;
            color: $light-text-color;
        }

        h1 {
            font-weight: 700;
            color: $dark-text-color;
            font-size: 8em;
        }

        h2 {
            margin: 30px 0;
        }

        h3 {
            font-size: 2.5em;
        }

        h4 {
            display: inline-block;
            margin: 0 15px;
        }

        button {
            background: transparent;
            border: 2px solid $light-text-color;
            color: $light-text-color;
            padding: 5px 15px;
            font-size: 1.25em;
            transition: all 0.15s ease;
            border-radius: 3px;
        }

        button:hover {
            background: $dark-text-color;
            border: 2px solid $dark-text-color;
            color: #111;
            cursor: pointer;
            transform: scale(1.05);
        }
    }
</style>