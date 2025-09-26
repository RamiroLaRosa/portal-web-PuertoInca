<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro de Reclamaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
        }
        .header img {
            max-width: 100px;
        }
        .content {
            padding: 20px 0;
        }
        .content h2 {
            color: #dc3545;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            font-size: 12px;
            color: #868e96;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <img src="https://cbp.edu.pe/images/logocatalina.png" alt="Logo de la empresa">
            <h1>Libro de Reclamaciones</h1>
        </div>

        <!-- Contenido Principal -->
        <div class="content">
            <h2>Reclamación Recibida</h2>
            <p>Estimado cliente,</p>
            <p>Hemos recibido su reclamación y estamos trabajando para resolverla lo antes posible. A continuación, se detallan los datos de su reclamación:</p>
            <ul>
                <li><strong>Nombre: </strong>{{ $data['nombre'] }}<strong>,</strong>{{ $data['apellido'] }}</p>
                <li><strong>Tipo de Documento: </strong>{{ $data['tipoDoc'] }}
                <li><strong>Número de Documento: </strong>{{ $data['numDoc'] }}
                <li><strong>Correo Electrónico: </strong>{{ $data['correo'] }}</li>
                <li><strong>Teléfono Fijo: </strong>{{ $data['telefono'] }}</li>
                <li><strong>Número de Celular: </strong>{{ $data['celular'] }}
                <li><strong>Dirección: </strong>{{ $data['direccion'] }}
                <li><strong>Tipo de Bien: </strong>{{ $data['tipoBien'] }}</p>
                <li><strong>Detalle del Producto y/o Servicio: </strong>{{ $data['detalleBien'] }}</p>
                <li><strong>Tipo de Reclamo: </strong>{{ $data['tipoReclamo'] }}</p>
                <li><strong>Detalle del Reclamo o Queja: </strong>{{ $data['detalleReclamo'] }}</p>
                <li><strong>Detalle de la Acción: </strong>{{ $data['detalleAccion'] }}</p>
            </ul>
            <p>Nos pondremos en contacto con usted pronto para ofrecerle una solución.</p>
        </div>

        <!-- Pie de Página -->
        <div class="footer">
            <p>&copy; 2024 Consultora SilferSystem SAC. Todos los derechos reservados.</p>
            <p>
                <a href="#" style="text-decoration: none; color: #007bff;">Política de privacidad</a>
            </p>
        </div>
    </div>
</body>
</html>
