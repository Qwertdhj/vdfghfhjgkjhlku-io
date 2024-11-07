<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>QR-код Сканер</title>
    <!-- Подключаем библиотеку для работы с QR-кодами -->
    <script src="https://unpkg.com/html5-qrcode@latest/dist/html5-qrcode.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        video {
            width: 320px;
            height: 240px;
            border: 1px solid #ccc;
        }
        .result {
            margin-top: 10px;
            font-size: 18px;
            color: green;
        }
        #scanButton {
            display: block;
            width: 150px;
            padding: 8px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            text-align: center;
            font-weight: bold;
            transition: all .2s ease-in-out;
            outline: none;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }
    </style>
</head>
<body>
<div style="text-align:center">
    <video id="qr-reader" style="width: 100%;"></video>
    <div id="output" class="result"></div>
    <button id="scanButton">Начать сканирование</button>
</div>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    function startScanning() {
        const config = { fps: 10, qrbox: { width: 250, height: 250 } };
        Html5Qrcode.getScanner(config).then(scanner => {
            scanner.renderOnId('qr-reader', config, result => {
                if (result) {
                    document.getElementById('output').innerText = result;
                    verifyQrCode(result); // Отправляем результат на сервер для проверки
                }
            }).catch(err => {
                console.error(err);
            });
        }).catch(err => {
            console.error(err);
        });
    }

    function verifyQrCode(code) {
        fetch('check_qr_code.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ code })
        }).then(response => response.json())
          .then(data => {
              if (data.status === 'success') {
                  alert('QR-код успешно подтвержден!');
                  window.location.href = 'index.php'; // Переход на главную страницу
              } else {
                  alert('Неправильный QR-код.');
              }
          })
          .catch(error => {
              console.error('Error:', error);
          });
    }

    const button = document.getElementById('scanButton');
    button.addEventListener('click', startScanning);
});
</script>
</body>
</html>