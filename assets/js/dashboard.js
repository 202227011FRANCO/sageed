async function cargarDatosGlobales() {
    try {
        const [est, emp, mAcad, mUe, comp] = await Promise.all([
            fetch(API_BASE + 'estudiantes.php').then(r => r.json()),
            fetch(API_BASE + 'empresas.php').then(r => r.json()),
            fetch(API_BASE + 'mentores.php?tipo=academicos').then(r => r.json()),
            fetch(API_BASE + 'mentores.php?tipo=ue').then(r => r.json()),
            fetch(API_BASE + 'competencias.php').then(r => r.json())
        ]);
        DB.estudiantes = est;
        DB.empresas = emp;
        DB.mentoresAcad = mAcad;
        DB.mentoresUe = mUe;
        DB.competencias = comp;
    } catch (e) {
        console.error('Error cargando datos:', e);
        showToast('Error al cargar datos del servidor', 'error');
    }
}

async function renderDashboard() {
    await cargarDatosGlobales();

    const activos = DB.estudiantes.filter(e => e.estatus === 'ACTIVO');
    const egresados = DB.estudiantes.filter(e => e.estatus === 'EGRESADO');
    const totalHombres = activos.filter(e => e.genero === 'H').length;
    const totalMujeres = activos.filter(e => e.genero === 'M').length;
    const totalActivosCount = activos.length;
    const nuevosIngresos = activos.filter(e => e.tipo_ingreso === 'Ingreso');
    const reingresos = activos.filter(e => e.tipo_ingreso === 'Reingreso');

    document.getElementById('dash-total-estudiantes').innerText = totalActivosCount;
    document.getElementById('dash-total-egresados').innerText = egresados.length;
    document.getElementById('dash-total-empresas').innerText = DB.empresas.length;
    document.getElementById('dash-ingresos-badge').innerText = `${nuevosIngresos.length} Nuevo Ingreso`;
    document.getElementById('dash-reingresos-badge').innerText = `${reingresos.length} Reingreso`;

    const hombresPct = totalActivosCount > 0 ? Math.round((totalHombres / totalActivosCount) * 100) : 0;
    const mujeresPct = totalActivosCount > 0 ? Math.round((totalMujeres / totalActivosCount) * 100) : 0;

    document.getElementById('dash-hombres-pct').innerText = `${hombresPct}%`;
    document.getElementById('dash-mujeres-pct').innerText = `${mujeresPct}%`;

    document.getElementById('donut-total-count').innerText = totalActivosCount;
    const segmentH = document.getElementById('donut-segment-hombres');
    const segmentM = document.getElementById('donut-segment-mujeres');
    if (segmentH && segmentM) {
        segmentH.setAttribute('stroke-dasharray', `${hombresPct} ${100 - hombresPct}`);
        segmentM.setAttribute('stroke-dasharray', `${mujeresPct} ${100 - mujeresPct}`);
        segmentM.setAttribute('stroke-dashoffset', `${100 - hombresPct}`);
    }

    document.getElementById('dash-nuevo-ingreso-count').innerText = nuevosIngresos.length;
    document.getElementById('dash-reingreso-count').innerText = reingresos.length;

    const listaEmp = document.getElementById('dash-lista-empresas');
    document.getElementById('dash-empresas-badge').innerText = `${DB.empresas.length} Empresas`;
    listaEmp.innerHTML = DB.empresas.map(emp => {
        const estAsignados = activos.filter(e => e.empresa_id == emp.id);
        return `
            <div class="flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition duration-150 border-l-4 border-tecnm-blue">
                <div>
                    <p class="font-bold text-xs text-gray-800">${emp.nombre}</p>
                    <p class="text-[10px] text-gray-500">${emp.giro} • RFC: ${emp.rfc}</p>
                </div>
                <span class="bg-tecnm-blue text-white text-[10px] px-2 py-1 rounded font-bold">
                    ${estAsignados.length} Estudiantes
                </span>
            </div>
        `;
    }).join('');

    document.getElementById('dash-lista-ingresos').innerHTML = nuevosIngresos.length ? nuevosIngresos.map(e => `
        <div class="bg-white p-2 rounded border border-emerald-100 shadow-xs text-xs flex justify-between items-center">
            <div>
                <p class="font-semibold text-gray-800">${e.nombre}</p>
                <p class="text-[9px] text-gray-400">${e.control} • ${e.carrera}</p>
            </div>
            <span class="text-[10px] bg-emerald-100 text-emerald-800 px-1.5 py-0.5 rounded font-semibold">Nuevo</span>
        </div>
    `).join('') : '<p class="text-xs text-gray-400 italic">No hay nuevos ingresos registrados</p>';

    document.getElementById('dash-lista-reingresos').innerHTML = reingresos.length ? reingresos.map(e => `
        <div class="bg-white p-2 rounded border border-blue-100 shadow-xs text-xs flex justify-between items-center">
            <div>
                <p class="font-semibold text-gray-800">${e.nombre}</p>
                <p class="text-[9px] text-gray-400">${e.control} • ${e.carrera}</p>
            </div>
            <span class="text-[10px] bg-blue-100 text-blue-800 px-1.5 py-0.5 rounded font-semibold">Reingreso</span>
        </div>
    `).join('') : '<p class="text-xs text-gray-400 italic">No hay reingresos activos</p>';
}