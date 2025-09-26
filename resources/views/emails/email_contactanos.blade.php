<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
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
            color: #17a2b8;
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
            <h1>Contacto</h1>
        </div>



        <!-- Contenido Principal -->
        <div class="content">
            <h2>Mensaje Recibido</h2>
            <p>Estimado {{ $data['name'] }},</p>
            <p>Gracias por contactarnos. Hemos recibido su mensaje y nuestro equipo se pondrá en contacto con usted lo antes posible.</p>
            <ul>
                <li><strong>Nombre: </strong>{{ $data['name'] }}
                <li><strong>Correo: </strong>{{ $data['email'] }}
                <li><strong>Teléfono: </strong>{{ $data['phone'] }}
                <li><strong>Asunto: </strong>{{ $data['subject'] }}
                <li><strong>Comentario: </strong>{{ $data['message'] }}
            </ul>
            <p>Apreciamos su interés en nuestros servicios.</p>
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


