<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    <ul>
        <li><a href="/">Главная</a></li>
        <li><a href="/?a=all">Товары</a></li>
        <li>Контакты</li>
    </ul>

    <?= $content ?>

    <script>
        function testAjax() {
            jQuery.ajax({
                url: '/?a=ajax',
                success: function (data) {
                    console.log(data);
                }
            });
        }
    </script>
</body>
</html>
