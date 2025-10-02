<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\InicioHeroController;
use App\Http\Controllers\InicioServiciosController;
use App\Http\Controllers\InicioEstadisticaController;
use App\Http\Controllers\InicioBeneficioController;
use App\Http\Controllers\InicioTestimoniosController;
use App\Http\Controllers\PresentacionController;
use App\Http\Controllers\ReseniaController;
use App\Http\Controllers\MisionVisionController;
use App\Http\Controllers\ValoresController;
use App\Http\Controllers\OrganigramaController;
use App\Http\Controllers\JerarquicaController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\ProgramasEstudioController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\DatosPersonalesController;
use App\Http\Controllers\DatosAcademicosController;
use App\Http\Controllers\DatosLaboralesController;
use App\Http\Controllers\ProgramaInformacionController;
use App\Http\Controllers\AdmisionTituloController;
use App\Http\Controllers\AdmisionResultadoController;
use App\Http\Controllers\AdmisionModalidadController;
use App\Http\Controllers\AdmisionRequisitoController;
use App\Http\Controllers\AdmisionCronogramaController;
use App\Http\Controllers\AdmisionExoneradoController;
use App\Http\Controllers\AdmisionVacanteController;
use App\Http\Controllers\AdmisionPasoController;
use App\Http\Controllers\AdmisionProcesoController;
use App\Http\Controllers\MatriculaTipoController;
use App\Http\Controllers\MatriculaRequisitoController;
use App\Http\Controllers\MatriculaDetalleRequisitoController;
use App\Http\Controllers\MatriculaPasoController;
use App\Http\Controllers\MatriculaCronogramaController;
use App\Http\Controllers\BecaTipoController;
use App\Http\Controllers\BecaBeneficiarioController;
use App\Http\Controllers\BecaProcesoController;
use App\Http\Controllers\DocumentoGestionController;
use App\Http\Controllers\TupaController;
use App\Http\Controllers\InversionController;
use App\Http\Controllers\LicenciamientoController;
use App\Http\Controllers\EstadisticaCrudController;
use App\Http\Controllers\ServiciosComplementariosController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\LinksInstitucionalesController;
use App\Http\Controllers\ContactanosController;
use App\Http\Controllers\RedesController;
use App\Http\Controllers\Admin\ProgramasSeccionController;
use App\Http\Controllers\Admin\ProgramasCoordinadorController;
use App\Http\Controllers\Admin\ProgramasPerfilController;
use App\Http\Controllers\Admin\ProgramasAreaController;
use App\Http\Controllers\Admin\ProgramasEgresadoController;
use App\Http\Controllers\Admin\ProgramasConvenioController;
use App\Http\Controllers\Admin\ProgramasGaleriaController;
use App\Http\Controllers\web\DocentePublicController;
use App\Http\Controllers\LocalPublicController;
use App\Http\Controllers\DocumentoPublicController;
use App\Http\Controllers\InversionPublicController;
use App\Http\Controllers\LicenciamientoPublicController;
use App\Http\Controllers\EstadisticaPublicController;
use App\Http\Controllers\TupaPublicController;
use App\Http\Controllers\ServiciosPublicController;
use App\Http\Controllers\ContactoPublicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\AdmisionController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\BecasController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\EfsrtController;
use App\Http\Controllers\Admin\InfoImportanteController;
use App\Http\Controllers\Admin\TipoReclamacionController;
use App\Http\Controllers\Admin\MarcoLegalController;
use App\Http\Controllers\Admin\DerechosController;
use App\Http\Controllers\Admin\ReclamosController;
use App\Http\Controllers\web\LibroReclamacionesController;
use App\Http\Controllers\admin\UnidadesDidacticasController;
use App\Http\Controllers\AdministradoresController;
use App\Http\Controllers\ProgramasMallaController;
use App\Http\Controllers\home\DashboardController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\SubmoduloController;
use App\Http\Controllers\home\AdministrarColor;

// Página principal
Route::get('/', [HomeController::class, 'index'])->name('home');

// LOGIN
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')
        ->with('success', 'Has cerrado sesión correctamente.');
})->name('logout');


// <!------------------------------------- INICIO MIDDLEWARE USER LOGIN ----------------------------------->

