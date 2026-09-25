// ====== MENTORES (Académicos y de UE) ======

async function renderMentores() {
    if (!DB.mentoresAcad.length || !DB.mentoresUe.length) await cargarDatosGlobales();

    // Mentores Académicos
    document.getElementById('count-mentores-acad').innerText = DB.mentoresAcad.length;
    document.getElementById('lista-mentores-academicos').innerHTML = DB.mentoresAcad.map(m => `
        <div class="p-3.5 hover:bg-slate-50 transition flex items-start gap-3">
            <div class="bg-sky-50 text-sky-600 p-2 rounded-lg"><i class="fa-solid fa-user-gear"></i></div>
            <div class="text-xs">
                <p class="font-bold text-gray-800">${m.nombre}</p>
                <p class="text-gray-500 font-semibold mt-0.5">Depto: ${m.area}</p>
                <p class="text-[10px] text-gray-400">Correo: ${m.correo} | Tel: ${m.telefono || 'N/A'}</p>
            </div>
        </div>
    `).join('');

    // Mentores de UE
    document.getElementById('count-mentores-ue').innerText = DB.mentoresUe.length;
    document.getElementById('lista-mentores-ue').innerHTML = DB.mentoresUe.map(m => {
        const empNombre = m.empresa_nombre || 'Sin Empresa';
        return `
            <div class="p-3.5 hover:bg-slate-50 transition flex items-start gap-3">
                <div class="bg-amber-50 text-amber-600 p-2 rounded-lg"><i class="fa-solid fa-user-tie"></i></div>
                <div class="text-xs">
                    <p class="font-bold text-gray-800">${m.nombre}</p>
                    <p class="text-gray-500 font-semibold mt-0.5">Empresa: ${empNombre}</p>
                    <p class="text-[10px] text-gray-400">Puesto: ${m.cargo} | Correo: ${m.correo}</p>
                </div>
            </div>
        `;
    }).join('');
}

async function guardarMentorAcad(e) {
    e.preventDefault();
    const nuevo = {
        nombre: document.getElementById('m-acad-nombre').value,
        area: document.getElementById('m-acad-area').value,
        tel: document.getElementById('m-acad-tel').value,
        correo: document.getElementById('m-acad-correo').value
    };

    const res = await fetch(API_BASE + 'mentores.php?tipo=academicos', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(nuevo)
    });

    if (res.ok) {
        showToast('Mentor Académico registrado.');
        closeModal('mentor-acad');
        document.getElementById('form-mentor-acad-data').reset();
        await renderMentores();
    } else {
        showToast('Error al registrar mentor', 'error');
    }
}

async function guardarMentorUE(e) {
    e.preventDefault();
    const nuevo = {
        nombre: document.getElementById('m-ue-nombre').value,
        empresaId: document.getElementById('m-ue-empresa').value,
        cargo: document.getElementById('m-ue-cargo').value,
        correo: document.getElementById('m-ue-correo').value
    };

    const res = await fetch(API_BASE + 'mentores.php?tipo=ue', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(nuevo)
    });

    if (res.ok) {
        showToast('Mentor de Unidad Económica registrado.');
        closeModal('mentor-ue');
        document.getElementById('form-mentor-ue-data').reset();
        await renderMentores();
    } else {
        showToast('Error al registrar mentor', 'error');
    }
}