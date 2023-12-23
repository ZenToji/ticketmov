<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        h2 {
            color: #007bff;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px #888888;
        }

        label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        a {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-md-offset-3">
                <h2 class="text-center">Регистрация</h2>
                <form id="registerForm">
                    <div class="form-group">
                        <label for="login">Логин</label>
                        <input type="text" class="form-control" id="login" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" class="form-control" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Подтверждение пароля</label>
                        <input type="password" class="form-control" id="confirmPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                </form>
                <a href="login.php">Авторизация</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#registerForm').on('submit', function (e) {
                e.preventDefault();

                var login = $('#login').val();
                var password = $('#password').val();
                var confirmPassword = $('#confirmPassword').val();

                $.ajax({
                    url: 'register_controller.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        login: login,
                        password: password,
                        confirmPassword: confirmPassword,
                    },
                    success: function (response) {
                        if (response.success) {
                            window.location.href = 'login.php';
                        } else {
                            alert(response.error);
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>