// Middleware de autenticación
Route::middleware(['auth.user'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // GESTION DE COLORES ADMINISTRABLES
    Route::post('/admin/dashboard/colors', [AdministrarColor::class, 'guardarcolor'])->name('admin.colors.save');

    // MODULO ADMINISTRADOR: SEGURIDAD
    Route::middleware(['module:seguridad'])->group(function () {
        //Seguridad - Roles
        Route::get('/admin/seguridad/roles',  [RolesController::class, 'index'])->name('roles.index');
        Route::post('/admin/seguridad/roles', [RolesController::class, 'store'])->name('roles.store');
        Route::put('/admin/seguridad/roles/{id}', [RolesController::class, 'update'])->name('roles.update');
        Route::delete('/admin/seguridad/roles/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');

        //Seguridad - Permisos
        Route::get('/admin/seguridad/permisos',  [PermisosController::class, 'index'])->name('permisos.index');
        Route::put('/admin/seguridad/permisos/{id}', [PermisosController::class, 'update'])->name('permisos.update');

        //Seguridad - Modulos Header
        Route::prefix('admin/inicio')->middleware(['auth'])->group(function () {
            Route::get('/header', [HeaderController::class, 'index'])->name('admin.header.index');
            Route::get('/header/{header}', [HeaderController::class, 'show'])->name('admin.header.show');
            Route::put('/header/{header}/visibility', [HeaderController::class, 'updateVisibility'])->name('admin.header.visibility');
        });

        //Seguridad - Submodulos Header
        Route::prefix('admin/inicio')->middleware(['auth'])->group(function () {
            Route::get('/submodulos', [SubmoduloController::class, 'index'])->name('admin.submodulos.index');
            Route::get('/submodulos/{submodulo}', [SubmoduloController::class, 'show'])->name('admin.submodulos.show');
            Route::put('/submodulos/{submodulo}/visibility', [SubmoduloController::class, 'updateVisibility'])->name('admin.submodulos.visibility');
        });

        // Seguridad - Usuarios (Administradores))
        Route::get('/admin/seguridad/administradores',  [AdministradoresController::class, 'index'])->name('administradores.index');
        Route::post('/admin/seguridad/administradores', [AdministradoresController::class, 'store'])->name('administradores.store');
        Route::put('/admin/seguridad/administradores/{id}', [AdministradoresController::class, 'update'])->name('administradores.update');
        Route::put('/admin/seguridad/administradores/{id}/password', [AdministradoresController::class, 'updatePassword'])->name('administradores.updatePassword');
        Route::delete('/admin/seguridad/administradores/{id}', [AdministradoresController::class, 'destroy'])->name('administradores.destroy');
    });


    // MODULO ADMINISTRADOR: INICIO
    Route::middleware(['module:inicio'])->group(function () {

        //Inicio - Logo
        Route::prefix('admin/inicio')->middleware(['auth']) // quita 'auth' si no aplica
            ->group(function () {
                Route::get('hero-image', [LogoController::class, 'index'])->name('admin.inicio.logo.index');
                Route::post('hero-image', [LogoController::class, 'store'])->name('admin.inicio.logo.store');
                Route::put('hero-image/{logo}', [LogoController::class, 'update'])->name('admin.inicio.logo.update');
            });


        //Inicio - Hero
        Route::get('/admin/inicio/hero',        [InicioHeroController::class, 'index'])->name('hero.index');
        Route::put('/admin/inicio/hero/{id}',   [InicioHeroController::class, 'update'])->name('hero.update');

        //Inicio - Servicios
        Route::get('/admin/inicio/servicios',      [InicioServiciosController::class, 'index'])->name('servicios-inicio.index');
        Route::post('/admin/inicio/servicios',     [InicioServiciosController::class, 'store'])->name('servicios-inicio.store');
        Route::put('/admin/inicio/servicios/{id}', [InicioServiciosController::class, 'update'])->name('servicios-inicio.update');
        Route::delete('/admin/inicio/servicios/{id}', [InicioServiciosController::class, 'destroy'])->name('servicios-inicio.destroy');

        //Inicio - Estadistica
        Route::get('/admin/inicio/estadistica',        [InicioEstadisticaController::class, 'index'])->name('estadistica-inicio.index');
        Route::post('/admin/inicio/estadistica',        [InicioEstadisticaController::class, 'store'])->name('estadistica-inicio.store');
        Route::put('/admin/inicio/estadistica/{id}',   [InicioEstadisticaController::class, 'update'])->name('estadistica-inicio.update');
        Route::delete('/admin/inicio/estadistica/{id}',   [InicioEstadisticaController::class, 'destroy'])->name('estadistica-inicio.destroy');


        //Inicio - Beneficios
        Route::get('/admin/inicio/beneficios',        [InicioBeneficioController::class, 'index'])->name('beneficio.index');
        Route::post('/admin/inicio/beneficios',        [InicioBeneficioController::class, 'store'])->name('beneficio.store');
        Route::put('/admin/inicio/beneficios/{id}',   [InicioBeneficioController::class, 'update'])->name('beneficio.update');
        Route::delete('/admin/inicio/beneficios/{id}',   [InicioBeneficioController::class, 'destroy'])->name('beneficio.destroy');


        //Inicio - Testimonios
        Route::get('/admin/inicio/testimonios',        [InicioTestimoniosController::class, 'index'])->name('testimonios.index');
        Route::post('/admin/inicio/testimonios',        [InicioTestimoniosController::class, 'store'])->name('testimonios.store');
        Route::put('/admin/inicio/testimonios/{id}',   [InicioTestimoniosController::class, 'update'])->name('testimonios.update');
        Route::delete('/admin/inicio/testimonios/{id}',   [InicioTestimoniosController::class, 'destroy'])->name('testimonios.destroy');
    });


    // MODULO ADMINISTRADOR: NOSOTROS
    Route::middleware(['module:nosotros'])->group(function () {

        //Nosotros
        Route::get('/admin/nosotros/programas',        [PresentacionController::class, 'index'])->name('presentacion.index');
        Route::put('/admin/nosotros/programas/{id}',   [PresentacionController::class, 'update'])->name('presentacion.update');

        //Reseña Historica
        Route::get('/admin/nosotros/resenia',        [ReseniaController::class, 'index'])->name('resenia.index');
        Route::post('/admin/nosotros/resenia',        [ReseniaController::class, 'store'])->name('resenia.store');
        Route::put('/admin/nosotros/resenia/{id}',   [ReseniaController::class, 'update'])->name('resenia.update');
        Route::delete('/admin/nosotros/resenia/{id}',   [ReseniaController::class, 'destroy'])->name('resenia.destroy');

        //Mision
        Route::get('/admin/nosotros/mv', [MisionVisionController::class, 'index'])->name('mv.index');
        Route::put('/admin/nosotros/mv', [MisionVisionController::class, 'update'])->name('mv.update');
        Route::post('/admin/nosotros/valores',        [ValoresController::class, 'store'])->name('valores.store');
        Route::put('/admin/nosotros/valores/{id}',   [ValoresController::class, 'update'])->name('valores.update');
        Route::delete('/admin/nosotros/valores/{id}',   [ValoresController::class, 'destroy'])->name('valores.destroy');

        //Organigrama
        Route::get('/admin/nosotros/organigrama', [OrganigramaController::class, 'index'])->name('organigrama.index');
        Route::post('/admin/nosotros/organigrama', [OrganigramaController::class, 'update'])->name('organigrama.update');

        //Plana Jerarquica
        Route::get('/admin/nosotros/jerarquica', [JerarquicaController::class, 'index'])->name('jerarquica.index');
        Route::post('/admin/nosotros/jerarquica', [JerarquicaController::class, 'store'])->name('jerarquica.store');
        Route::put('/admin/nosotros/jerarquica/{id}', [JerarquicaController::class, 'update'])->name('jerarquica.update');
        Route::delete('/admin/nosotros/jerarquica/{id}', [JerarquicaController::class, 'destroy'])->name('jerarquica.destroy');

        //Plana Docente
        // Página + combo de programas
        Route::get('/admin/nosotros/gestion-docente', [DocenteController::class, 'index'])->name('gestion.index');

        // API JSON
        Route::get('/admin/nosotros/docentes',          [DocenteController::class, 'list'])->name('gestion.list');
        Route::get('/admin/nosotros/docentes/{id}',     [DocenteController::class, 'show'])->name('gestion.show');
        Route::post('/admin/nosotros/docentes',         [DocenteController::class, 'store'])->name('gestion.store');
        Route::put('/admin/nosotros/docentes/{id}',    [DocenteController::class, 'update'])->name('gestion.update');
        Route::delete('/admin/nosotros/docentes/{id}', [DocenteController::class, 'destroy'])->name('gestion.destroy');

        //Datos Personales
        Route::prefix('/admin/nosotros/gestion-personal')->group(function () {
            // Página
            Route::get('/',         [DatosPersonalesController::class, 'index'])->name('personales.index');

            // APIs
            Route::get('/docentes', [DatosPersonalesController::class, 'docentesPorPrograma'])->name('datosp.docentes');   // ?programa=ID
            Route::get('/list',     [DatosPersonalesController::class, 'list'])->name('datosp.list');       // ?docente=ID

            // CRUD (recomendado porque la UI crea/edita/borra)
            Route::get('/{id}',     [DatosPersonalesController::class, 'show'])->name('datosp.show');
            Route::post('/',        [DatosPersonalesController::class, 'store'])->name('datosp.store');
            Route::put('/{id}',     [DatosPersonalesController::class, 'update'])->name('datosp.update');
            Route::delete('/{id}',  [DatosPersonalesController::class, 'destroy'])->name('datosp.destroy');
        });


        //Datos Academicos
        Route::prefix('/admin/nosotros/gestion-academicos')->group(function () {
            Route::get('/',            [DatosAcademicosController::class, 'index'])->name('academico.index');
            Route::get('/docentes',    [DatosAcademicosController::class, 'docentesPorPrograma'])->name('academicos.docentes');
            Route::get('/list',        [DatosAcademicosController::class, 'list'])->name('academicos.list');

            Route::post('/',           [DatosAcademicosController::class, 'store'])->name('academicos.store');
            Route::get('/{id}',        [DatosAcademicosController::class, 'show'])->name('academicos.show');
            Route::put('/{id}',        [DatosAcademicosController::class, 'update'])->name('academicos.update');
            Route::delete('/{id}',     [DatosAcademicosController::class, 'destroy'])->name('academicos.destroy');
        });


        //Datos Laborales
        Route::prefix('/admin/nosotros/gestion-laboral')->group(function () {
            Route::get('/',            [DatosLaboralesController::class, 'index'])->name('laboral.index');
            Route::get('/docentes',    [DatosLaboralesController::class, 'docentesPorPrograma'])->name('laborales.docentes');
            Route::get('/list',        [DatosLaboralesController::class, 'list'])->name('laborales.list');

            Route::post('/',           [DatosLaboralesController::class, 'store'])->name('laborales.store');
            Route::get('/{id}',        [DatosLaboralesController::class, 'show'])->name('laborales.show');
            Route::put('/{id}',        [DatosLaboralesController::class, 'update'])->name('laborales.update');
            Route::delete('/{id}',     [DatosLaboralesController::class, 'destroy'])->name('laborales.destroy');
        });


        //Unidades Didácticas
        Route::prefix('/admin/nosotros/unidades-didacticas')->group(function () {
            Route::get('/',                 [UnidadesDidacticasController::class, 'index'])->name('unidades.index');
            Route::get('/docentes',         [UnidadesDidacticasController::class, 'docentes']);
            Route::get('/listado',          [UnidadesDidacticasController::class, 'listado']);
            Route::get('/modulos',          [UnidadesDidacticasController::class, 'modulos']);
            Route::get('/semestres',        [UnidadesDidacticasController::class, 'semestres']);
            Route::get('/cursos',           [UnidadesDidacticasController::class, 'cursos']);
            Route::post('/',                [UnidadesDidacticasController::class, 'store'])->name('unidades.store');
            Route::delete('/{id}',          [UnidadesDidacticasController::class, 'destroy'])->name('unidades.destroy');
        });


        //Locales
        Route::prefix('admin/nosotros/locales')->group(function () {
            Route::get('/', [LocalController::class, 'index'])->name('local.index');
            Route::post('/', [LocalController::class, 'store'])->name('local.store');
            Route::put('/{local}', [LocalController::class, 'update'])->name('local.update');
            Route::delete('/{local}', [LocalController::class, 'destroy'])->name('local.destroy');
        });
    });







    // MODULO ADMINISTRADOR: PROGRAMAS DE ESTUDIO
    Route::middleware(['module:programas_estudio'])->group(function () {

        //Programas de Estudios
        Route::get('/admin/programas/gestionar', [ProgramasEstudioController::class, 'index'])->name('programas.index');
        Route::post('/admin/programas', [ProgramasEstudioController::class, 'store'])->name('programas.store');
        Route::put('/admin/programas/{programa}', [ProgramasEstudioController::class, 'update'])->name('programas.update');
        Route::delete('/admin/programas/{programa}', [ProgramasEstudioController::class, 'destroy'])->name('programas.destroy');

        //Información de Programas de Estudios
        Route::get('/admin/programas/informacion',        [ProgramaInformacionController::class, 'index'])->name('informacion.index');
        Route::get('/admin/programas/informacion/list',   [ProgramaInformacionController::class, 'list'])->name('informacion.list');
        Route::get('/admin/programas/informacion/{id}',   [ProgramaInformacionController::class, 'show'])->name('informacion.show');
        Route::post('/admin/programas/informacion',        [ProgramaInformacionController::class, 'store'])->name('informacion.store');
        Route::put('/admin/programas/informacion/{id}',   [ProgramaInformacionController::class, 'update'])->name('informacion.update');
        Route::delete('/admin/programas/informacion/{id}',   [ProgramaInformacionController::class, 'destroy'])->name('informacion.destroy');
        Route::get('/admin/programas/informacion/foto/{id}', [ProgramaInformacionController::class, 'verFoto'])->name('informacion.foto');

        // Secciones de Programas de Estudios
        Route::prefix('admin/programas')->name('programas.')->group(function () {
            Route::get('/seccion', [ProgramasSeccionController::class, 'index'])
                ->name('seccion.index');

            Route::get('/estudios', [ProgramasSeccionController::class, 'listarEstudios'])
                ->name('estudios.list');

            // Coordinadores
            Route::get('/{programa}/coordinadores', [ProgramasCoordinadorController::class, 'index'])
                ->whereNumber('programa')->name('coordinador.index');

            Route::post('/{programa}/coordinadores/sync', [ProgramasCoordinadorController::class, 'sync'])
                ->whereNumber('programa')->name('coordinador.sync');

            // Perfil de Egresado
            Route::get('/{programa}/perfil', [ProgramasPerfilController::class, 'show'])
                ->whereNumber('programa')->name('perfil.show');

            Route::post('/{programa}/perfil', [ProgramasPerfilController::class, 'save'])
                ->whereNumber('programa')->name('perfil.save');

            // Áreas de especialización
            Route::get('/{programa}/areas', [ProgramasAreaController::class, 'index'])
                ->whereNumber('programa')->name('areas.index');

            Route::post('/{programa}/areas', [ProgramasAreaController::class, 'store'])
                ->whereNumber('programa')->name('areas.store');

            Route::get('/{programa}/areas/{area}', [ProgramasAreaController::class, 'show'])
                ->whereNumber(['programa', 'area'])->name('areas.show');

            Route::put('/{programa}/areas/{area}', [ProgramasAreaController::class, 'update'])
                ->whereNumber(['programa', 'area'])->name('areas.update');

            Route::delete('/{programa}/areas/{area}', [ProgramasAreaController::class, 'destroy'])
                ->whereNumber(['programa', 'area'])->name('areas.destroy');

            // EGRESADOS
            Route::get('/{programa}/egresados', [ProgramasEgresadoController::class, 'index'])
                ->whereNumber('programa')->name('egresados.index');

            Route::post('/{programa}/egresados', [ProgramasEgresadoController::class, 'store'])
                ->whereNumber('programa')->name('egresados.store');

            Route::get('/{programa}/egresados/{egresado}', [ProgramasEgresadoController::class, 'show'])
                ->whereNumber('programa')->whereNumber('egresado')->name('egresados.show');

            Route::post('/{programa}/egresados/{egresado}', [ProgramasEgresadoController::class, 'update'])
                ->whereNumber('programa')->whereNumber('egresado')->name('egresados.update'); // (POST para compatibilidad con fetch + FormData)

            Route::delete('/{programa}/egresados/{egresado}', [ProgramasEgresadoController::class, 'destroy'])
                ->whereNumber('programa')->whereNumber('egresado')->name('egresados.destroy');

            // MALLA
            Route::get('/{programa}/malla', [ProgramasMallaController::class, 'index'])
                ->whereNumber('programa')->name('malla.index');

            // MÓDULOS
            Route::post('/{programa}/malla/modulos', [ProgramasMallaController::class, 'storeModulo'])
                ->whereNumber('programa')->name('malla.modulos.store');
            Route::put('/{programa}/malla/modulos/{modulo}', [ProgramasMallaController::class, 'updateModulo'])
                ->whereNumber(['programa', 'modulo'])->name('malla.modulos.update');
            Route::delete('/{programa}/malla/modulos/{modulo}', [ProgramasMallaController::class, 'destroyModulo'])
                ->whereNumber(['programa', 'modulo'])->name('malla.modulos.destroy');

            // SEMESTRES
            Route::post('/{programa}/malla/semestres', [ProgramasMallaController::class, 'storeSemestre'])
                ->whereNumber('programa')->name('malla.semestres.store');
            Route::put('/{programa}/malla/semestres/{semestre}', [ProgramasMallaController::class, 'updateSemestre'])
                ->whereNumber(['programa', 'semestre'])->name('malla.semestres.update');
            Route::delete('/{programa}/malla/semestres/{semestre}', [ProgramasMallaController::class, 'destroySemestre'])
                ->whereNumber(['programa', 'semestre'])->name('malla.semestres.destroy');

            // CURSOS
            Route::post('/{programa}/malla/cursos', [ProgramasMallaController::class, 'storeCurso'])
                ->whereNumber('programa')->name('malla.cursos.store');
            Route::put('/{programa}/malla/cursos/{curso}', [ProgramasMallaController::class, 'updateCurso'])
                ->whereNumber(['programa', 'curso'])->name('malla.cursos.update');
            Route::delete('/{programa}/malla/cursos/{curso}', [ProgramasMallaController::class, 'destroyCurso'])
                ->whereNumber(['programa', 'curso'])->name('malla.cursos.destroy');

            // CONVENIOS
            Route::get('/{programa}/convenios', [ProgramasConvenioController::class, 'index'])
                ->whereNumber('programa')->name('convenios.index');

            Route::post('/{programa}/convenios', [ProgramasConvenioController::class, 'store'])
                ->whereNumber('programa')->name('convenios.store');

            Route::get('/{programa}/convenios/{convenio}', [ProgramasConvenioController::class, 'show'])
                ->whereNumber(['programa', 'convenio'])->name('convenios.show');

            Route::post('/{programa}/convenios/{convenio}', [ProgramasConvenioController::class, 'update'])
                ->whereNumber(['programa', 'convenio'])->name('convenios.update');

            Route::delete('/{programa}/convenios/{convenio}', [ProgramasConvenioController::class, 'destroy'])
                ->whereNumber(['programa', 'convenio'])->name('convenios.destroy');

            // GALERIA
            Route::get('/{programa}/galeria', [ProgramasGaleriaController::class, 'index'])
                ->whereNumber('programa')->name('galerias.index');

            Route::post('/{programa}/galeria', [ProgramasGaleriaController::class, 'store'])
                ->whereNumber('programa')->name('galerias.store');

            Route::get('/{programa}/galeria/{item}', [ProgramasGaleriaController::class, 'show'])
                ->whereNumber(['programa', 'item'])->name('galerias.show');

            Route::post('/{programa}/galeria/{item}', [ProgramasGaleriaController::class, 'update'])
                ->whereNumber(['programa', 'item'])->name('galerias.update'); // POST + FormData

            Route::delete('/{programa}/galeria/{item}', [ProgramasGaleriaController::class, 'destroy'])
                ->whereNumber(['programa', 'item'])->name('galerias.destroy');
        });
    });


    // MODULO ADMINISTRADOR: ADMISIÓN Y MATRÍCULA
    Route::middleware(['module:admision_matricula'])->group(function () {

        //Admision - Titulos
        Route::get('/admin/admision/titulo', [AdmisionTituloController::class, 'index'])->name('admin-titulo.index');
        Route::post('/admin/admision/titulo', [AdmisionTituloController::class, 'store'])->name('admision-titulo.store');
        Route::put('/admin/admision/titulo/{admision_titulo}', [AdmisionTituloController::class, 'update'])->name('admision-titulo.update');
        Route::delete('/admin/admision/titulo/{admision_titulo}', [AdmisionTituloController::class, 'destroy'])->name('admision-titulo.destroy');

        //Admision - Resultados
        Route::get('/admin/admision/resultados',                    [AdmisionResultadoController::class, 'index'])->name('admin-resultados.index');
        Route::post('/admin/admision/resultados',                    [AdmisionResultadoController::class, 'store'])->name('admision-resultados.store');
        Route::put('/admin/admision/resultados/{admision_resultado}', [AdmisionResultadoController::class, 'update'])->name('admision-resultados.update');
        Route::delete('/admin/admision/resultados/{admision_resultado}', [AdmisionResultadoController::class, 'destroy'])->name('admision-resultados.destroy');


        //Admision - Modalidades
        Route::get('/admin/admision/modalidades',                         [AdmisionModalidadController::class, 'index'])->name('admin-modalidades.index');
        Route::post('/admin/admision/modalidades',                         [AdmisionModalidadController::class, 'store'])->name('admin-modalidades.store');
        Route::put('/admin/admision/modalidades/{admision_modalidade}',   [AdmisionModalidadController::class, 'update'])->name('admin-modalidades.update');
        Route::delete('/admin/admision/modalidades/{admision_modalidade}',   [AdmisionModalidadController::class, 'destroy'])->name('admin-modalidades.destroy');


        //Admision - Requisitos
        Route::get('/admin/admision/requisitos',                     [AdmisionRequisitoController::class, 'index'])->name('admin-requisitos.index');
        Route::post('/admin/admision/requisitos',                     [AdmisionRequisitoController::class, 'store'])->name('admin-requisitos.store');
        Route::put('/admin/admision/requisitos/{requisito}',         [AdmisionRequisitoController::class, 'update'])->name('admin-requisitos.update');
        Route::delete('/admin/admision/requisitos/{requisito}',         [AdmisionRequisitoController::class, 'destroy'])->name('admin-requisitos.destroy');


        //Admision - Cronograma
        Route::get('/admin/admision/cronograma',                      [AdmisionCronogramaController::class, 'index'])->name('admin-cronograma.index');
        Route::post('/admin/admision/cronograma',                      [AdmisionCronogramaController::class, 'store'])->name('admin-cronograma.store');
        Route::put('/admin/admision/cronograma/{cronograma}',         [AdmisionCronogramaController::class, 'update'])->name('admin-cronograma.update');
        Route::delete('/admin/admision/cronograma/{cronograma}',         [AdmisionCronogramaController::class, 'destroy'])->name('admin-cronograma.destroy');


        //Admision - Exonerados
        Route::get('/admin/admision/exonerados',                 [AdmisionExoneradoController::class, 'index'])->name('admin-exonerados.index');
        Route::post('/admin/admision/exonerados',                 [AdmisionExoneradoController::class, 'store'])->name('admin-exonerados.store');
        Route::put('/admin/admision/exonerados/{exonerado}',     [AdmisionExoneradoController::class, 'update'])->name('admin-exonerados.update');
        Route::delete('/admin/admision/exonerados/{exonerado}',     [AdmisionExoneradoController::class, 'destroy'])->name('admin-exonerados.destroy');


        //Admision - Vacantes
        Route::get('/admin/admision/vacantes',              [AdmisionVacanteController::class, 'index'])->name('admin-vacantes.index');
        Route::post('/admin/admision/vacantes',              [AdmisionVacanteController::class, 'store'])->name('admin-vacantes.store');
        Route::put('/admin/admision/vacantes/{vacante}',    [AdmisionVacanteController::class, 'update'])->name('admin-vacantes.update');
        Route::delete('/admin/admision/vacantes/{vacante}',    [AdmisionVacanteController::class, 'destroy'])->name('admin-vacantes.destroy');

        //Admision - Pasos
        Route::get('/admin/admision/paso',            [AdmisionPasoController::class, 'index'])->name('admin-pasos.index');
        Route::post('/admin/admision/paso',            [AdmisionPasoController::class, 'store'])->name('admin-pasos.store');
        Route::put('/admin/admision/paso/{paso}',     [AdmisionPasoController::class, 'update'])->name('admin-pasos.update');
        Route::delete('/admin/admision/paso/{paso}',     [AdmisionPasoController::class, 'destroy'])->name('admin-pasos.destroy');


        //Admision - Proceso
        Route::get('/admin/admision/proceso',           [AdmisionProcesoController::class, 'index'])->name('admin-proceso.index');
        Route::post('/admin/admision/proceso',           [AdmisionProcesoController::class, 'store'])->name('admin-proceso.store');
        Route::put('/admin/admision/proceso/{proceso}', [AdmisionProcesoController::class, 'update'])->name('admin-proceso.update');
        Route::delete('/admin/admision/proceso/{proceso}', [AdmisionProcesoController::class, 'destroy'])->name('admin-proceso.destroy');


        //Matricula - Tipos
        Route::get('/admin/matricula/tipos',           [MatriculaTipoController::class, 'index'])->name('matri-tipos.index');
        Route::post('/admin/matricula/tipos',           [MatriculaTipoController::class, 'store'])->name('matri-tipos.store');
        Route::put('/admin/matricula/tipos/{tipo}',    [MatriculaTipoController::class, 'update'])->name('matri-tipos.update');
        Route::delete('/admin/matricula/tipos/{tipo}',    [MatriculaTipoController::class, 'destroy'])->name('matri-tipos.destroy');


        //Matricula - Requisitos
        Route::get('/admin/matricula/requisitos',           [MatriculaRequisitoController::class, 'index'])->name('matri-requisitos.index');
        Route::post('/admin/matricula/requisitos',           [MatriculaRequisitoController::class, 'store'])->name('matri-requisitos.store');
        Route::put('/admin/matricula/requisitos/{req}',     [MatriculaRequisitoController::class, 'update'])->name('matri-requisitos.update');
        Route::delete('/admin/matricula/requisitos/{req}',     [MatriculaRequisitoController::class, 'destroy'])->name('matri-requisitos.destroy');

        //Matricula - Detalle Requisitos
        Route::get('/admin/matricula/detalle-requisitos',            [MatriculaDetalleRequisitoController::class, 'index'])->name('matri-detalle-requisitos.index');
        Route::post('/admin/matricula/detalle-requisitos',            [MatriculaDetalleRequisitoController::class, 'store'])->name('matri-detalle-requisitos.store');
        Route::put('/admin/matricula/detalle-requisitos/{detalle}',  [MatriculaDetalleRequisitoController::class, 'update'])->name('matri-detalle-requisitos.update');
        Route::delete('/admin/matricula/detalle-requisitos/{detalle}',  [MatriculaDetalleRequisitoController::class, 'destroy'])->name('matri-detalle-requisitos.destroy');

        //Matricula - Proceso
        Route::get('/admin/matricula/pasos',         [MatriculaPasoController::class, 'index'])->name('matri-pasos.index');
        Route::post('/admin/matricula/pasos',         [MatriculaPasoController::class, 'store'])->name('matri-pasos.store');
        Route::put('/admin/matricula/pasos/{paso}',  [MatriculaPasoController::class, 'update'])->name('matri-pasos.update');
        Route::delete('/admin/matricula/pasos/{paso}',  [MatriculaPasoController::class, 'destroy'])->name('matri-pasos.destroy');


        //Matricula - Cronograma
        Route::get('/admin/matricula/cronograma',              [MatriculaCronogramaController::class, 'index'])->name('matri-cronograma.index');
        Route::post('/admin/matricula/cronograma',              [MatriculaCronogramaController::class, 'store'])->name('matri-cronograma.store');
        Route::put('/admin/matricula/cronograma/{cronograma}', [MatriculaCronogramaController::class, 'update'])->name('matri-cronograma.update');
        Route::delete('/admin/matricula/cronograma/{cronograma}', [MatriculaCronogramaController::class, 'destroy'])->name('matri-cronograma.destroy');

        //Beca - Tipos
        Route::get('/admin/beca/tipo',             [BecaTipoController::class, 'index'])->name('beca-tipo.index');
        Route::post('/admin/beca/tipo',             [BecaTipoController::class, 'store'])->name('beca-tipo.store');
        Route::put('/admin/beca/tipo/{tipo}',      [BecaTipoController::class, 'update'])->name('beca-tipo.update');
        Route::delete('/admin/beca/tipo/{tipo}',      [BecaTipoController::class, 'destroy'])->name('beca-tipo.destroy');


        //Beca - Beneficiarios
        Route::get('/admin/beca/beneficiario',            [BecaBeneficiarioController::class, 'index'])->name('beca-beneficiario.index');
        Route::post('/admin/beca/beneficiario',            [BecaBeneficiarioController::class, 'store'])->name('beca-beneficiario.store');
        Route::put('/admin/beca/beneficiario/{beneficiario}', [BecaBeneficiarioController::class, 'update'])->name('beca-beneficiario.update');
        Route::delete('/admin/beca/beneficiario/{beneficiario}', [BecaBeneficiarioController::class, 'destroy'])->name('beca-beneficiario.destroy');


        //Beca - Pasos
        Route::get('/admin/beca/pasos',           [BecaProcesoController::class, 'index'])->name('beca-pasos.index');
        Route::post('/admin/beca/pasos',           [BecaProcesoController::class, 'store'])->name('beca-pasos.store');
        Route::put('/admin/beca/pasos/{paso}',    [BecaProcesoController::class, 'update'])->name('beca-pasos.update');
        Route::delete('/admin/beca/pasos/{paso}',    [BecaProcesoController::class, 'destroy'])->name('beca-pasos.destroy');
    });

    // MODULO ADMINISTRADOR: TRANSPARENCIA
    Route::middleware(['module:transparencia'])->group(function () {


        //Transparencia - Documentos
        Route::get('/admin/trasnparencia/documentos',                 [DocumentoGestionController::class, 'index'])->name('documentos.index');
        Route::post('/admin/trasnparencia/documentos',                 [DocumentoGestionController::class, 'store'])->name('documentos.store');
        Route::put('/admin/trasnparencia/documentos/{documento}',     [DocumentoGestionController::class, 'update'])->name('documentos.update');
        Route::delete('/admin/transparencia/documentos/{documento}',     [DocumentoGestionController::class, 'destroy'])->name('documentos.destroy');
        Route::get('//admin/trasnparencia/documentos/{documento}/file',   [DocumentoGestionController::class, 'file'])->name('documentos.file');

        //Transparencia - Tupa
        Route::get('/admin/trasnparencia/tupa',            [TupaController::class, 'index'])->name('tupa.index');
        Route::post('/admin/trasnparencia/tupa',            [TupaController::class, 'store'])->name('tupa.store');
        Route::put('/admin/transparencia/tupa/{tupa}',     [TupaController::class, 'update'])->name('tupa.update');
        Route::delete('/admin/trasnparencia/tupa/{tupa}',     [TupaController::class, 'destroy'])->name('tupa.destroy');

        //Transparencia - Inversiones
        Route::get('/admin/trasnparencia/inversiones',            [InversionController::class, 'index'])->name('inversiones.index');
        Route::post('/admin/trasnparencia/inversiones',            [InversionController::class, 'store'])->name('inversiones.store');
        Route::put('/admin/transparencia/inversiones/{inversion}', [InversionController::class, 'update'])->name('inversiones.update');
        Route::delete('/admin/trasnparencia/inversiones/{inversion}', [InversionController::class, 'destroy'])->name('inversiones.destroy');

        //Transparencia - Licenciamiento
        Route::get('/admin/trasnparencia/licenciamiento',             [LicenciamientoController::class, 'index'])->name('licenciamiento.index');
        Route::post('/admin/trasnparencia/licenciamiento',             [LicenciamientoController::class, 'store'])->name('licenciamiento.store');
        Route::put('/admin/transparencia/licenciamiento/{licenciamiento}', [LicenciamientoController::class, 'update'])->name('licenciamiento.update');
        Route::delete('/admin/trasnparencia/licenciamiento/{licenciamiento}', [LicenciamientoController::class, 'destroy'])->name('licenciamiento.destroy');


        //Transparencia - Estadistica
        Route::get('/admin/trasnparencia/estadistica',               [EstadisticaCrudController::class, 'index'])->name('estadistica.index');
        Route::get('/admin/trasnparencia/estadistica/grid',          [EstadisticaCrudController::class, 'grid'])->name('estadistica.grid');
        Route::post('/admin/trasnparencia/estadistica',               [EstadisticaCrudController::class, 'store'])->name('estadistica.store');
        Route::put('/admin/transparencia/estadistica/{estadistica}', [EstadisticaCrudController::class, 'update'])->name('estadistica.update');
        Route::delete('/admin/trasnparencia/estadistica/{estadistica}', [EstadisticaCrudController::class, 'destroy'])->name('estadistica.destroy');





        //Transparencia - Libro de Reclamaciones - Información imporante
        Route::get('/admin/libro-reclamaciones/informacion', [InfoImportanteController::class, 'index'])
            ->name('informacion-libro.index');

        Route::prefix('/admin/libro-reclamaciones/informacion')->name('informacion.')->group(function () {
            Route::get('/list',   [InfoImportanteController::class, 'list'])->name('list');
            Route::post('/',      [InfoImportanteController::class, 'store'])->name('store');
            Route::get('/{id}',   [InfoImportanteController::class, 'show'])->name('show');
            Route::put('/{id}',   [InfoImportanteController::class, 'update'])->name('update');
            Route::delete('/{id}', [InfoImportanteController::class, 'destroy'])->name('destroy');
        });


        //Transparencia - Libro de Reclamaciones - Tipo de Reclamación
        Route::get('/admin/libro-reclamaciones/tipo-reclamacion',                [TipoReclamacionController::class, 'index'])->name('tipo-reclamacion.index');
        Route::get('/admin/libro-reclamaciones/tipo-reclamacion/grid',           [TipoReclamacionController::class, 'grid'])->name('tipo-reclamacion.grid');
        Route::post('/admin/libro-reclamaciones/tipo-reclamacion',                [TipoReclamacionController::class, 'store'])->name('tipo-reclamacion.store');
        Route::put('/admin/libro-reclamaciones/tipo-reclamacion/{tipoReclamacion}', [TipoReclamacionController::class, 'update'])->name('tipo-reclamacion.update');
        Route::delete('/admin/libro-reclamaciones/tipo-reclamacion/{tipoReclamacion}', [TipoReclamacionController::class, 'destroy'])->name('tipo-reclamacion.destroy');


        //Transparencia - Libro de Reclamaciones - Marco Legal
        Route::get('/admin/libro-reclamaciones/marco-legal',                        [MarcoLegalController::class, 'index'])->name('marco-legal.index');
        Route::get('/admin/libro-reclamaciones/marco-legal/grid',                   [MarcoLegalController::class, 'grid'])->name('marco-legal.grid');
        Route::post('/admin/libro-reclamaciones/marco-legal',                        [MarcoLegalController::class, 'store'])->name('marco-legal.store');
        Route::put('/admin/libro-reclamaciones/marco-legal/{marcoLegal}',           [MarcoLegalController::class, 'update'])->name('marco-legal.update');
        Route::delete('/admin/libro-reclamaciones/marco-legal/{marcoLegal}',           [MarcoLegalController::class, 'destroy'])->name('marco-legal.destroy');


        // Transparencia - Libro de Reclamaciones - Reclamos
        Route::get('/admin/libro-reclamaciones/reclamos',                  [ReclamosController::class, 'index'])->name('reclamos.index');
        Route::get('/admin/libro-reclamaciones/reclamos/grid',             [ReclamosController::class, 'grid'])->name('reclamos.grid');
        Route::get('/admin/libro-reclamaciones/reclamos/tipos',            [ReclamosController::class, 'tipos'])->name('reclamos.tipos');
        Route::get('/admin/libro-reclamaciones/reclamos/estados',          [ReclamosController::class, 'estados'])->name('reclamos.estados');
        Route::put('/admin/libro-reclamaciones/reclamos/{reclamo}/estado', [ReclamosController::class, 'actualizarEstado'])->name('reclamos.estado.update');

        // CRUD de respuesta
        Route::post('/admin/libro-reclamaciones/reclamos/{reclamo}/respuesta', [ReclamosController::class, 'storeRespuesta'])->name('reclamos.respuesta.store');
        Route::put('/admin/libro-reclamaciones/reclamos/{reclamo}/respuesta', [ReclamosController::class, 'updateRespuesta'])->name('reclamos.respuesta.update');
        Route::delete('/admin/libro-reclamaciones/reclamos/{reclamo}/respuesta', [ReclamosController::class, 'destroyRespuesta'])->name('reclamos.respuesta.destroy');

        // Ver documento inline
        Route::get('/admin/libro-reclamaciones/reclamos/{reclamo}/respuesta/ver', [ReclamosController::class, 'verRespuesta'])->name('reclamos.respuesta.view');


        //Transparencia - Libro de Reclamaciones - Derechos
        Route::get('/admin/libro-reclamaciones/derechos',                   [DerechosController::class, 'index'])->name('derechos.index');
        Route::get('/admin/libro-reclamaciones/derechos/grid',              [DerechosController::class, 'grid'])->name('derechos.grid');
        Route::post('/admin/libro-reclamaciones/derechos',                   [DerechosController::class, 'store'])->name('derechos.store');
        Route::put('/admin/libro-reclamaciones/derechos/{derecho}',         [DerechosController::class, 'update'])->name('derechos.update');
        Route::delete('/admin/libro-reclamaciones/derechos/{derecho}',         [DerechosController::class, 'destroy'])->name('derechos.destroy');
    });

    // MODULO ADMINISTRADOR: SERVICIOS COMPLEMENTARIOS
    Route::middleware(['module:servicios_complementarios'])->group(function () {


        //Servicios Complementarios
        Route::get('/admin/servicios/gestionar',                   [ServiciosComplementariosController::class, 'index'])->name('servicios.index');
        Route::post('/admin/servicios/gestionar',                   [ServiciosComplementariosController::class, 'store'])->name('servicios.store');
        Route::put('/admin/servicios/gestionar/{servicio}',        [ServiciosComplementariosController::class, 'update'])->name('servicios.update');
        Route::delete('/admin/servicios/gestionar/{servicio}',        [ServiciosComplementariosController::class, 'destroy'])->name('servicios.destroy');


        //Horarios Servicios Complementarios
        Route::get('/admin/servicios/horario',                 [HorarioController::class, 'index'])->name('horario.index');
        Route::post('/admin/servicios/horario',                 [HorarioController::class, 'store'])->name('horario.store');
        Route::put('/admin/servicios/horario/{horario}',       [HorarioController::class, 'update'])->name('horario.update');
        Route::delete('/admin/servicios/horario/{horario}',       [HorarioController::class, 'destroy'])->name('horario.destroy');
    });

    // MODULO ADMINISTRADOR: NOTICIAS
    Route::middleware(['module:noticias'])->group(function () {

        //Noticias
        Route::get('/admin/noticias',                 [NoticiaController::class, 'index'])->name('admin-noticias.index');
        Route::post('/admin/noticias',                 [NoticiaController::class, 'store'])->name('noticias.store');
        Route::put('/admin/noticias/{noticia}',       [NoticiaController::class, 'update'])->name('noticias.update');
        Route::delete('/admin/noticias/{noticia}',       [NoticiaController::class, 'destroy'])->name('noticias.destroy');
    });



    // MODULO ADMINISTRADOR: LINKS INSTITUCIONALES
    Route::middleware(['module:links_institucionales'])->group(function () {

        //Links Institucionales
        Route::get('/admin/links-institucionales',                  [LinksInstitucionalesController::class, 'index'])->name('links.index');
        Route::post('/admin/links-institucionales',                  [LinksInstitucionalesController::class, 'store'])->name('links.store');
        Route::put('/admin/links-institucionales/{link}',           [LinksInstitucionalesController::class, 'update'])->name('links.update');
        Route::delete('/admin/links-institucionales/{link}',           [LinksInstitucionalesController::class, 'destroy'])->name('links.destroy');
    });

    // MODULO ADMINISTRADOR: CONTACTANOS
    Route::middleware(['module:contactanos'])->group(function () {

        // Contactanos - Información
        Route::get('/admin/contactanos',                   [ContactanosController::class, 'index'])->name('contactanos.index');
        Route::post('/admin/contactanos',                   [ContactanosController::class, 'store'])->name('contactanos.store');
        Route::put('/admin/contactanos/{contacto}',        [ContactanosController::class, 'update'])->name('contactanos.update');
        Route::delete('/admin/contactanos/{contacto}',        [ContactanosController::class, 'destroy'])->name('contactanos.destroy');

        // Contactanos - Redes
        Route::get('/admin/redes',                 [RedesController::class, 'index'])->name('redes.index');
        Route::post('/admin/redes',                 [RedesController::class, 'store'])->name('redes.store');
        Route::put('/admin/redes/{red}',           [RedesController::class, 'update'])->name('redes.update');
        Route::delete('/admin/redes/{red}',           [RedesController::class, 'destroy'])->name('redes.destroy');
    });
});  // <!------------------------------------- FIN MIDDLEWARE USER LOGIN ----------------------------------->


















