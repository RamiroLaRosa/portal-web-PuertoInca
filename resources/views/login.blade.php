<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>INSTITUTO - PORTAL ACADÉMICO</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
        @vite('resources/css/login/login.css')
</head>

<body>
    <div class="geometric-pattern"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="institute-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1 class="login-title">Portal Académico</h1>
                <p class="login-subtitle">Sistema de Administración Institucional</p>
            </div>

            <div class="divider"></div>

            {{-- Error general de credenciales --}}
            @if ($errors->has('login'))
                <div class="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ $errors->first('login') }}</span>
                </div>
            @endif

            {{-- Errores de validación de campos --}}
            @if ($errors->any() && !$errors->has('login'))
                <div class="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        @foreach ($errors->all() as $e)
                            <div>{{ $e }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group">
                    <label for="codigo" class="form-label">Código de Usuario</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <input type="text" id="codigo" name="codigo" class="form-input"
                            placeholder="Ingrese su código institucional" value="{{ old('codigo') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <input type="password" id="password" name="password" class="form-input"
                            placeholder="Ingrese su contraseña" required>
                        <div class="toggle-password" id="toggle-pass">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="login-button">
                        <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
                        Acceder al Sistema
                    </button>
                </div>
            </form>

            <div class="footer-text">
                <p>© 2025 Instituto Educativo - Todos los derechos reservados</p>
            </div>
        </div>
    </div>

    <script>
        // Mostrar/ocultar contraseña
        const passInput = document.getElementById('password');
        const toggle = document.getElementById('toggle-pass');

        toggle.addEventListener('click', () => {
            const isPassword = passInput.type === 'password';
            passInput.type = isPassword ? 'text' : 'password';
            toggle.innerHTML = isPassword ?
                '<i class="fas fa-eye-slash"></i>' :
                '<i class="fas fa-eye"></i>';
        });

        // Efecto de focus mejorado
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Animación del botón de envío
        document.querySelector('.login-button').addEventListener('click', function(e) {
            if (passInput.value && document.getElementById('codigo').value) {
                this.innerHTML =
                    '<i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i>Verificando credenciales...';
                this.style.background = 'linear-gradient(135deg, #059669 0%, #047857 100%)';
            }
        });
    </script>
</body>

</html>
