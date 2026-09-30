<?php
// index.php - SAGEED Sistema de Gestión de Educación Dual
// Página principal que renderiza toda la interfaz del sistema
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAGEED - Sistema de Gestión de Educación Dual (TecNM)</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome para Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind Config -->
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
    
    <!-- CSS propio del sistema -->
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <!-- HEADER / BARRA DE NAVEGACIÓN PRINCIPAL -->
    <header class="bg-tecnm-blue text-white shadow-md border-b-4 border-tecnm-gold">
        <div class="container mx-auto px-4 py-3 flex flex-wrap items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-white p-1.5 rounded-md shadow-inner">
                    <span class="text-tecnm-blue font-extrabold text-xl tracking-wider px-1">TecNM</span>
                </div>
                <div class="border-l-2 border-white/30 pl-3">
                    <h1 class="text-lg font-bold tracking-tight">SAGEED</h1>
                    <p class="text-xs text-gray-300 hidden sm:block">Sistema de Gestión de Educación Dual • EdoMéx</p>
                </div>
            </div>
            <div class="flex items-center space-x-4 mt-2 sm:mt-0">
                <span class="bg-white/10 text-xs px-2.5 py-1 rounded-full text-white flex items-center gap-1.5 border border-white/20">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Alineado a Manual ED_20190605
                </span>
                <div class="text-right hidden md:block">
                    <p class="text-xs text-gray-300">Coordinación Institucional</p>
                    <p class="text-sm font-semibold text-white">Tecnológico de Estudios Superiores</p>
                </div>
            </div>
        </div>
    </header>

    <!-- NAVEGACIÓN Y ÁREA PRINCIPAL -->
    <div class="flex-grow flex flex-col md:flex-row">
        <!-- SIDEBAR DE NAVEGACIÓN -->
        <aside class="w-full md:w-64 bg-tecnm-dark text-white p-4 shrink-0 flex flex-col gap-2">
            <div class="text-xs uppercase text-gray-400 tracking-wider font-semibold px-3 py-2">Módulos SAGEED</div>
            <nav class="space-y-1 flex-grow">
                <button onclick="switchTab('dashboard')" id="btn-tab-dashboard" class="nav-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-200 bg-tecnm-blue text-white">
                    <i class="fa-solid fa-chart-line w-5 text-center text-tecnm-gold"></i>
                    <span>Dashboard General</span>
                </button>
                <button onclick="switchTab('estudiantes')" id="btn-tab-estudiantes" class="nav-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:bg-white/10 hover:text-white transition duration-200">
                    <i class="fa-solid fa-user-graduate w-5 text-center text-gray-400"></i>
                    <span>Control Estudiantes</span>
                </button>
                <button onclick="switchTab('empresas')" id="btn-tab-empresas" class="nav-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:bg-white/10 hover:text-white transition duration-200">
                    <i class="fa-solid fa-building w-5 text-center text-gray-400"></i>
                    <span>Unidades Económicas</span>
                </button>
                <button onclick="switchTab('mentores')" id="btn-tab-mentores" class="nav-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:bg-white/10 hover:text-white transition duration-200">
                    <i class="fa-solid fa-users-gear w-5 text-center text-gray-400"></i>
                    <span>Padrón de Mentores</span>
                </button>
                <button onclick="switchTab('competencias')" id="btn-tab-competencias" class="nav-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:bg-white/10 hover:text-white transition duration-200">
                    <i class="fa-solid fa-rectangle-list w-5 text-center text-gray-400"></i>
                    <span>Competencias (Anexo 1.1)</span>
                </button>
                <button onclick="switchTab('formatos')" id="btn-tab-formatos" class="nav-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:bg-white/10 hover:text-white transition duration-200">
                    <i class="fa-solid fa-file-signature w-5 text-center text-gray-400"></i>
                    <span>Llenado de Anexos</span>
                </button>
            </nav>
            <div class="border-t border-white/10 pt-4 mt-auto">
                <div class="bg-white/5 p-3 rounded-lg text-xs text-gray-300 space-y-1">
                    <p class="font-bold text-white"><i class="fa-solid fa-info-circle text-tecnm-gold"></i> Manual EdoMéx</p>
                    <p class="text-[10px]">Alineado al Manual para la Operación de la Educación Dual en los tipos educativos Medio Superior y Superior.</p>
                </div>
            </div>
        </aside>

        <!-- PANEL DE CONTENIDO DINÁMICO -->
        <main class="flex-grow p-4 md:p-6 lg:p-8 max-w-7xl mx-auto w-full">

            <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2 pointer-events-none"></div>

            <!-- TAB 1: DASHBOARD -->
            <section id="tab-dashboard" class="tab-content space-y-6">
                <div class="bg-gradient-to-r from-tecnm-blue to-tecnm-dark text-white rounded-xl p-6 shadow-md relative overflow-hidden">
                    <div class="absolute right-0 bottom-0 transform translate-x-10 translate-y-10 opacity-10">
                        <i class="fa-solid fa-graduation-cap text-9xl"></i>
                    </div>
                    <div class="relative z-10">
                        <span class="text-tecnm-gold text-xs font-bold uppercase tracking-wider">PANEL DE CONTROL GENERAL</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold mt-1">Seguimiento Institucional de Educación Dual</h2>
                        <p class="text-sm text-gray-200 mt-2 max-w-2xl">Métrica del Programa de Educación Dual alineada a los indicadores clave de calidad y egreso del Convenio Colectivo.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">Estudiantes Activos</span>
                            <h3 class="text-3xl font-extrabold text-gray-800 mt-1" id="dash-total-estudiantes">0</h3>
                            <div class="flex gap-2 text-xs text-gray-500 mt-2">
                                <span class="font-medium text-emerald-600" id="dash-ingresos-badge">0 Nuevo Ingreso</span>
                                <span class="font-medium text-blue-600" id="dash-reingresos-badge">0 Reingreso</span>
                            </div>
                        </div>
                        <div class="bg-blue-50 text-tecnm-blue p-4 rounded-xl">
                            <i class="fa-solid fa-user-graduate text-2xl"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">Tasa de Egresados</span>
                            <h3 class="text-3xl font-extrabold text-gray-800 mt-1" id="dash-total-egresados">0</h3>
                            <p class="text-xs text-emerald-600 font-medium mt-2"><i class="fa-solid fa-circle-check"></i> Egresados Dual (No eliminados)</p>
                        </div>
                        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl">
                            <i class="fa-solid fa-user-check text-2xl"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">Empresas (UE)</span>
                            <h3 class="text-3xl font-extrabold text-gray-800 mt-1" id="dash-total-empresas">0</h3>
                            <p class="text-xs text-gray-500 mt-2">Unidades Económicas Activas</p>
                        </div>
                        <div class="bg-purple-50 text-purple-600 p-4 rounded-xl">
                            <i class="fa-solid fa-building text-2xl"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">Género</span>
                            <div class="flex items-baseline space-x-2 mt-1">
                                <span class="text-2xl font-extrabold text-sky-600" id="dash-hombres-pct">0%</span>
                                <span class="text-xs text-gray-400">H /</span>
                                <span class="text-2xl font-extrabold text-pink-500" id="dash-mujeres-pct">0%</span>
                                <span class="text-xs text-gray-400">M</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Distribución de estudiantes</p>
                        </div>
                        <div class="bg-pink-50 text-pink-500 p-4 rounded-xl">
                            <i class="fa-solid fa-venus-mars text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Métricas Demográficas y de Ingreso</h4>
                            <p class="text-xs text-gray-500 mb-4">Proporción general e historial del periodo actual</p>
                            <div class="flex justify-center items-center py-4 relative">
                                <svg class="w-40 h-40 transform -rotate-90" viewBox="0 0 42 42">
                                    <circle class="donut-hole" cx="21" cy="21" r="15.915" fill="#fff" role="img"></circle>
                                    <circle class="donut-ring" cx="21" cy="21" r="15.915" fill="transparent" stroke="#e2e8f0" stroke-width="4.5" role="img"></circle>
                                    <circle id="donut-segment-hombres" class="donut-segment transition-all duration-500" cx="21" cy="21" r="15.915" fill="transparent" stroke="#0284c7" stroke-width="4.5" stroke-dasharray="50 50" stroke-dashoffset="0" role="img"></circle>
                                    <circle id="donut-segment-mujeres" class="donut-segment transition-all duration-500" cx="21" cy="21" r="15.915" fill="transparent" stroke="#ec4899" stroke-width="4.5" stroke-dasharray="50 50" stroke-dashoffset="50" role="img"></circle>
                                </svg>
                                <div class="absolute text-center">
                                    <span class="text-2xl font-black text-gray-700" id="donut-total-count">0</span>
                                    <p class="text-[9px] uppercase tracking-wider text-gray-400">Totales</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-4 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-sky-600 block"></span>
                                    <span class="text-gray-600 font-medium">Hombres</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-pink-500 block"></span>
                                    <span class="text-gray-600 font-medium">Mujeres</span>
                                </div>
                            </div>
                        </div>
                        <div class="border-t border-gray-100 pt-4 mt-4">
                            <span class="text-xs font-semibold text-gray-500 uppercase block mb-2">Ingresos y Reingresos del programa:</span>
                            <div class="flex justify-between items-center bg-gray-50 p-2.5 rounded-lg text-xs">
                                <div>
                                    <span class="text-gray-500">Nuevos Ingresos:</span>
                                    <span class="font-bold text-gray-800 ml-1" id="dash-nuevo-ingreso-count">0</span>
                                </div>
                                <div class="border-l border-gray-200 h-4"></div>
                                <div>
                                    <span class="text-gray-500">Reingresos:</span>
                                    <span class="font-bold text-gray-800 ml-1" id="dash-reingreso-count">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 lg:col-span-2 flex flex-col">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h4 class="font-bold text-gray-800">Unidades Económicas Activas</h4>
                                <p class="text-xs text-gray-500">Estudiantes asignados a cada empresa colaboradora</p>
                            </div>
                            <span class="bg-tecnm-blue/10 text-tecnm-blue font-semibold text-xs px-2.5 py-1 rounded-full" id="dash-empresas-badge">0 Empresas</span>
                        </div>
                        <div class="overflow-y-auto max-h-[260px] flex-grow pr-1 space-y-3" id="dash-lista-empresas"></div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h4 class="font-bold text-gray-800 mb-1">Padrón de Estudiantes por Tipo de Ingreso</h4>
                    <p class="text-xs text-gray-500 mb-4">Historial de reingresos y nuevas incorporaciones del ciclo dual activo</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border border-emerald-100 rounded-lg p-4 bg-emerald-50/20">
                            <h5 class="font-bold text-emerald-800 text-sm mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-user-plus text-emerald-600"></i> Nuevos Ingresos en Dual
                            </h5>
                            <div class="overflow-y-auto max-h-[180px] space-y-2 pr-1" id="dash-lista-ingresos"></div>
                        </div>
                        <div class="border border-blue-100 rounded-lg p-4 bg-blue-50/20">
                            <h5 class="font-bold text-blue-800 text-sm mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-arrows-spin text-blue-600"></i> Reingresos del Programa
                            </h5>
                            <div class="overflow-y-auto max-h-[180px] space-y-2 pr-1" id="dash-lista-reingresos"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- TAB 2: ESTUDIANTES -->
            <section id="tab-estudiantes" class="tab-content hidden space-y-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Control de Estudiantes Duales</h2>
                        <p class="text-xs text-gray-500">Altas, bajas, estatus y documentos oficiales de estudiantes del TecNM</p>
                    </div>
                    <button onclick="openModal('estudiante')" class="bg-tecnm-blue hover:bg-tecnm-dark text-white text-sm px-4 py-2.5 rounded-lg shadow-sm font-semibold transition duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Registrar Estudiante Dual
                    </button>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 flex flex-wrap gap-2 justify-between items-center">
                        <div class="relative w-full max-w-xs">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" id="buscar-estudiante" oninput="filtrarEstudiantes()" class="bg-white border border-gray-200 rounded-lg text-sm pl-10 pr-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-tecnm-blue focus:border-transparent" placeholder="Buscar por nombre o control...">
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
                                    <th class="px-6 py-3.5">Convenio Subido</th>
                                    <th class="px-6 py-3.5">Estatus</th>
                                    <th class="px-6 py-3.5 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-estudiantes-body" class="divide-y divide-gray-100 text-sm text-gray-700"></tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- TAB 3: EMPRESAS -->
            <section id="tab-empresas" class="tab-content hidden space-y-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Unidades Económicas Colaboradoras</h2>
                        <p class="text-xs text-gray-500">Directorio de empresas afiliadas con convenio para la Educación Dual (Anexo 2.1 y 2.2)</p>
                    </div>
                    <button onclick="openModal('empresa')" class="bg-tecnm-blue hover:bg-tecnm-dark text-white text-sm px-4 py-2.5 rounded-lg shadow-sm font-semibold transition duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Registrar Empresa (UE)
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="directorio-empresas"></div>
            </section>

            <!-- TAB 4: MENTORES -->
            <section id="tab-mentores" class="tab-content hidden space-y-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Padrón de Mentores</h2>
                        <p class="text-xs text-gray-500">Mentores Académicos (Institución) y Mentores de Unidades Económicas (Empresas)</p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="openModal('mentor-acad')" class="bg-tecnm-blue hover:bg-tecnm-dark text-white text-sm px-4 py-2.5 rounded-lg shadow-sm font-semibold transition duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-plus"></i> Mentor Académico
                        </button>
                        <button onclick="openModal('mentor-ue')" class="bg-tecnm-gold hover:opacity-90 text-white text-sm px-4 py-2.5 rounded-lg shadow-sm font-semibold transition duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-plus"></i> Mentor Empresa
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-4 bg-gradient-to-r from-tecnm-blue to-tecnm-dark text-white flex justify-between items-center">
                            <h3 class="font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                                <i class="fa-solid fa-chalkboard-user text-tecnm-gold"></i> Mentores Académicos
                            </h3>
                            <span class="bg-white/20 text-xs px-2 py-0.5 rounded-full" id="count-mentores-acad">0</span>
                        </div>
                        <div class="divide-y divide-gray-100 overflow-y-auto max-h-[400px]" id="lista-mentores-academicos"></div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-4 bg-gradient-to-r from-slate-800 to-slate-900 text-white flex justify-between items-center">
                            <h3 class="font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                                <i class="fa-solid fa-user-tie text-tecnm-gold"></i> Mentores de Unidad Económica
                            </h3>
                            <span class="bg-white/20 text-xs px-2 py-0.5 rounded-full" id="count-mentores-ue">0</span>
                        </div>
                        <div class="divide-y divide-gray-100 overflow-y-auto max-h-[400px]" id="lista-mentores-ue"></div>
                    </div>
                </div>
            </section>

            <!-- TAB 5: COMPETENCIAS -->
            <section id="tab-competencias" class="tab-content hidden space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Catálogo de Competencias por Programa Educativo (Anexo 1.1)</h2>
                    <p class="text-xs text-gray-500 mb-4">Administración oficial del perfil formativo del programa educativo del TecNM y las competencias requeridas a desarrollar durante su estadía dual.</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 h-fit space-y-4">
                            <h4 class="font-bold text-sm text-gray-700 uppercase tracking-wider border-b border-gray-200 pb-2">Registrar Competencia</h4>
                            <form id="form-competencia" onsubmit="guardarCompetencia(event)" class="space-y-3 text-xs">
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Programa Educativo (Carrera):</label>
                                    <select id="comp-carrera" required class="w-full border border-gray-200 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-tecnm-blue">
                                        <option value="Ingeniería en Sistemas Computacionales">Ingeniería en Sistemas Computacionales</option>
                                        <option value="Ingeniería Industrial">Ingeniería Industrial</option>
                                        <option value="Ingeniería Mecatrónica">Ingeniería Mecatrónica</option>
                                        <option value="Licenciatura en Administración">Licenciatura en Administración</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Código / Asignatura Relacionada:</label>
                                    <input type="text" id="comp-codigo" required placeholder="Ej. SC-01 o Base de Datos" class="w-full border border-gray-200 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-tecnm-blue">
                                </div>
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Descripción de la Competencia:</label>
                                    <textarea id="comp-descripcion" required rows="4" placeholder="Capacidad de diseñar, implementar y administrar bases de datos relacionales..." class="w-full border border-gray-200 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-tecnm-blue"></textarea>
                                </div>
                                <button type="submit" class="w-full bg-tecnm-blue hover:bg-tecnm-dark text-white font-bold p-2.5 rounded-lg shadow-sm transition">
                                    Registrar Competencia
                                </button>
                            </form>
                        </div>

                        <div class="md:col-span-2 space-y-4">
                            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                                <h4 class="font-bold text-sm text-gray-700 uppercase tracking-wider">Competencias Registradas</h4>
                                <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-2.5 py-0.5 rounded-full" id="count-competencias">0 Competencias</span>
                            </div>
                            <div class="space-y-3 overflow-y-auto max-h-[450px]" id="lista-competencias-container"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- TAB 6: FORMATOS Y ANEXOS -->
            <section id="tab-formatos" class="tab-content hidden space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Generador de Documentos y Anexos ED</h2>
                    <p class="text-xs text-gray-500 mb-4">Llene y genere de forma automatizada los formatos especificados por el Manual de Operación de Educación Dual (Anexo 5.1, 5.4 y 5.5).</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">1. Seleccione Estudiante Dual:</label>
                            <select id="selector-formato-estudiante" onchange="actualizarPrevisualizacionFormatos()" class="w-full border border-gray-200 p-2.5 rounded-lg text-sm focus:ring-2 focus:ring-tecnm-blue"></select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">2. Tipo de Anexo a Generar:</label>
                            <select id="selector-tipo-anexo" onchange="mostrarCamposFormatoEspecifico()" class="w-full border border-gray-200 p-2.5 rounded-lg text-sm focus:ring-2 focus:ring-tecnm-blue">
                                <option value="5.1">Anexo 5.1 - Plan de Formación</option>
                                <option value="5.4">Anexo 5.4 - Reporte de Actividades</option>
                                <option value="5.5">Anexo 5.5 - Seguimiento y Evaluación</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button onclick="generarImpresionAnexo()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-sm text-sm transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-print"></i> Generar Formato PDF
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Formulario de llenado -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h4 class="font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2" id="formato-anexo-titulo">Datos de Llenado - Plan de Formación</h4>

                        <!-- FORMULARIO ANEXO 5.1 -->
                        <div id="form-anexo-51-campos" class="space-y-3 text-xs">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Nombre del Proyecto o Plan de Rotación:</label>
                                    <input type="text" id="an51-proyecto" value="Sistema de Control de Inventarios" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Unidad Económica:</label>
                                    <input type="text" id="an51-ue" value="Chrysler de México S.A de C.V" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Institución Educativa:</label>
                                    <input type="text" id="an51-ie" value="Tecnológico de Estudios Superiores de Chalco" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Programa Educativo:</label>
                                    <input type="text" id="an51-programa" value="Ingeniería en Sistemas Computacionales" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">No. Estudiantes Dual:</label>
                                    <input type="number" id="an51-num-est" value="3" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">No. Mentores UE:</label>
                                    <input type="number" id="an51-num-ment-ue" value="2" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">No. Mentores Académicos:</label>
                                    <input type="number" id="an51-num-ment-acad" value="2" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-600 font-semibold mb-1">Duración del Plan de Formación en Periodos:</label>
                                <input type="text" id="an51-duracion" value="4 Periodos (Semestral)" class="w-full border border-gray-200 p-2 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-gray-600 font-semibold mb-1">DESCRIPCIÓN DEL PROYECTO (¿QUÉ?, ¿CÓMO?, ¿DÓNDE?, ¿CUÁNDO?, ¿PARA QUÉ?):</label>
                                <textarea id="an51-desc-proyecto" rows="4" class="w-full border border-gray-200 p-2 rounded-lg">Desarrollo de un sistema web para la gestión de inventarios en la planta de producción, utilizando tecnologías .NET y SQL Server, con el fin de optimizar los tiempos de respuesta y reducir errores en el control de stock.</textarea>
                            </div>

                            <!-- Tabla de Competencias y Asignaturas -->
                            <div class="border-t border-gray-100 pt-3">
                                <p class="font-bold text-gray-700 mb-2">COMPETENCIAS A DESARROLLAR / ASIGNATURAS</p>
                                <div class="space-y-2">
                                    <div class="grid grid-cols-3 gap-1 text-[10px] font-semibold text-gray-500">
                                        <span>No.</span>
                                        <span>Competencia</span>
                                        <span>Asignatura</span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-1">
                                        <input type="text" value="1" class="border border-gray-200 p-1 rounded text-center" readonly>
                                        <input type="text" id="comp1-nombre" value="Modelado de Bases de Datos" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="comp1-asig" value="Base de Datos" class="border border-gray-200 p-1 rounded">
                                    </div>
                                    <div class="grid grid-cols-3 gap-1">
                                        <input type="text" value="2" class="border border-gray-200 p-1 rounded text-center" readonly>
                                        <input type="text" id="comp2-nombre" value="Programación Orientada a Objetos" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="comp2-asig" value="Programación Web" class="border border-gray-200 p-1 rounded">
                                    </div>
                                    <div class="grid grid-cols-3 gap-1">
                                        <input type="text" value="3" class="border border-gray-200 p-1 rounded text-center" readonly>
                                        <input type="text" id="comp3-nombre" value="Trabajo en Equipo" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="comp3-asig" value="Ingeniería de Software" class="border border-gray-200 p-1 rounded">
                                    </div>
                                    <div class="grid grid-cols-3 gap-1">
                                        <input type="text" value="4" class="border border-gray-200 p-1 rounded text-center" readonly>
                                        <input type="text" id="comp4-nombre" value="" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="comp4-asig" value="" class="border border-gray-200 p-1 rounded">
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de Actividades -->
                            <div class="border-t border-gray-100 pt-3">
                                <p class="font-bold text-gray-700 mb-2">ACTIVIDADES A REALIZAR PARA DESARROLLAR LAS COMPETENCIAS</p>
                                <div class="space-y-2">
                                    <div class="grid grid-cols-6 gap-1 text-[10px] font-semibold text-gray-500">
                                        <span>No. Comp.</span>
                                        <span>Actividades</span>
                                        <span>Horas</span>
                                        <span>Evidencias</span>
                                        <span>Lugar UE/IE</span>
                                        <span>Ponderación</span>
                                    </div>
                                    <div class="grid grid-cols-6 gap-1">
                                        <input type="text" value="1" class="border border-gray-200 p-1 rounded text-center" readonly>
                                        <input type="text" id="act1-desc" value="Diseño del modelo entidad-relación" class="border border-gray-200 p-1 rounded">
                                        <input type="number" id="act1-horas" value="40" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="act1-ev" value="Diagrama ER" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="act1-lugar" value="UE" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="act1-pond" value="10%" class="border border-gray-200 p-1 rounded">
                                    </div>
                                    <div class="grid grid-cols-6 gap-1">
                                        <input type="text" value="2" class="border border-gray-200 p-1 rounded text-center" readonly>
                                        <input type="text" id="act2-desc" value="Desarrollo de módulos en C#" class="border border-gray-200 p-1 rounded">
                                        <input type="number" id="act2-horas" value="80" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="act2-ev" value="Código fuente" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="act2-lugar" value="UE" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="act2-pond" value="20%" class="border border-gray-200 p-1 rounded">
                                    </div>
                                    <div class="grid grid-cols-6 gap-1">
                                        <input type="text" value="3" class="border border-gray-200 p-1 rounded text-center" readonly>
                                        <input type="text" id="act3-desc" value="Reuniones de sprint y planificación" class="border border-gray-200 p-1 rounded">
                                        <input type="number" id="act3-horas" value="20" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="act3-ev" value="Actas de reunión" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="act3-lugar" value="IE" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="act3-pond" value="10%" class="border border-gray-200 p-1 rounded">
                                    </div>
                                    <div class="grid grid-cols-6 gap-1">
                                        <input type="text" value="4" class="border border-gray-200 p-1 rounded text-center" readonly>
                                        <input type="text" id="act4-desc" value="" class="border border-gray-200 p-1 rounded">
                                        <input type="number" id="act4-horas" value="" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="act4-ev" value="" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="act4-lugar" value="" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="act4-pond" value="" class="border border-gray-200 p-1 rounded">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-600 font-semibold mb-1">Número de horas a la semana del Estudiante Dual en la UE:</label>
                                <input type="number" id="an51-horas-semana" value="20" class="w-full border border-gray-200 p-2 rounded-lg">
                            </div>
                        </div>

                        <!-- FORMULARIO ANEXO 5.4 (ALINEADO A FORMATO OFICIAL 2026) -->
                        <div id="form-anexo-54-campos" class="hidden space-y-4 text-xs">
                            <form id="form-anexo54-db" onsubmit="guardarAnexo54(event)" class="space-y-4">
                        
                                <!-- 1.- DATOS GENERALES -->
                                <div class="border-b border-gray-100 pb-2">
                                    <p class="font-bold text-tecnm-blue uppercase">1.- Datos Generales</p>
                                </div>
                        
                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-gray-600 font-semibold mb-1">(1) Número de Reporte:</label>
                                        <input type="text" id="an54-num-reporte" name="num_reporte" value="1" class="w-full border                         border-gray-200 p-2 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-gray-600 font-semibold mb-1">Fecha de Elaboración:</label>
                                        <input type="date" id="an54-fecha" name="fecha" value="2026-09-25" class="w-full border                         border-gray-200 p-2 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-gray-600 font-semibold mb-1">(2) Periodo del Reporte:</label>
                                        <input type="text" id="an54-periodo" name="periodo" value="Semana 1 a 4" class="w-full border                         border-gray-200 p-2 rounded-lg">
                                    </div>
                                </div>
                        
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-gray-600 font-semibold mb-1">(3) Nombre del Proyecto o Plan de                         Rotación:</label>
                                        <input type="text" id="an54-proyecto" name="proyecto" value="Sistema de Control de Inventarios"                         class="w-full border border-gray-200 p-2 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-gray-600 font-semibold mb-1">(4) Unidad Económica:</label>
                                        <input type="text" id="an54-ue" name="ue" placeholder="Se toma del estudiante o escribe aquí"                         class="w-full border border-gray-200 p-2 rounded-lg">
                                    </div>
                                </div>
                        
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-gray-600 font-semibold mb-1">(5) Institución Educativa:</label>
                                        <input type="text" id="an54-ie" name="ie" value="Tecnológico de Estudios Superiores de Chalco"                         class="w-full border border-gray-200 p-2 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-gray-600 font-semibold mb-1">(6) Programa Educativo:</label>
                                        <input type="text" id="an54-programa" name="programa" value="Ingeniería en Sistemas                         Computacionales" class="w-full border border-gray-200 p-2 rounded-lg">
                                    </div>
                                </div>
                        
                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-gray-600 font-semibold mb-1">(8) Teléfono Estudiante:</label>
                                        <input type="text" id="an54-tel-est" name="tel_est" value="55 1234 5678" class="w-full border                         border-gray-200 p-2 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-gray-600 font-semibold mb-1">(8) Teléfono Mentor UE:</label>
                                        <input type="text" id="an54-tel-ue" name="tel_ue" value="55 8765 4321" class="w-full border                         border-gray-200 p-2 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-gray-600 font-semibold mb-1">(8) Teléfono Mentor Académico:</label>
                                        <input type="text" id="an54-tel-acad" name="tel_acad" value="55 1122 3344" class="w-full border                         border-gray-200 p-2 rounded-lg">
                                    </div>
                                </div>
                        
                                <!-- 2.- DESARROLLO DE COMPETENCIAS -->
                                <div class="border-t border-gray-100 pt-3">
                                    <p class="font-bold text-tecnm-blue uppercase mb-2">2.- Desarrollo de Competencias</p>
                                    <div class="space-y-2">
                                        <div class="grid grid-cols-12 gap-1 text-[10px] font-semibold text-gray-500">
                                            <span class="col-span-2 text-center">No.</span>
                                            <span class="col-span-5">(11) Competencias a Desarrollar</span>
                                            <span class="col-span-5">(12) Asignaturas</span>
                                        </div>
                                        <div class="grid grid-cols-12 gap-1">
                                            <input type="text" value="1" class="col-span-2 border border-gray-200 p-1 rounded                         text-center" readonly>
                                            <input type="text" id="an54-comp1-nom" value="Modelado de Bases de Datos" class="col-span-5                         border border-gray-200 p-1 rounded">
                                            <input type="text" id="an54-comp1-asig" value="Taller de Base de Datos" class="col-span-5                         border border-gray-200 p-1 rounded">
                                        </div>
                                        <div class="grid grid-cols-12 gap-1">
                                            <input type="text" value="2" class="col-span-2 border border-gray-200 p-1 rounded                         text-center" readonly>
                                            <input type="text" id="an54-comp2-nom" value="Desarrollo de APIs REST" class="col-span-5                         border border-gray-200 p-1 rounded">
                                            <input type="text" id="an54-comp2-asig" value="Programación Web" class="col-span-5 border                         border-gray-200 p-1 rounded">
                                        </div>
                                        <div class="grid grid-cols-12 gap-1">
                                            <input type="text" value="3" class="col-span-2 border border-gray-200 p-1 rounded                         text-center" readonly>
                                            <input type="text" id="an54-comp3-nom" value="" class="col-span-5 border border-gray-200 p-1                         rounded">
                                            <input type="text" id="an54-comp3-asig" value="" class="col-span-5 border border-gray-200 p-1                         rounded">
                                        </div>
                                        <div class="grid grid-cols-12 gap-1">
                                            <input type="text" value="4" class="col-span-2 border border-gray-200 p-1 rounded                         text-center" readonly>
                                            <input type="text" id="an54-comp4-nom" value="" class="col-span-5 border border-gray-200 p-1                         rounded">
                                            <input type="text" id="an54-comp4-asig" value="" class="col-span-5 border border-gray-200 p-1                         rounded">
                                        </div>
                                    </div>
                                </div>
                        
                                <div>
                                    <label for="an54-marco" class="block text-gray-600 font-semibold mb-1">(13) Marco Teórico o                         Antecedentes:</label>
                                    <textarea id="an54-marco" name="marco_teorico" rows="3" class="w-full border border-gray-200 p-2                         rounded-lg">El diseño de bases de datos relacionales y la arquitectura cliente-servidor permiten                         gestionar la trazabilidad de las operaciones en tiempo real dentro de la Unidad Económica.</textarea>
                                </div>
                        
                                <div>
                                    <label for="an54-descripcion" class="block text-gray-600 font-semibold mb-1">(14) Descripción de las                         Actividades Realizadas:</label>
                                    <textarea id="an54-descripcion" name="descripcion" rows="3" class="w-full border border-gray-200 p-2                         rounded-lg">Modelado de bases de datos para el módulo de despacho. Pruebas unitarias de las APIs y                         documentación técnica del proyecto.</textarea>
                                </div>
                        
                                <!-- 3.- EVALUACIÓN DE LA UE -->
                                <div class="border-t border-gray-100 pt-3 space-y-3">
                                    <p class="font-bold text-tecnm-blue uppercase">3.- Evaluación de la UE (Matriz por Competencia)</p>
                        
                                    <div>
                                        <label class="block text-gray-600 font-semibold mb-1">(15) Competencia Evaluada en la Matriz:</                        label>
                                        <input type="text" id="an54-eval-comp" value="1. Modelado de Bases de Datos" class="w-full border                         border-gray-200 p-2 rounded-lg">
                                    </div>
                        
                                    <div>
                                        <label class="block text-gray-600 font-semibold mb-1">(16) Encabezados de Nivel de Desempeño (5                         columnas):</label>
                                        <div class="grid grid-cols-5 gap-1">
                                            <input type="text" id="an54-nd-1" value="Insuficiente" class="border border-gray-200 p-1                         rounded text-center text-[10px]">
                                            <input type="text" id="an54-nd-2" value="Suficiente" class="border border-gray-200 p-1                         rounded text-center text-[10px]">
                                            <input type="text" id="an54-nd-3" value="Bueno" class="border border-gray-200 p-1 rounded                         text-center text-[10px]">
                                            <input type="text" id="an54-nd-4" value="Notable" class="border border-gray-200 p-1 rounded                         text-center text-[10px]">
                                            <input type="text" id="an54-nd-5" value="Excelente" class="border border-gray-200 p-1 rounded                         text-center text-[10px]">
                                        </div>
                                    </div>
                        
                                    <!-- Filas de la Matriz (17, 18, 19, Nivel y 20) -->
                                    <div class="space-y-2">
                                        <div class="grid grid-cols-12 gap-1 text-[10px] font-semibold text-gray-500">
                                            <span class="col-span-3">(17) Actividad</span>
                                            <span class="col-span-3">(18) Evidencia</span>
                                            <span class="col-span-2 text-center">(19) Horas</span>
                                            <span class="col-span-2 text-center">Nivel (1-5)</span>
                                            <span class="col-span-2">(20) Fecha Eval.</span>
                                        </div>
                        
                                        <!-- Fila 1 -->
                                        <div class="grid grid-cols-12 gap-1">
                                            <input type="text" id="an54-m1-act" value="Diseño entidad-relación" class="col-span-3 border                         border-gray-200 p-1 rounded">
                                            <input type="text" id="an54-m1-ev" value="Diagrama ER" class="col-span-3 border                         border-gray-200 p-1 rounded">
                                            <input type="number" id="an54-m1-hrs" value="20" name="horas" class="col-span-2 border                         border-gray-200 p-1 rounded text-center">
                                            <select id="an54-m1-niv" class="col-span-2 border border-gray-200 p-1 rounded text-center">
                                                <option value="1">Col 1</option>
                                                <option value="2">Col 2</option>
                                                <option value="3">Col 3</option>
                                                <option value="4">Col 4</option>
                                                <option value="5" selected>Col 5</option>
                                            </select>
                                            <input type="text" id="an54-m1-fec" value="25/09/2026" class="col-span-2 border                         border-gray-200 p-1 rounded">
                                        </div>
                        
                                        <!-- Fila 2 -->
                                        <div class="grid grid-cols-12 gap-1">
                                            <input type="text" id="an54-m2-act" value="Pruebas de API" class="col-span-3 border                         border-gray-200 p-1 rounded">
                                            <input type="text" id="an54-m2-ev" value="Reporte Postman" class="col-span-3 border                         border-gray-200 p-1 rounded">
                                            <input type="number" id="an54-m2-hrs" value="20" class="col-span-2 border border-gray-200 p-1                         rounded text-center">
                                            <select id="an54-m2-niv" class="col-span-2 border border-gray-200 p-1 rounded text-center">
                                                <option value="1">Col 1</option>
                                                <option value="2">Col 2</option>
                                                <option value="3">Col 3</option>
                                                <option value="4">Col 4</option>
                                                <option value="5" selected>Col 5</option>
                                            </select>
                                            <input type="text" id="an54-m2-fec" value="25/09/2026" class="col-span-2 border                         border-gray-200 p-1 rounded">
                                        </div>
                        
                                        <!-- Fila 3 -->
                                        <div class="grid grid-cols-12 gap-1">
                                            <input type="text" id="an54-m3-act" value="" class="col-span-3 border border-gray-200 p-1                         rounded">
                                            <input type="text" id="an54-m3-ev" value="" class="col-span-3 border border-gray-200 p-1                         rounded">
                                            <input type="number" id="an54-m3-hrs" value="" class="col-span-2 border border-gray-200 p-1                         rounded text-center">
                                            <select id="an54-m3-niv" class="col-span-2 border border-gray-200 p-1 rounded text-center">
                                                <option value="0">-</option>
                                                <option value="1">Col 1</option>
                                                <option value="2">Col 2</option>
                                                <option value="3">Col 3</option>
                                                <option value="4">Col 4</option>
                                                <option value="5">Col 5</option>
                                            </select>
                                            <input type="text" id="an54-m3-fec" value="" class="col-span-2 border border-gray-200 p-1                         rounded">
                                        </div>
                                    </div>
                        
                                    <!-- Campo oculto de observaciones para mantener compatibilidad con api/anexo54.php -->
                                    <input type="hidden" id="an54-observaciones" name="observaciones" value="Reporte generado conforme al                         formato oficial 2026.">
                                </div>
                        
                                <!-- Botón para guardar en Base de Datos / PHP -->
                                <div class="flex gap-4 pt-2">
                                    <button type="submit" class="bg-tecnm-blue hover:bg-tecnm-dark text-white font-bold px-4 py-2                         rounded-lg transition">
                                        <i class="fa-solid fa-floppy-disk mr-1"></i> Guardar Anexo 5.4 en BD y Generar PDF
                                    </button>
                                </div>
                        
                            </form>
                        
                        </div>

                        <!-- FORMULARIO ANEXO 5.5 (NUEVO FORMATO) -->
                        <div id="form-anexo-55-campos" class="hidden space-y-3 text-xs">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Nombre del Proyecto o Plan de Rotación:</label>
                                    <input type="text" id="an55-proyecto" value="Sistema de Control de Inventarios" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Unidad Económica:</label>
                                    <input type="text" id="an55-ue" value="Chrysler de México S.A de C.V" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Nombre del Mentor de la UE:</label>
                                    <input type="text" id="an55-mentor-ue" value="Ing. Guillermo Vázquez Tapia" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Nombre del Mentor Académico:</label>
                                    <input type="text" id="an55-mentor-acad" value="M. en C. Roberto Cruz Valdés" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Periodo Inicio:</label>
                                    <input type="date" id="an55-periodo-inicio" value="2026-01-15" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Periodo Término:</label>
                                    <input type="date" id="an55-periodo-termino" value="2026-06-15" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Semestre / Cuatrimestre:</label>
                                    <input type="text" id="an55-semestre" value="9no Semestre" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Horarios (incluir alimentos):</label>
                                    <input type="text" id="an55-horarios" value="Lunes a Viernes 9:00 - 14:00 hrs" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-gray-600 font-semibold mb-1">Apoyo (cuando aplique):</label>
                                    <input type="text" id="an55-apoyo" value="Beca Educación Dual" class="w-full border border-gray-200 p-2 rounded-lg">
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-600 font-semibold mb-1">DESCRIPCIÓN DEL PROYECTO (¿QUÉ?, ¿CÓMO?, ¿DÓNDE?, ¿CUÁNDO?, ¿PARA QUÉ?):</label>
                                <textarea id="an55-desc-proyecto" rows="4" class="w-full border border-gray-200 p-2 rounded-lg">Desarrollo de un sistema web para la gestión de inventarios en la planta de producción, utilizando tecnologías .NET y SQL Server, con el fin de optimizar los tiempos de respuesta y reducir errores en el control de stock.</textarea>
                            </div>

                            <!-- Competencias y Asignaturas -->
                            <div class="border-t border-gray-100 pt-3">
                                <p class="font-bold text-gray-700 mb-2">COMPETENCIAS A DESARROLLAR / ASIGNATURAS</p>
                                <div class="space-y-2">
                                    <div class="grid grid-cols-3 gap-1 text-[10px] font-semibold text-gray-500">
                                        <span>No.</span>
                                        <span>Competencia</span>
                                        <span>Asignatura</span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-1">
                                        <input type="text" value="1" class="border border-gray-200 p-1 rounded text-center" readonly>
                                        <input type="text" id="an55-comp1" value="Modelado de Bases de Datos" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-comp1-asig" value="Base de Datos" class="border border-gray-200 p-1 rounded">
                                    </div>
                                    <div class="grid grid-cols-3 gap-1">
                                        <input type="text" value="2" class="border border-gray-200 p-1 rounded text-center" readonly>
                                        <input type="text" id="an55-comp2" value="Programación Orientada a Objetos" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-comp2-asig" value="Programación Web" class="border border-gray-200 p-1 rounded">
                                    </div>
                                    <div class="grid grid-cols-3 gap-1">
                                        <input type="text" value="3" class="border border-gray-200 p-1 rounded text-center" readonly>
                                        <input type="text" id="an55-comp3" value="Trabajo en Equipo" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-comp3-asig" value="Ingeniería de Software" class="border border-gray-200 p-1 rounded">
                                    </div>
                                </div>
                            </div>

                            <!-- Matriz de Evaluación -->
                            <div class="border-t border-gray-100 pt-3">
                                <p class="font-bold text-gray-700 mb-2">MATRIZ DE EVALUACIÓN DE LAS COMPETENCIAS</p>
                                <div class="space-y-2">
                                    <div class="grid grid-cols-6 gap-1 text-[9px] font-semibold text-gray-500">
                                        <span>No. Comp.</span>
                                        <span>Periodo</span>
                                        <span>Actividades</span>
                                        <span>Lugar UE/IE</span>
                                        <span>Ponderación</span>
                                        <span>Nivel Desempeño</span>
                                    </div>
                                    <div class="grid grid-cols-6 gap-1">
                                        <input type="text" value="1" readonly class="border border-gray-200 p-1 rounded text-center">
                                        <input type="text" id="an55-eval1-periodo" value="1er Parcial" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-eval1-act" value="Diseño de base de datos" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-eval1-lugar" value="UE" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-eval1-pond" value="40%" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-eval1-nivel" value="Excelente" class="border border-gray-200 p-1 rounded">
                                    </div>
                                    <div class="grid grid-cols-6 gap-1">
                                        <input type="text" value="2" readonly class="border border-gray-200 p-1 rounded text-center">
                                        <input type="text" id="an55-eval2-periodo" value="2do Parcial" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-eval2-act" value="Desarrollo módulos C#" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-eval2-lugar" value="UE" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-eval2-pond" value="40%" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-eval2-nivel" value="Bueno" class="border border-gray-200 p-1 rounded">
                                    </div>
                                    <div class="grid grid-cols-6 gap-1">
                                        <input type="text" value="3" readonly class="border border-gray-200 p-1 rounded text-center">
                                        <input type="text" id="an55-eval3-periodo" value="Final" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-eval3-act" value="Entrega final del proyecto" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-eval3-lugar" value="IE" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-eval3-pond" value="20%" class="border border-gray-200 p-1 rounded">
                                        <input type="text" id="an55-eval3-nivel" value="Excelente" class="border border-gray-200 p-1 rounded">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button onclick="actualizarPrevisualizacionFormatos()" class="mt-4 w-full bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold py-2 rounded-lg text-xs transition">
                            Actualizar Vista Previa del Formato
                        </button>
                    </div>

                    <!-- Vista Previa -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-2">
                            <h4 class="font-bold text-gray-800">Vista Previa Impresión (Alineado a Manual)</h4>
                            <span class="text-xs text-amber-600 bg-amber-50 px-2 py-0.5 rounded font-bold">Borrador Dinámico</span>
                        </div>
                        <div id="vista-previa-papel" class="paper-preview">
                            <!-- Inyectado dinámicamente -->
                        </div>
                    </div>
                </div>

                <!-- Gestor de Carga -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2"><i class="fa-solid fa-cloud-arrow-up text-tecnm-blue"></i> Cargar Anexos Firmados Digitalizados</h3>
                    <p class="text-xs text-gray-500 mb-4">Una vez impreso y firmado el documento, súbalo de regreso para constancia en el expediente electrónico del estudiante.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border-2 border-dashed border-gray-200 hover:border-tecnm-blue transition rounded-xl p-6 text-center cursor-pointer relative" onclick="document.getElementById('input-anexo-subir').click()">
                            <input type="file" id="input-anexo-subir" class="hidden" onchange="procesarCargaAnexoFirmado(event)">
                            <i class="fa-solid fa-file-pdf text-4xl text-red-500 mb-2"></i>
                            <p class="text-xs font-bold text-gray-700">Arrastre o seleccione el archivo PDF firmado</p>
                            <p class="text-[10px] text-gray-400 mt-1">Formatos permitidos: PDF, JPG, PNG (Max 5MB)</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex flex-col justify-between">
                            <div>
                                <h5 class="text-xs font-bold text-gray-700 mb-2">Historial de Expediente Subido</h5>
                                <div id="historial-firmas-estudiante" class="space-y-2 max-h-[120px] overflow-y-auto text-xs">
                                    <p class="text-gray-400 italic">No hay archivos firmados subidos para el estudiante seleccionado.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- MODALES -->
    <!-- Modal Estudiante -->
    <div id="modal-estudiante" class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-xl shadow-xl border border-gray-100 w-full max-w-lg overflow-hidden transform transition-all">
            <div class="bg-tecnm-blue text-white p-4 flex justify-between items-center">
                <h3 class="font-bold flex items-center gap-2"><i class="fa-solid fa-user-graduate"></i> Registrar Estudiante Dual</h3>
                <button onclick="closeModal('estudiante')" class="text-white hover:text-gray-200"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form id="form-estudiante-data" onsubmit="guardarEstudiante(event)" class="p-5 space-y-4 text-xs">
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
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Género:</label>
                        <select id="est-genero" required class="w-full border border-gray-200 p-2 rounded-lg">
                            <option value="H">Hombre</option>
                            <option value="M">Mujer</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Carrera / Programa:</label>
                        <select id="est-carrera" required class="w-full border border-gray-200 p-2 rounded-lg">
                            <option value="Ingeniería en Sistemas Computacionales">Ingeniería en Sistemas Computacionales</option>
                            <option value="Ingeniería Industrial">Ingeniería Industrial</option>
                            <option value="Ingeniería Mecatrónica">Ingeniería Mecatrónica</option>
                            <option value="Licenciatura en Administración">Licenciatura en Administración</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Tipo de Ingreso:</label>
                        <select id="est-tipo-ingreso" required class="w-full border border-gray-200 p-2 rounded-lg">
                            <option value="Ingreso">Ingreso (Primer ingreso en Dual)</option>
                            <option value="Reingreso">Reingreso</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Unidad Económica (Empresa):</label>
                        <select id="est-empresa" required class="w-full border border-gray-200 p-2 rounded-lg"></select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Mentor Académico:</label>
                        <select id="est-mentor-acad" required class="w-full border border-gray-200 p-2 rounded-lg"></select>
                    </div>
                    <div>
                        <label class="block text-gray-600 font-semibold mb-1">Mentor de la Empresa (UE):</label>
                        <select id="est-mentor-ue" required class="w-full border border-gray-200 p-2 rounded-lg"></select>
                    </div>
                </div>
                <button type="submit" class="w-full bg-tecnm-blue hover:bg-tecnm-dark text-white font-bold py-2.5 rounded-lg shadow transition">
                    Guardar Estudiante Dual
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Empresa -->
    <div id="modal-empresa" class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-xl shadow-xl border border-gray-100 w-full max-w-md overflow-hidden transform transition-all">
            <div class="bg-tecnm-blue text-white p-4 flex justify-between items-center">
                <h3 class="font-bold flex items-center gap-2"><i class="fa-solid fa-building"></i> Registrar Empresa</h3>
                <button onclick="closeModal('empresa')" class="text-white hover:text-gray-200"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form id="form-empresa-data" onsubmit="guardarEmpresa(event)" class="p-5 space-y-4 text-xs">
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

    <!-- Modal Mentor Académico -->
    <div id="modal-mentor-acad" class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-xl shadow-xl border border-gray-100 w-full max-w-md overflow-hidden transform transition-all">
            <div class="bg-tecnm-blue text-white p-4 flex justify-between items-center">
                <h3 class="font-bold flex items-center gap-2"><i class="fa-solid fa-chalkboard-user"></i> Registrar Mentor Académico</h3>
                <button onclick="closeModal('mentor-acad')" class="text-white hover:text-gray-200"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form id="form-mentor-acad-data" onsubmit="guardarMentorAcad(event)" class="p-5 space-y-4 text-xs">
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

    <!-- Modal Mentor Empresa -->
    <div id="modal-mentor-ue" class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-xl shadow-xl border border-gray-100 w-full max-w-md overflow-hidden transform transition-all">
            <div class="bg-tecnm-blue text-white p-4 flex justify-between items-center">
                <h3 class="font-bold flex items-center gap-2"><i class="fa-solid fa-user-tie"></i> Registrar Mentor Empresa</h3>
                <button onclick="closeModal('mentor-ue')" class="text-white hover:text-gray-200"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form id="form-mentor-ue-data" onsubmit="guardarMentorUE(event)" class="p-5 space-y-4 text-xs">
                <div>
                    <label class="block text-gray-600 font-semibold mb-1">Nombre Completo del Mentor:</label>
                    <input type="text" id="m-ue-nombre" required class="w-full border border-gray-200 p-2 rounded-lg" placeholder="Nombre completo">
                </div>
                <div>
                    <label class="block text-gray-600 font-semibold mb-1">Unidad Económica (Empresa):</label>
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

    <!-- PIE DE PÁGINA -->
    <footer class="bg-slate-900 text-gray-400 py-6 border-t border-slate-800 text-xs mt-auto">
        <div class="container mx-auto px-4 text-center space-y-2">
            <p class="font-semibold text-gray-300">Gobierno del Estado de México • Secretaría de Educación • Tecnológico Nacional de México</p>
            <p>Dirección General de Educación Superior • Sistema de Educación Dual Tecnológico (SAGEED)</p>
            <p class="text-[10px] text-gray-500">© 2026 SAGEED TecNM. Basado en el Manual de Operaciones de Educación Dual Vigente para Educación Media Superior y Superior del Estado de México.</p>
        </div>
    </footer>

    <!-- JavaScript modular del sistema -->
    <script src="assets/js/app.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/estudiantes.js"></script>
    <script src="assets/js/empresas.js"></script>
    <script src="assets/js/mentores.js"></script>
    <script src="assets/js/competencias.js"></script>
    <script src="assets/js/formatos.js"></script>
</body>
</html>