<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sumar</title>
</head>
<body>
    <h1>Sumar dos números</h1>
    <form action="/suma" method="POST">
    @csrf
        <label for="num1">Número 1:</label>
        <input type="number" id="num1" name="num1" required>
        <br><br>
        <label for="num2">Número 2:</label>
        <input type="number" id="num2" name="num2" required>
        <br><br>
        <button type="submit">Sumar</button>
    </form>

    @if (isset($resultado))
        <h2>Resultado: {{ $resultado }}</h2>
    @endif
</body>
</html>
