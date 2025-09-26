<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <!-- Start Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Consultora Silfersystem S.A.C.">
    <meta name="robots" content="">
    <meta name="keywords"
        content="sistema de gestión académica, gestión educativa, administración académica, plataforma educativa, estudiantes, profesores, matrícula, calificaciones, horarios, planificación académica, gestión de cursos, registro académico, evaluación, seguimiento académico, información académica, portal estudiantil, comunicación educativa, aprendizaje en línea, recursos educativos, herramientas educativas, educación superior, gestión de instituciones académicas">
    <meta name="description"
        content="Optimiza la administración académica con nuestro sistema de gestión académica. Simplifica la matrícula, seguimiento de calificaciones, planificación de horarios y comunicación entre estudiantes y profesores. Una plataforma integral para instituciones educativas de todos los niveles.">
    <meta property="og:title" content="Silfersystem : Sistema de Gestión Académica">
    <meta property="og:description"
        content=" SGA Silfersystem - Optimiza la administración académica con nuestro sistema de gestión académica. Simplifica la matrícula, seguimiento de calificaciones, planificación de horarios y comunicación entre estudiantes y profesores. Una plataforma integral para instituciones educativas de todos los niveles.">

    <meta property="og:image" content="https://silfersystem.com/wp-content/uploads/2023/08/logo-no-bg-light.png">
    <meta name="format-detection" content="telephone=no">


    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- End Meta -->

    <!-- Page Title Here -->
    <title>Error page</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('/images/favicon.png') }}">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

</head>

<body class="vh-100">
    <div class="authincation h-100"
        style="background-image: url({{ asset('/images/student-bg.jpg') }}); background-repeat:no-repeat; background-size:cover;">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-input-content  error-page">
                        <h1 class="error-text text-primary">400</h1>
                        <h4> Bad Request</h4>
                        <p>Sorry, we are under maintenance!</p>
                        <a class="btn btn-primary" href="{{ route('login') }}">Regresar</a>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <img class="w-100 move1" src="{{ asset('/images/svg/student.svg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
 Scripts
***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('/js/dlabnav-init.js') }}"></script>
    <script src="{{ asset('/js/custom.min.js') }}"></script>

</body>

</html>
