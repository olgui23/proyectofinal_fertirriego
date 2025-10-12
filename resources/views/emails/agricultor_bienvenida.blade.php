<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a Fertirriego</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; background: white; border-radius: 10px; padding: 25px; margin: auto;">
        <h2 style="color: #64A500;">¡Bienvenido, {{ $user->nombre }}!</h2>
        <p>Nos alegra informarte que tu cuenta de agricultor ha sido creada correctamente en la plataforma de fertirrigación automatizada.</p>

        <h4 style="color: #333;">Datos de acceso:</h4>
        <ul>
            <li><strong>Usuario:</strong> {{ $user->username }}</li>
            <li><strong>Correo:</strong> {{ $user->email }}</li>
            <li><strong>Contraseña temporal:</strong> {{ $password }}</li>
        </ul>

        <p style="margin-top: 20px;">Por seguridad, te recomendamos <strong>cambiar tu contraseña</strong> al iniciar sesión por primera vez.</p>

        <p>Gracias por ser parte de este proyecto 🌱</p>

        <p style="font-size: 14px; color: #777;">— Equipo de Fertirriego</p>
    </div>
</body>
</html>
