<!DOCTYPE html >
<html lang=”es” >
<head>
<meta charset = "UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Percival">
<title> Index </title>
</head>
<body>
    <!-- index.php -->
<form action="insert.php" method="GET">
    <label>¿Qué desea consultar?</label>
    <select name="tabla">
        <option value="usuarios">Usuarios</option>
        <option value="series">Series</option>
    </select>
    <button type="submit">Continuar</button>
</form>

<?php
