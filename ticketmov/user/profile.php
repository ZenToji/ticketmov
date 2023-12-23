<?php
include_once '../db.php';
session_start();
checkAuth();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Личный кабинет - TicketMov</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h2>Личный кабинет пользователя <?php echo $_SESSION['login']; ?></h2>
        <h3>Ваши бронирования</h3>
        <div id="bookings-container"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            loadUserBookings();
            setInterval(loadUserBookings, 5000);

            function loadUserBookings() {
                $.ajax({
                    url: 'profile_controller.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            updateBookings(response.data);
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function() {
                        alert('Ошибка при загрузке бронирований.');
                    }
                });
            }

            function updateBookings(bookings) {
                var container = $('#bookings-container');
                container.empty();

                if (bookings.length === 0) {
                    container.append('<div class="alert alert-danger">У вас ни одного бронирования.</div>');
                } else {
                    var row = $('<div class="row"></div>');
                    $.each(bookings, function(index, booking) {
                        var card = $(`
                            <div class="col-md-3 mb-4">
                                <div class="card">
                                    <img src="${booking.image}" class="card-img-top" style="height: 350px; object-fit: fill;">
                                    <div class="card-body">
                                        <h5 class="card-title">${booking.title}</h5>
                                        <p class="card-text">Длительность: ${booking.duration} минут</p>
                                        <p class="card-text">Время показа: ${booking.showtime}</p>
                                        <p class="card-text">Ряд: ${booking.row_number}, Место: ${booking.seat_number}</p>
                                    </div>
                                </div>
                            </div>
                        `);
                        row.append(card);
                    });
                    container.append(row);
                }
            }
        });
    </script>
</body>

</html>
