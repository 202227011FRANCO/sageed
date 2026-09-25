// ====== COMPETENCIAS (Anexo 1.1) ======

async function renderCompetencias() {
    if (!DB.competencias.length) await cargarDatosGlobales();
    document.getElementById('count-competencias').innerText = DB.competencias.length;
    document.getElementById('lista-competencias-container').innerHTML = DB.competencias.map(comp => `
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-xs flex flex-col justify-between hover:border-tecnm-blue transition border-l-4 border-l-tecnm-gold">
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="bg-tecnm-blue text-white text-[9px] font-black uppercase px-2 py-0.5 rounded tracking-wider">${comp.codigo}</span>
                    <span class="text-[10px] font-bold text-gray-500">${comp.carrera}</span>
                </div>
                <p class="text-xs text-gray-700 leading-relaxed font-medium mt-2">${comp.descripcion}</p>
            </div>
        </div>
    `).join('');
}

async function guardarCompetencia(e) {
    e.preventDefault();
    const nueva = {
        carrera: document.getElementById('comp-carrera').value,
        codigo: document.getElementById('comp-codigo').value,
        descripcion: document.getElementById('comp-descripcion').value
    };

    const res = await fetch(API_BASE + 'competencias.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(nueva)
    });

    if (res.ok) {
        showToast('Competencia guardada en Catálogo Anexo 1.1.');
        document.getElementById('form-competencia').reset();
        DB.competencias = []; // Forzar recarga
        await renderCompetencias();
    } else {
        showToast('Error al guardar competencia', 'error');
    }
}