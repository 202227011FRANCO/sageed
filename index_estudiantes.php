<?php
// index_estudiantes.php - Módulo independiente de Control de Estudiantes
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Estudiantes - SAGEED (TecNM)</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome para Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Configuración Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        tecnm: {
                            blue: '#1B396A',
                            gold: '#B38E5D',
                            light: '#F5F7FA',
                            dark: '#0F264A'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <!-- Contenedor de Notificaciones (Toasts) -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2 pointer-events-none"></div>

    <!-- HEADER -->
    <header class="bg-tecnm-blue text-white shadow-md border-b-4 border-tecnm-gold">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-white p-1.5 rounded-md">
                    <span class="text-tecnm-blue font-extrabold text-xl px-1">TecNM</span>
                </div>
                <div class="border-l-2 border-white/30 pl-3">
                    <h1 class="text-lg font-bold">SAGEED - Módulo Estudiantes</h1>
                    <p class="text-xs text-gray-300">Control y Registro del Padrón Dual</p>
                </div>
            </div>
            <a href="index.php" class="bg-white/10 hover:bg-white/20 text-white text-xs font-semibold px-3 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Volver al Inicio
            </a>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="flex-grow p-4 md:p-8 max-w-7xl mx-auto w-full space-y-6">
        
        <!-- Encabezado de Sección y Botón Agregar -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Control de Estudiantes Duales</h2>
                <p class="text-xs text-gray-500">Altas, bajas, estatus y documentos oficiales de estudiantes del TecNM</p>
            </div>
            <button onclick="openModal('estudiante')" class="bg-tecnm-blue hover:bg-tecnm-dark text-white text-sm px-4 py-2.5 rounded-lg shadow-sm font-semibold transition duration-200 flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Registrar Estudiante Dual
            </button>
        </div>

        <!-- Tabla y Filtros -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50 flex flex-wrap gap-2 justify-between items-center">
                <div class="relative w-full max-w-xs">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" id="buscar-estudiante" oninput="filtrarEstudiantes()" class="bg-white border border-gray-200 rounded-lg text-sm pl-10 pr-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-tecnm-blue" placeholder="Buscar por nombre o control...">
                </div>
                <div class="flex gap-2">
                    <select id="filtro-estatus" onchange="filtrarEstudiantes()" class="bg-white border border-gray-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-tecnm-blue">
                        <option value="TODOS">Todos los estatus</option>
                        <option value="ACTIVO">Activos</option>
                        <option value="EGRESADO">Egresados (Dual)</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-[11px] font-bold uppercase tracking-wider border-b border-gray-200">
                            <th class="px-6 py-3.5">Estudiante / Control</th>
                            <th class="px-6 py-3.5">Carrera & Género</th>
                            <th class="px-6 py-3.5">Unidad Económica</th>
                            <th class="px-6 py-3.5">Tipo Ingreso</th>
                            <th class="px-6 py-3.5">Estatus</th>
                            <th class="px-6 py-3.5 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-estudiantes-body" class="divide-y divide-gray-100 text-sm text-gray-700">
                        <!-- Llenado dinámico por estudiantes.js -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>


    <!-- ========================================== -->
    <!-- MODALES -->
    <!-- ========================================== -->

    <!-- 1. Modal Estudiante (Con CURP y Botones +) -->
    <div id="modal-estudiante" class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-xl shadow-xl border border-gray-100 w-full max-w-lg overflow-hidden transform transition-all">
            <div class="bg-tecnm-blue text-white p-4 flex justify-between items-center">
                <h3 class="font-bold flex items-center gap-2"><i class="fa-solid fa-user-graduate"></i> Registrar Estudiante Dual</h3>
                <button onclick="closeModal('estudiante')" class="text-white hover:text-gray-200"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            
            <form id="form-estudiante-data" onsubmit="guardarEstudiante(event)" class="p-5 space-y-4 text-xs">
                <!-- Nombre y Control -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Nombre Completo:</label>
                        <input type="text" id="est-nombre" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="Nombre completo">
                    </div>
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Número de Control:</label>
                        <input type="text" id="est-control" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="Número de Control">
                    </div>
                </div>
                
                <!-- CURP y Género -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">CURP:</label>
                        <input type="text" id="est-curp" required maxlength="18" class="w-full border border-gray-200 p-2 rounded-lg uppercase" placeholder="18 caracteres">
                    </div>
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Género:</label>
                        <select id="est-genero" required class="w-full border border-gray-200 p-2 rounded-lg">
                            <option value="H">Hombre</option>
                            <option value="M">Mujer</option>
                        </select>
                    </div>
                </div>

                <!-- Carrera y Tipo de Ingreso -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Carrera / Programa:</label>
                        <select id="est-carrera" required class="w-full border border-gray-200 p-2 rounded-lg">
                            <option value="Ingeniería en Sistemas Computacionales">Ingeniería en Sistemas Computacionales</option>
                            <option value="Ingeniería Industrial">Ingeniería Industrial</option>
                            <option value="Ingeniería Mecatrónica">Ingeniería Mecatrónica</option>
                            <option value="Licenciatura en Administración">Licenciatura en Administración</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Tipo de Ingreso:</label>
                        <select id="est-tipo-ingreso" required class="w-full border border-gray-200 p-2 rounded-lg">
                            <option value="Ingreso">Ingreso (Primer ingreso en Dual)</option>
                            <option value="Reingreso">Reingreso</option>
                        </select>
                    </div>
                </div>

                <!-- Empresa con Botón + -->
                <div>
                    <label class="block text-gray-600 font-semibold mb-1">Unidad Económica (Empresa):</label>
                    <div class="flex gap-2">
                        <select id="est-empresa" required class="w-full border border-gray-200 p-2 rounded-lg"></select>
                        <button type="button" onclick="openModal('empresa')" class="bg-tecnm-gold hover:opacity-90 text-white px-3 rounded-lg transition" title="Registrar Empresa">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Mentores con Botón + -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Mentor Académico:</label>
                        <div class="flex gap-2">
                            <select id="est-mentor-acad" required class="w-full border border-gray-200 p-2 rounded-lg"></select>
                            <button type="button" onclick="openModal('mentor-acad')" class="bg-tecnm-blue hover:opacity-90 text-white px-3 rounded-lg transition" title="Registrar Mentor Académico">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Mentor de la Empresa (UE):</label>
                        <div class="flex gap-2">
                            <select id="est-mentor-ue" required class="w-full border border-gray-200 p-2 rounded-lg"></select>
                            <button type="button" onclick="openModal('mentor-ue')" class="bg-slate-800 hover:opacity-90 text-white px-3 rounded-lg transition" title="Registrar Mentor de UE">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-tecnm-blue hover:bg-tecnm-dark text-white font-bold py-2.5 rounded-lg shadow transition">
                    Guardar Estudiante Dual
                </button>
            </form>
        </div>
    </div>

    <!-- 2. Modal Empresa -->
    <div id="modal-empresa" class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-xl shadow-xl border border-gray-100 w-full max-w-md overflow-hidden transform transition-all">
            <div class="bg-tecnm-blue text-white p-4 flex justify-between items-center">
                <h3 class="font-bold flex items-center gap-2"><i class="fa-solid fa-building"></i> Registrar Empresa</h3>
                <button onclick="closeModal('empresa')" class="text-white hover:text-gray-200"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <!-- NOTA: Al guardar, actualiza los selectores del estudiante automáticamente -->
            <form id="form-empresa-data" onsubmit="guardarEmpresa(event).then(() => cargarSelectoresEstudiante())" class="p-5 space-y-4 text-xs">
                <div>
                    <label class="block text-gray-600 font-semibold mb-1">Razón Social / Nombre Comercial:</label>
                    <input type="text" id="emp-nombre" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="Ej. Ford Motor Company">
                </div>
                <div>
                    <label class="block text-gray-600 font-semibold mb-1">Giro / Sector Económico:</label>
                    <input type="text" id="emp-giro" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="Ej. Automotriz / Industrial">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">RFC de la Empresa:</label>
                        <input type="text" id="emp-rfc" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="RFC">
                    </div>
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Contacto Principal (RH):</label>
                        <input type="text" id="emp-contacto" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="Responsable">
                    </div>
                </div>
                <button type="submit" class="w-full bg-tecnm-blue hover:bg-tecnm-dark text-white font-bold py-2.5 rounded-lg shadow transition">
                    Guardar Empresa
                </button>
            </form>
        </div>
    </div>

    <!-- 3. Modal Mentor Académico -->
    <div id="modal-mentor-acad" class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-xl shadow-xl border border-gray-100 w-full max-w-md overflow-hidden transform transition-all">
            <div class="bg-tecnm-blue text-white p-4 flex justify-between items-center">
                <h3 class="font-bold flex items-center gap-2"><i class="fa-solid fa-chalkboard-user"></i> Registrar Mentor Académico</h3>
                <button onclick="closeModal('mentor-acad')" class="text-white hover:text-gray-200"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <!-- NOTA: Al guardar, actualiza los selectores del estudiante automáticamente -->
            <form id="form-mentor-acad-data" onsubmit="guardarMentorAcad(event).then(() => cargarSelectoresEstudiante())" class="p-5 space-y-4 text-xs">
                <div>
                    <label class="block text-gray-600 font-semibold mb-1">Nombre del Docente:</label>
                    <input type="text" id="m-acad-nombre" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="Ej. M. en C. Juan Pérez">
                </div>
                <div>
                    <label class="block text-gray-600 font-semibold mb-1">Área Académica / Departamento:</label>
                    <input type="text" id="m-acad-area" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="Ej. Sistemas y Computación">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Teléfono / Ext:</label>
                        <input type="text" id="m-acad-tel" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="Contacto">
                    </div>
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Correo Electrónico:</label>
                        <input type="email" id="m-acad-correo" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="institucional@tecnm.mx">
                    </div>
                </div>
                <button type="submit" class="w-full bg-tecnm-blue hover:bg-tecnm-dark text-white font-bold py-2.5 rounded-lg shadow transition">
                    Guardar Mentor Académico
                </button>
            </form>
        </div>
    </div>

    <!-- 4. Modal Mentor Empresa -->
    <div id="modal-mentor-ue" class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-xl shadow-xl border border-gray-100 w-full max-w-md overflow-hidden transform transition-all">
            <div class="bg-tecnm-blue text-white p-4 flex justify-between items-center">
                <h3 class="font-bold flex items-center gap-2"><i class="fa-solid fa-user-tie"></i> Registrar Mentor Empresa</h3>
                <button onclick="closeModal('mentor-ue')" class="text-white hover:text-gray-200"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <!-- NOTA: Al guardar, actualiza los selectores del estudiante automáticamente -->
            <form id="form-mentor-ue-data" onsubmit="guardarMentorUE(event).then(() => cargarSelectoresEstudiante())" class="p-5 space-y-4 text-xs">
                <div>
                    <label class="block text-gray-600 font-semibold mb-1">Nombre Completo del Mentor:</label>
                    <input type="text" id="m-ue-nombre" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="Nombre completo">
                </div>
                <div>
                    <label class="block text-gray-600 font-semibold mb-1">Unidad Económica (Empresa):</label>
                    <!-- Aquí se usa la función cargarSelectoresEmpresa() desde mentores.js al abrir el modal -->
                    <select id="m-ue-empresa" required class="w-full border border-gray-200 p-2 rounded-lg"></select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Cargo / Puesto:</label>
                        <input type="text" id="m-ue-cargo" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="Ej. Líder de TI / Planta">
                    </div>
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Correo Electrónico:</label>
                        <input type="email" id="m-ue-correo" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="ejemplo@empresa.com">
                    </div>
                </div>
                <button type="submit" class="w-full bg-tecnm-blue hover:bg-tecnm-dark text-white font-bold py-2.5 rounded-lg shadow transition">
                    Guardar Mentor Empresa
                </button>
            </form>
        </div>
    </div>


    <!-- SCRIPTS MODULARES -->
    <!-- Cargamos los scripts necesarios para que los modales y la tabla funcionen -->
    <script src="assets/js/app.js"></script>
    <script src="assets/js/empresas.js"></script>
    <script src="assets/js/mentores.js"></script>
    <script src="assets/js/estudiantes.js"></script>

    <!-- INICIALIZADOR DE LA PÁGINA -->
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            // Cargar los datos y pintar la tabla de estudiantes al abrir la página
            if (typeof renderEstudiantes === 'function') {
                await renderEstudiantes();
            }
        });
    </script>
</body>
</html>