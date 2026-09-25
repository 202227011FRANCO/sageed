// ====== EMPRESAS (Unidades Económicas) ======

async function renderEmpresas() {
    if (!DB.empresas.length) await cargarDatosGlobales();
    const contenedor = document.getElementById('directorio-empresas');
    contenedor.innerHTML = DB.empresas.map(emp => {
        const estudiantesAsignados = DB.estudiantes.filter(est => est.empresa_id == emp.id && est.estatus === 'ACTIVO');
        return `
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="bg-slate-100 text-slate-800 text-[10px] font-extrabold uppercase px-2.5 py-1 rounded">RFC: ${emp.rfc}</span>
                        <i class="fa-solid fa-briefcase text-tecnm-gold text-lg"></i>
                    </div>
                    <h3 class="font-extrabold text-base text-gray-800 leading-snug">${emp.nombre}</h3>
                    <p class="text-xs text-gray-500 mt-1"><span class="font-semibold text-gray-600">Giro:</span> ${emp.giro}</p>
                    <p class="text-xs text-gray-500"><span class="font-semibold text-gray-600">Representante:</span> ${emp.contacto}</p>
                </div>
                <div class="border-t border-gray-100 pt-3 mt-4 flex items-center justify-between">
                    <span class="text-[10px] text-gray-400">Convenio Marco Activo</span>
                    <span class="bg-tecnm-blue/10 text-tecnm-blue text-[10px] font-bold px-2 py-0.5 rounded">
                        ${estudiantesAsignados.length} Estudiantes Duales
                    </span>
                </div>
            </div>
        `;
    }).join('');
}

async function cargarSelectoresEmpresa() {
    await cargarDatosGlobales();
    const select = document.getElementById('m-ue-empresa');
    if (select) {
        select.innerHTML = DB.empresas.map(e => `<option value="${e.id}">${e.nombre}</option>`).join('');
    }
}

async function guardarEmpresa(e) {
    e.preventDefault();
    const nueva = {
        nombre: document.getElementById('emp-nombre').value,
        giro: document.getElementById('emp-giro').value,
        rfc: document.getElementById('emp-rfc').value,
        contacto: document.getElementById('emp-contacto').value
    };

    const res = await fetch(API_BASE + 'empresas.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(nueva)
    });

    if (res.ok) {
        showToast(`Empresa "${nueva.nombre}" guardada con éxito.`);
        closeModal('empresa');
        document.getElementById('form-empresa-data').reset();
        await renderEmpresas();
    } else {
        showToast('Error al guardar empresa', 'error');
    }
}