// <!------------------------------------- PORTAL PRINCIPAL <!-------------------------------------

// PRESENTACION - RESEÑA HISTORICA
Route::get('/presentacion', [PresentacionController::class, 'showPublic'])
    ->name('nosotros.presentacion');


// MISION - VISION - VALORES
Route::get('/mision', [MisionVisionController::class, 'showPublic'])
    ->name('nosotros.mision');


// ORGANIGRAMA
Route::get('/organigrama', [OrganigramaController::class, 'showPublic'])
    ->name('nosotros.organigrama');


// PLANA JERARQUICA
Route::get('/jerarquica', [JerarquicaController::class, 'showPublic'])
    ->name('nosotros.jerarquica');


// PLANA DOCENTE
Route::get('/docente', [DocentePublicController::class, 'index'])->name('web.docente');
Route::get('/docente/{id}/personal', [DocentePublicController::class, 'personal'])->name('web.docente.personal');
Route::get('/docente/{id}/datos-academicos', [DocentePublicController::class, 'datosAcademicos'])->whereNumber('id')->name('web.docente.academicos');
Route::get('/docente/{id}/datos-laborales', [DocentePublicController::class, 'laborales'])->whereNumber('id')->name('web.docente.laborales');
Route::get('/docente/{id}/unidades', [DocentePublicController::class, 'unidades'])->whereNumber('id')->name('web.docente.unidades');


