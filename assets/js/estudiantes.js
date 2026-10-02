// Variable global para guardar los estudiantes
let todosLosEstudiantes = [];

// 1. Obtener datos de la API
async function renderEstudiantes() {
    console.log("1. Intentando cargar estudiantes...");
    const tbody = document.getElementById('tabla-estudiantes-body');
    
    try {
        const response = await fetch('api/estudiantes.php');
        console.log("2. Respuesta recibida del servidor:", response);
        
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
        
        todosLosEstudiantes = await response.json();
        console.log("3. Datos convertidos a JSON:", todosLosEstudiantes);
        
        pintarTablaEstudiantes(todosLosEstudiantes);
    } catch (error) {
        console.error("Error al cargar estudiantes:", error);
        if (tbody) {
            tbody.innerHTML = `<tr><td colspan="6" class="px-6 py-8 text-center text-red-500 font-bold"><i class="fa-solid fa-triangle-exclamation"></i> Error cargando datos: Revisa la consola (F12)</td></tr>`;
        }
    }
}

// 2. Dibujar las filas en el HTML
function pintarTablaEstudiantes(estudiantes) {
    const tbody = document.getElementById('tabla-estudiantes-body');
    tbody.innerHTML = ''; // Limpiar tabla

    if (!Array.isArray(estudiantes) || estudiantes.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">No hay estudiantes registrados.</td></tr>';
        return;
    }

    estudiantes.forEach(est => {
        const bgEstatus = est.estatus === 'ACTIVO' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-800';
        const iconoGenero = est.genero === 'H' 
            ? '<i class="fa-solid fa-mars text-sky-500 w-4"></i>' 
            : '<i class="fa-solid fa-venus text-pink-500 w-4"></i>';

        const tr = document.createElement('tr');
        tr.className = "hover:bg-gray-50 transition-colors";
        tr.innerHTML = `
            <td class="px-6 py-4">
                <div class="font-bold text-gray-800">${est.nombre}</div>
                <div class="text-[11px] text-gray-500 mt-0.5">Ctrl: <span class="font-semibold">${est.control}</span> | CURP: ${est.curp || 'S/N'}</div>
            </td>
            <td class="px-6 py-4 text-xs">
                <div class="font-medium text-gray-700 flex items-center gap-1.5">${iconoGenero} ${est.carrera}</div>
            </td>
            <td class="px-6 py-4 text-xs text-gray-700">
                <i class="fa-solid fa-building text-tecnm-gold mr-1.5"></i> ${est.empresa_nombre || '<span class="text-red-400">Sin asignar</span>'}
            </td>
            <td class="px-6 py-4 text-xs">
                <span class="bg-blue-50 text-tecnm-blue px-2.5 py-1 rounded-md font-semibold border border-blue-100">${est.tipo_ingreso}</span>
            </td>
            <td class="px-6 py-4 text-xs">
                <span class="px-2.5 py-1 rounded-full font-bold ${bgEstatus}">${est.estatus}</span>
            </td>
            <td class="px-6 py-4 text-right text-xs">
                <button class="text-tecnm-blue hover:text-tecnm-dark mr-3 transition" title="Editar Expediente"><i class="fa-solid fa-pen-to-square text-base"></i></button>
                <button class="text-red-500 hover:text-red-700 transition" title="Dar de Baja"><i class="fa-solid fa-trash-can text-base"></i></button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// 3. Sistema de Búsqueda y Filtros
function filtrarEstudiantes() {
    const textoBuscado = document.getElementById('buscar-estudiante').value.toLowerCase();
    const estatusFiltro = document.getElementById('filtro-estatus').value;

    const filtrados = todosLosEstudiantes.filter(est => {
        const coincideTexto = est.nombre.toLowerCase().includes(textoBuscado) || est.control.toLowerCase().includes(textoBuscado);
        const coincideEstatus = estatusFiltro === 'TODOS' || est.estatus === estatusFiltro;
        return coincideTexto && coincideEstatus;
    });

    pintarTablaEstudiantes(filtrados);
}

// 4. Guardar un Estudiante Nuevo
async function guardarEstudiante(e) {
    e.preventDefault();
    
    const datos = {
        nombre: document.getElementById('est-nombre').value,
        control: document.getElementById('est-control').value,
        curp: document.getElementById('est-curp').value.toUpperCase(),
        genero: document.getElementById('est-genero').value,
        carrera: document.getElementById('est-carrera').value,
        tipo_ingreso: document.getElementById('est-tipo-ingreso').value,
        empresa_id: document.getElementById('est-empresa').value,
        mentor_acad_id: document.getElementById('est-mentor-acad').value,
        mentor_ue_id: document.getElementById('est-mentor-ue').value
    };

    try {
        const res = await fetch('api/estudiantes.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datos)
        });

        if (res.ok) {
            closeModal('estudiante');
            document.getElementById('form-estudiante-data').reset();
            await renderEstudiantes();
        }
    } catch (error) {
        console.error("Error al guardar:", error);
    }
}