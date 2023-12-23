<?php
include_once '../db.php';
session_start();
checkAuth();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>TicketMov - Главная</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <header class="navbar navbar-light bg-light">
        <div class="container">
            <a href="../user/profile.php" class="navbar-brand">Личный кабинет</a>
            <a href="../auth/logout.php" class="btn btn-outline-danger">Выйти</a>
        </div>
    </header>

    <div class="container mt-4">
        <section class="mb-4 text-center">
            <h2 class="font-weight-bold">Добро пожаловать в TicketMov!</h2>
            <p>Здесь вы можете бронировать билеты в кино.</p>
        </section>

        <div class="row mb-4" id="movies-row">
            <!-- Карточки фильмов будут здесь -->
        </div>

        <?php if (isAdmin()) : ?>
            <a href="../admin/create_movie.php" class="btn btn-success">Добавить фильм</a>
        <?php endif; ?>

        <h2 class="mb-4 mt-4">Наши кинотеатры</h2>
        <div id="map" style="width: 100%; height: 400px; margin-bottom: 20px;"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=PLACEHOLDER&lang=ru_RU"></script>
    <script>
        $(document).ready(function() {
            loadMovies();
            setInterval(loadMovies, 5000);

            function loadMovies() {
                $.ajax({
                    url: 'index_controller.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            updateMoviesRow(response.data);
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function() {
                        alert('Ошибка при загрузке фильмов.');
                    }
                });
            }

            function updateMoviesRow(movies) {
                var moviesRow = $('#movies-row');
                moviesRow.empty();
                $.each(movies, function(index, movie) {
                    var movieCard = $(`
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <img src="${movie.image}" class="card-img-top" alt="${movie.title}" style="height: 350px; object-fit: fill;">
                                <div class="card-body">
                                    <h5 class="card-title">${movie.title}</h5>
                                    <p class="card-text">Длительность: ${movie.duration} минут</p>
                                    <p class="card-text">Время показа</p>
                                    <p class="card-text">${movie.showtime}</p>
                                    <a href="movie_details.php?movie_id=${movie.id}" class="btn btn-primary">Подробнее</a>
                                </div>
                            </div>
                        </div>
                    `);
                    moviesRow.append(movieCard);
                });
            }

            ymaps.ready(initMap);

            function initMap() {
                var map = new ymaps.Map("map", {
                    center: [59.9342802, 30.3350986],
                    zoom: 14
                });
                map.setBounds([
                    [59.8500, 30.1500],
                    [60.0000, 30.4500]
                ]);

                var locations = [{
                        coords: [59.945933, 30.320045],
                        name: 'Кинотеатр 1'
                    },
                    {
                        coords: [59.911423, 30.299846],
                        name: 'Кинотеатр 2'
                    },
                    {
                        coords: [59.927128, 30.346099],
                        name: 'Кинотеатр 3'
                    }
                ];

                locations.forEach(function(loc) {
                    var placemark = new ymaps.Placemark(loc.coords, {
                        hintContent: loc.name
                    });
                    map.geoObjects.add(placemark);
                });
            }
        });
    </script>
</body>

</html>
