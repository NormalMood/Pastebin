<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <b>Login page</b>
    <div>
        <form action="/signin" method="post">
            <input type="text" name="name" placeholder="Имя*">
            <input type="password" name="password" placeholder="Пароль*">
            <button>Войти</button>
        </form>
    </div>
    <br><br>
    <div>
        <form action="/forgot-name" method="post">
            <input type="text" name="email" placeholder="E-mail*">
            <button>Восстановить имя</button>
        </form>
    </div>
    <br><br>
    <div>
        <form action="/forgot-password" method="post">
            <input type="text" name="name" placeholder="Имя*">
            <button>Восстановить пароль</button>
        </form>
    </div>
</body>
</html>