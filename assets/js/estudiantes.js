//  ESTUDIANTES 

async function renderEstudiantes() {
    if (!DB.estudiantes.length) await cargarDatosGlobales();
    filtrarEstudiantes(); // Reutilizamos la función de filtrado para renderizar
}

function filtrarEstudiantes() {
    const busqueda = document.getElementById('buscar-estudiante').value.toLowerCase();
    const filtroEstatus = document.getElementById('filtro-estatus').value;
    const tbody = document.getElementById('tabla-estudiantes-body');

    const filtrados = DB.estudiantes.filter(est => {
        const coincideTexto = est.nombre.toLowerCase().includes(busqueda) || est.control.toLowerCase().includes(busqueda);
        const coincideEstatus = filtroEstatus === 'TODOS' || est.estatus === filtroEstatus;
        return coincideTexto && coincideEstatus;
    });

    tbody.innerHTML = filtrados.map(est => {
        const empresa = DB.empresas.find(e => e.id == est.empresa_id);
        const nombreEmpresa = empresa ? empresa.nombre : '<span class="text-gray-400 italic">Sin asignar</span>';
        
        return `
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="font-bold text-gray-800">${est.nombre}</div>
                    <div class="text-[10px] text-gray-500 mt-0.5">Control: ${est.control}</div>
                    <div class="text-[10px] text-gray-500">CURP: ${est.curp || 'N/A'}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-xs text-gray-700">${est.carrera}</div>
                    <div class="text-[10px] text-gray-500 mt-0.5"><i class="fa-solid ${est.genero === 'H' ? 'fa-mars text-sky-500' : 'fa-venus text-pink-500'}"></i> ${est.genero === 'H' ? 'Hombre' : 'Mujer'}</div>
                </td>
                <td class="px-6 py-4 text-xs font-semibold text-gray-700">${nombreEmpresa}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-[10px] rounded font-bold ${est.tipo_ingreso === 'Ingreso' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800'}">
                        ${est.tipo_ingreso}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <i class="fa-solid fa-file-pdf text-gray-300 text-lg" title="Sin convenio subido"></i>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-[10px] rounded font-bold ${est.estatus === 'ACTIVO' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                        ${est.estatus}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <button class="text-blue-600 hover:text-blue-800 text-xs font-semibold px-2 py-1 rounded hover:bg-blue-50 transition"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
                </td>
            </tr>
        `;
    }).join('');
}

async function cargarSelectoresEstudiante() {
    await cargarDatosGlobales();
    
    const selectEmpresa = document.getElementById('est-empresa');
    if (selectEmpresa) {
        selectEmpresa.innerHTML = DB.empresas.map(e => `<option value="${e.id}">${e.nombre}</option>`).join('');
    }
    
    const selectMentorAcad = document.getElementById('est-mentor-acad');
    if (selectMentorAcad) {
        selectMentorAcad.innerHTML = DB.mentoresAcad.map(m => `<option value="${m.id}">${m.nombre} (${m.area})</option>`).join('');
    }

    const selectMentorUe = document.getElementById('est-mentor-ue');
    if (selectMentorUe) {
        selectMentorUe.innerHTML = DB.mentoresUe.map(m => `<option value="${m.id}">${m.nombre} - ${m.cargo}</option>`).join('');
    }
}

async function guardarEstudiante(e) {
    e.preventDefault();
    
    // El objeto 'nuevo' debe tener los mismos nombres de clave que espera api/estudiantes.php
    const nuevo = {
        control: document.getElementById('est-control').value,
        curp: document.getElementById('est-curp').value.toUpperCase(), // Captura y convierte a mayúsculas
        nombre: document.getElementById('est-nombre').value,
        genero: document.getElementById('est-genero').value,
        carrera: document.getElementById('est-carrera').value,
        empresaId: document.getElementById('est-empresa').value,
        mentorAcadId: document.getElementById('est-mentor-acad').value,
        mentorUeId: document.getElementById('est-mentor-ue').value,
        tipoIngreso: document.getElementById('est-tipo-ingreso').value
    };

    const res = await fetch(API_BASE + 'estudiantes.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(nuevo)
    });

    if (res.ok) {
        showToast('Estudiante registrado con éxito.');
        closeModal('estudiante');
        document.getElementById('form-estudiante-data').reset();
        
        // Refrescar los datos globales y la tabla si la función existe
        await cargarDatosGlobales();
        if (typeof renderEstudiantes === 'function') {
            renderEstudiantes();
        }
    } else {
        showToast('Error al registrar estudiante', 'error');
    }
}