// LOCALES
Route::get('/locales', [LocalPublicController::class, 'index'])->name('web.locales');


// PROGRAMAS DE ESTUDIO
Route::get('/programas', [ProgramaController::class, 'show'])->name('programas.show');
Route::get('/programas/{programa}', [ProgramaController::class, 'show'])
    ->whereNumber('programa')
    ->name('programas.show.id');
// PDF de Malla Curricular
Route::get('/programas/{programa}/malla.pdf', [ProgramaController::class, 'mallaPdf'])
    ->whereNumber('programa')
    ->name('programas.malla.pdf');

// EFSRT
Route::get('/efsrt', [EfsrtController::class, 'index'])->name('efsrt.index');


// ADMISION
Route::get('/admisión', [AdmisionController::class, 'index'])->name('admision.index');


// MATRICULA
Route::get('/matricula', [MatriculaController::class, 'index'])->name('matricula.index');


// BECAS
Route::get('/becas', [BecasController::class, 'index'])->name('becas.index');


// DOCUMENTOS DE GESTIÓN
Route::get('/documentos', [DocumentoPublicController::class, 'index'])->name('web.documentos');
Route::get('/documentos/{documento}/pdf', [DocumentoPublicController::class, 'file'])->name('web.documentos.file');

// INVERSIONES
Route::get('/inversiones', [InversionPublicController::class, 'index'])->name('web.inversiones');
Route::get('/inversiones/{inversion}/pdf', [InversionPublicController::class, 'file'])->name('web.inversiones.file');


// LICENCIAMIENTO
Route::get('/licenciamiento', [LicenciamientoPublicController::class, 'index'])->name('web.lic');
Route::get('/licenciamiento/{licenciamiento}/pdf', [LicenciamientoPublicController::class, 'file'])->name('web.lic.file');


// ESTADISTICA
Route::get('/estadisticas', [EstadisticaPublicController::class, 'index'])->name('web.estadisticas');


// TUPA
Route::get('/tupa', [TupaPublicController::class, 'index'])->name('web.tupa');


// SERVICIOS COMPLEMENTARIOS
Route::get('/servicios_complementarios', [ServiciosPublicController::class, 'index'])->name('web.servicios');

// Contacto
Route::get('/contactanos', function () {
    return view('contacto.contactanos');
});
Route::get('/contacto', [ContactoPublicController::class, 'index'])->name('contacto.index');


// Otros
Route::get('/noticias', [NoticiaController::class, 'publicIndex'])->name('noticias.index');
Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show');


// Galeria
Route::get('/galeria', [GaleriaController::class, 'index'])->name('galeria.index');


// Libro de Reclamaciones
Route::get('/libro_reclamaciones', [LibroReclamacionesController::class, 'index'])->name('libro.index');
Route::post('/libro_reclamaciones', [LibroReclamacionesController::class, 'store'])->name('libro.store');
Route::get('/libro_reclamaciones/buscar', [LibroReclamacionesController::class, 'search'])->name('libro.search');
Route::get('/libro_reclamaciones/{reclamo}/respuesta/ver', [LibroReclamacionesController::class, 'verDocumento'])->name('libro.respuesta.ver');


// Lectura de Noticias
Route::get('/lectura', function () {
    return view('otros.lectura_noticias');
});


// Servicios de Trámites
Route::get('/servicios-tramites', function () {
    return view('tramites.servicio_tramite');
});
