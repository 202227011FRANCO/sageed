// ====== FORMATOS Y ANEXOS (5.1, 5.4, 5.5) ======

async function llenarSelectoresFormatos() {
    if (!DB.estudiantes.length) await cargarDatosGlobales();
    document.getElementById('selector-formato-estudiante').innerHTML = DB.estudiantes.map(e => `
        <option value="${e.id}">${e.nombre} (${e.control})</option>
    `).join('');
}

function mostrarCamposFormatoEspecifico() {
    const tipo = document.getElementById('selector-tipo-anexo').value;
    const titulo = document.getElementById('formato-anexo-titulo');

    document.getElementById('form-anexo-51-campos').classList.add('hidden');
    document.getElementById('form-anexo-54-campos').classList.add('hidden');
    document.getElementById('form-anexo-55-campos').classList.add('hidden');

    if (tipo === "5.1") {
        titulo.innerText = "Datos de Llenado - Plan de Formación";
        document.getElementById('form-anexo-51-campos').classList.remove('hidden');
    } else if (tipo === "5.4") {
        titulo.innerText = "Datos de Llenado - Reporte de Actividades";
        document.getElementById('form-anexo-54-campos').classList.remove('hidden');
    } else if (tipo === "5.5") {
        titulo.innerText = "Datos de Llenado - Seguimiento y Evaluación";
        document.getElementById('form-anexo-55-campos').classList.remove('hidden');
    }

    actualizarPrevisualizacionFormatos();
}

function actualizarPrevisualizacionFormatos() {
    const estId = document.getElementById('selector-formato-estudiante').value;
    const tipoAnexo = document.getElementById('selector-tipo-anexo').value;
    const previewPapel = document.getElementById('vista-previa-papel');

    if (!estId) {
        previewPapel.innerHTML = '<p class="text-center text-gray-400 italic">No hay estudiantes cargados.</p>';
        return;
    }

    const est = DB.estudiantes.find(e => e.id == estId);
    const emp = DB.empresas.find(e => e.id == est.empresa_id);
    const mentAcad = DB.mentoresAcad.find(m => m.id == est.mentor_acad_id);
    const mentUe = DB.mentoresUe.find(m => m.id == est.mentor_ue_id);

    if (tipoAnexo === "5.1") {
        const proyecto = document.getElementById('an51-proyecto').value;
        const ue = document.getElementById('an51-ue').value;
        const ie = document.getElementById('an51-ie').value;
        const programa = document.getElementById('an51-programa').value;
        const numEst = document.getElementById('an51-num-est').value;
        const numMentUe = document.getElementById('an51-num-ment-ue').value;
        const numMentAcad = document.getElementById('an51-num-ment-acad').value;
        const duracion = document.getElementById('an51-duracion').value;
        const descProyecto = document.getElementById('an51-desc-proyecto').value;
        const horasSemana = document.getElementById('an51-horas-semana').value;

        const comp1 = document.getElementById('comp1-nombre').value;
        const comp1Asig = document.getElementById('comp1-asig').value;
        const comp2 = document.getElementById('comp2-nombre').value;
        const comp2Asig = document.getElementById('comp2-asig').value;
        const comp3 = document.getElementById('comp3-nombre').value;
        const comp3Asig = document.getElementById('comp3-asig').value;
        const comp4 = document.getElementById('comp4-nombre').value;
        const comp4Asig = document.getElementById('comp4-asig').value;

        const act1Desc = document.getElementById('act1-desc').value;
        const act1Horas = document.getElementById('act1-horas').value;
        const act1Ev = document.getElementById('act1-ev').value;
        const act1Lugar = document.getElementById('act1-lugar').value;
        const act1Pond = document.getElementById('act1-pond').value;

        const act2Desc = document.getElementById('act2-desc').value;
        const act2Horas = document.getElementById('act2-horas').value;
        const act2Ev = document.getElementById('act2-ev').value;
        const act2Lugar = document.getElementById('act2-lugar').value;
        const act2Pond = document.getElementById('act2-pond').value;

        const act3Desc = document.getElementById('act3-desc').value;
        const act3Horas = document.getElementById('act3-horas').value;
        const act3Ev = document.getElementById('act3-ev').value;
        const act3Lugar = document.getElementById('act3-lugar').value;
        const act3Pond = document.getElementById('act3-pond').value;

        const act4Desc = document.getElementById('act4-desc').value;
        const act4Horas = document.getElementById('act4-horas').value;
        const act4Ev = document.getElementById('act4-ev').value;
        const act4Lugar = document.getElementById('act4-lugar').value;
        const act4Pond = document.getElementById('act4-pond').value;

        previewPapel.innerHTML = `
            <!-- ===== PÁGINA 1 ===== -->
            <div class="doc-header">"2026. Año del Humanismo Mexicano en el Estado de México".</div>
            <div class="doc-title">ANEXO 5.1</div>
            <div class="doc-subtitle">PLAN DE FORMACIÓN</div>

            <div class="field-line"><strong>Nombre del Proyecto o Plan de Rotación:</strong> ${proyecto}</div>
            <div class="field-line"><strong>Unidad Económica:</strong> ${ue}</div>
            <div class="field-line"><strong>Institución Educativa:</strong> ${ie}</div>
            <div class="field-line"><strong>Programa Educativo:</strong> ${programa}</div>
            <div class="field-line"><strong>Número de Estudiantes Dual:</strong> ${numEst} &nbsp;&nbsp; <strong>Número de Mentores de la UE:</strong> ${numMentUe} &nbsp;&nbsp; <strong>Número de Mentores Académicos:</strong> ${numMentAcad}</div>
            <div class="field-line"><strong>Duración del Plan de Formación en Periodos:</strong> ${duracion}</div>

            <div class="section-label">DESCRIPCIÓN DEL PROYECTO (¿QUÉ?, ¿CÓMO?, ¿DÓNDE?, ¿CUÁNDO?, ¿PARA QUÉ?):</div>
            <div class="desc-box">${descProyecto}</div>

            <table>
                <thead>
                    <tr>
                        <th style="width:8%">No.</th>
                        <th>COMPETENCIAS A DESARROLLAR</th>
                        <th>ASIGNATURAS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td style="text-align:center">1</td><td>${comp1}</td><td>${comp1Asig}</td></tr>
                    <tr><td style="text-align:center">2</td><td>${comp2}</td><td>${comp2Asig}</td></tr>
                    <tr><td style="text-align:center">3</td><td>${comp3}</td><td>${comp3Asig}</td></tr>
                    <tr><td style="text-align:center">4</td><td>${comp4}</td><td>${comp4Asig}</td></tr>
                </tbody>
            </table>

            <div class="section-label">ACTIVIDADES A REALIZAR PARA DESARROLLAR LAS COMPETENCIAS</div>
            <table>
                <thead>
                    <tr>
                        <th style="width:8%">No. Competencia</th>
                        <th>Actividades</th>
                        <th style="width:10%">Horas de dedicación</th>
                        <th>Evidencias o productos</th>
                        <th style="width:10%">Lugar UE/IE</th>
                        <th style="width:10%">Escala de Ponderación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td style="text-align:center">1</td><td>${act1Desc}</td><td style="text-align:center">${act1Horas}</td><td>${act1Ev}</td><td style="text-align:center">${act1Lugar}</td><td style="text-align:center">${act1Pond}</td></tr>
                    <tr><td style="text-align:center">2</td><td>${act2Desc}</td><td style="text-align:center">${act2Horas}</td><td>${act2Ev}</td><td style="text-align:center">${act2Lugar}</td><td style="text-align:center">${act2Pond}</td></tr>
                    <tr><td style="text-align:center">3</td><td>${act3Desc}</td><td style="text-align:center">${act3Horas}</td><td>${act3Ev}</td><td style="text-align:center">${act3Lugar}</td><td style="text-align:center">${act3Pond}</td></tr>
                    <tr><td style="text-align:center">4</td><td>${act4Desc}</td><td style="text-align:center">${act4Horas}</td><td>${act4Ev}</td><td style="text-align:center">${act4Lugar}</td><td style="text-align:center">${act4Pond}</td></tr>
                </tbody>
            </table>

            <div class="field-line"><strong>Número de horas a la semana del Estudiante Dual en la UE:</strong> ${horasSemana}</div>

            <div class="section-label" style="margin-top:12px">CALENDARIZACIÓN DEL SEGUIMIENTO DE LA IE EN LA UE</div>
            <table>
                <thead>
                    <tr>
                        <th style="width:10%">MES</th>
                        <th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th>
                        <th>7</th><th>8</th><th>9</th><th>10</th><th>11</th><th>12</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td style="text-align:center;font-weight:bold">DÍA</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                </tbody>
            </table>

            <div class="signature-block page-break">
                <div style="width:100%;">
                    <div style="text-align:center;font-weight:bold;margin-bottom:4px">ELABORARON</div>
                    <div style="display:flex;justify-content:space-between;gap:20px">
                        <div style="flex:1;text-align:center">
                            <div class="sig-line">NOMBRE Y FIRMA</div>
                            <div class="sig-role">MENTOR DE LA UE</div>
                        </div>
                        <div style="flex:1;text-align:center">
                            <div class="sig-line">NOMBRE Y FIRMA</div>
                            <div class="sig-role">MENTOR ACADÉMICO</div>
                        </div>
                    </div>
                    <div style="margin-top:40px">
                        <div style="text-align:center;font-weight:bold;margin-bottom:4px">AUTORIZARON</div>
                        <div style="display:flex;justify-content:space-between;gap:20px">
                            <div style="flex:1;text-align:center">
                                <div class="sig-name">Dra. Fabiola Orquídea Sánchez Hernández</div>
                                <div class="sig-line">RESPONSABLE DE LA UE</div>
                            </div>
                            <div style="flex:1;text-align:center">
                                <div class="sig-line">RESPONSABLE DEL PROGRAMA ACADÉMICO</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else if (tipoAnexo === "5.4") {
        const numReporte = document.getElementById('an54-num-reporte').value;
        const fecha      = document.getElementById('an54-fecha').value;
        const per        = document.getElementById('an54-periodo').value;
        const proyecto   = document.getElementById('an54-proyecto').value;
        const ueInput    = document.getElementById('an54-ue').value;
        const ueNombre   = ueInput.trim() !== '' ? ueInput : (emp ? emp.nombre : 'S/A');
        const ie         = document.getElementById('an54-ie').value;
        const programa   = document.getElementById('an54-programa').value;

        const telEst     = document.getElementById('an54-tel-est').value;
        const telUe      = document.getElementById('an54-tel-ue').value;
        const telAcad    = document.getElementById('an54-tel-acad').value;

        const comp1Nom   = document.getElementById('an54-comp1-nom').value;
        const comp1Asig  = document.getElementById('an54-comp1-asig').value;
        const comp2Nom   = document.getElementById('an54-comp2-nom').value;
        const comp2Asig  = document.getElementById('an54-comp2-asig').value;
        const comp3Nom   = document.getElementById('an54-comp3-nom').value;
        const comp3Asig  = document.getElementById('an54-comp3-asig').value;
        const comp4Nom   = document.getElementById('an54-comp4-nom').value;
        const comp4Asig  = document.getElementById('an54-comp4-asig').value;

        const marco      = document.getElementById('an54-marco').value;
        const desc       = document.getElementById('an54-descripcion').value;
        const evalComp   = document.getElementById('an54-eval-comp').value;

        const nd1        = document.getElementById('an54-nd-1').value;
        const nd2        = document.getElementById('an54-nd-2').value;
        const nd3        = document.getElementById('an54-nd-3').value;
        const nd4        = document.getElementById('an54-nd-4').value;
        const nd5        = document.getElementById('an54-nd-5').value;

        const renderFilaMatriz = (idx) => {
            const act = document.getElementById(`an54-m${idx}-act`).value;
            const ev  = document.getElementById(`an54-m${idx}-ev`).value;
            const hrs = document.getElementById(`an54-m${idx}-hrs`).value;
            const niv = parseInt(document.getElementById(`an54-m${idx}-niv`).value) || 0;
            const fec = document.getElementById(`an54-m${idx}-fec`).value;
            const mentorNombre = mentUe ? mentUe.nombre : '';

            return `
                <tr>
                    <td>${act}</td>
                    <td>${ev}</td>
                    <td style="text-align:center">${hrs}</td>
                    <td style="text-align:center;font-weight:bold">${niv === 1 ? 'X' : ''}</td>
                    <td style="text-align:center;font-weight:bold">${niv === 2 ? 'X' : ''}</td>
                    <td style="text-align:center;font-weight:bold">${niv === 3 ? 'X' : ''}</td>
                    <td style="text-align:center;font-weight:bold">${niv === 4 ? 'X' : ''}</td>
                    <td style="text-align:center;font-weight:bold">${niv === 5 ? 'X' : ''}</td>
                    <td style="text-align:center;font-size:7.5pt">${act ? `${mentorNombre}<br>${fec}` : ''}</td>
                </tr>
            `;
        };

        previewPapel.innerHTML = `
            <div class="doc-header">"2026. Año del Humanismo Mexicano en el Estado de México".</div>
            <div class="doc-title">ANEXO 5.4</div>
            <div class="doc-subtitle">REPORTE DE ACTIVIDADES DEL ESTUDIANTE DUAL</div>

            <div class="section-label">1.- DATOS GENERALES</div>
            <div class="field-line">
                <strong>Número de Reporte:</strong> ${numReporte} &nbsp;&nbsp;&nbsp;
                <strong>Fecha de Elaboración:</strong> ${fecha} &nbsp;&nbsp;&nbsp;
                <strong>Periodo del Reporte:</strong> ${per}
            </div>
            <div class="field-line"><strong>Nombre del Proyecto o Plan de Rotación:</strong> ${proyecto}</div>
            <div class="field-line"><strong>Unidad Económica:</strong> ${ueNombre}</div>
            <div class="field-line"><strong>Institución Educativa:</strong> ${ie}</div>
            <div class="field-line"><strong>Programa Educativo:</strong> ${programa}</div>
            <div class="field-line">
                <strong>Nombre del Estudiante Dual:</strong> ${est.nombre} &nbsp;&nbsp;&nbsp;
                <strong>No. Teléfono:</strong> ${telEst}
            </div>
            <div class="field-line">
                <strong>Nombre del Mentor de la UE:</strong> ${mentUe ? mentUe.nombre : 'S/A'} &nbsp;&nbsp;&nbsp;
                <strong>No. Teléfono:</strong> ${telUe}
            </div>
            <div class="field-line">
                <strong>Nombre del Mentor Académico:</strong> ${mentAcad ? mentAcad.nombre : 'S/A'} &nbsp;&nbsp;&nbsp;
                <strong>No. Teléfono:</strong> ${telAcad}
            </div>

            <div class="section-label">2.- DESARROLLO DE COMPETENCIAS</div>
            <table>
                <thead>
                    <tr>
                        <th style="width:8%">No.</th>
                        <th style="width:46%">COMPETENCIAS A DESARROLLAR</th>
                        <th style="width:46%">ASIGNATURAS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td style="text-align:center">1</td><td>${comp1Nom}</td><td>${comp1Asig}</td></tr>
                    <tr><td style="text-align:center">2</td><td>${comp2Nom}</td><td>${comp2Asig}</td></tr>
                    <tr><td style="text-align:center">3</td><td>${comp3Nom}</td><td>${comp3Asig}</td></tr>
                    <tr><td style="text-align:center">4</td><td>${comp4Nom}</td><td>${comp4Asig}</td></tr>
                </tbody>
            </table>

            <div class="section-label" style="text-align:center">MARCO TEÓRICO O ANTECEDENTES</div>
            <div class="desc-box">${marco}</div>

            <div class="section-label" style="text-align:center">DESCRIPCIÓN DE LAS ACTIVIDADES REALIZADAS</div>
            <div class="desc-box">${desc}</div>

            <div class="section-label">3.- EVALUACIÓN DE LA UE</div>
            <table>
                <thead>
                    <tr>
                        <th colspan="9">MATRIZ DE EVALUACIÓN POR COMPETENCIA</th>
                    </tr>
                    <tr>
                        <th style="width:18%">COMPETENCIA</th>
                        <td colspan="7" style="font-weight:bold;text-align:left">${evalComp}</td>
                        <th rowspan="3" style="width:18%;vertical-align:middle;font-size:7pt">
                            NOMBRE, FIRMA Y FECHA DE EVALUACIÓN DEL MENTOR DE LA UE
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="2" style="vertical-align:middle">ACTIVIDADES</th>
                        <th rowspan="2" style="vertical-align:middle;width:18%">EVIDENCIAS O PRODUCTOS</th>
                        <th rowspan="2" style="vertical-align:middle;width:10%">HORAS DE DEDICACIÓN</th>
                        <th colspan="5">NIVEL DE DESEMPEÑO</th>
                    </tr>
                    <tr>
                        <th style="font-size:6.5pt;width:7%">${nd1}</th>
                        <th style="font-size:6.5pt;width:7%">${nd2}</th>
                        <th style="font-size:6.5pt;width:7%">${nd3}</th>
                        <th style="font-size:6.5pt;width:7%">${nd4}</th>
                        <th style="font-size:6.5pt;width:7%">${nd5}</th>
                    </tr>
                </thead>
                <tbody>
                    ${renderFilaMatriz(1)}
                    ${renderFilaMatriz(2)}
                    ${renderFilaMatriz(3)}
                </tbody>
            </table>

            <div class="signature-block" style="margin-top:28px">
                <div style="display:flex;justify-content:space-between;gap:40px">
                    <div style="flex:1;text-align:center">
                        <div style="font-weight:bold;margin-bottom:25px">ELABORÓ</div>
                        <div class="sig-line">NOMBRE Y FIRMA<br>ESTUDIANTE DUAL</div>
                        <div class="sig-role">${est.nombre}</div>
                    </div>
                    <div style="flex:1;text-align:center">
                        <div style="font-weight:bold;margin-bottom:25px">AUTORIZÓ</div>
                        <div class="sig-line">NOMBRE Y FIRMA<br>MENTOR ACADÉMICO</div>
                        <div class="sig-role">${mentAcad ? mentAcad.nombre : 'S/A'}</div>
                    </div>
                </div>
            </div>
        `;
    } else if (tipoAnexo === "5.5") {
        const proyecto = document.getElementById('an55-proyecto').value;
        const ue = document.getElementById('an55-ue').value;
        const mentorUeNombre = document.getElementById('an55-mentor-ue').value;
        const mentorAcadNombre = document.getElementById('an55-mentor-acad').value;
        const periodoInicio = document.getElementById('an55-periodo-inicio').value;
        const periodoTermino = document.getElementById('an55-periodo-termino').value;
        const semestre = document.getElementById('an55-semestre').value;
        const horarios = document.getElementById('an55-horarios').value;
        const apoyo = document.getElementById('an55-apoyo').value;
        const descProyecto = document.getElementById('an55-desc-proyecto').value;

        const c1 = document.getElementById('an55-comp1').value;
        const c1Asig = document.getElementById('an55-comp1-asig').value;
        const c2 = document.getElementById('an55-comp2').value;
        const c2Asig = document.getElementById('an55-comp2-asig').value;
        const c3 = document.getElementById('an55-comp3').value;
        const c3Asig = document.getElementById('an55-comp3-asig').value;

        const e1Per = document.getElementById('an55-eval1-periodo').value;
        const e1Act = document.getElementById('an55-eval1-act').value;
        const e1Lugar = document.getElementById('an55-eval1-lugar').value;
        const e1Pond = document.getElementById('an55-eval1-pond').value;
        const e1Nivel = document.getElementById('an55-eval1-nivel').value;

        const e2Per = document.getElementById('an55-eval2-periodo').value;
        const e2Act = document.getElementById('an55-eval2-act').value;
        const e2Lugar = document.getElementById('an55-eval2-lugar').value;
        const e2Pond = document.getElementById('an55-eval2-pond').value;
        const e2Nivel = document.getElementById('an55-eval2-nivel').value;

        const e3Per = document.getElementById('an55-eval3-periodo').value;
        const e3Act = document.getElementById('an55-eval3-act').value;
        const e3Lugar = document.getElementById('an55-eval3-lugar').value;
        const e3Pond = document.getElementById('an55-eval3-pond').value;
        const e3Nivel = document.getElementById('an55-eval3-nivel').value;

        const fmtFecha = (f) => {
            if (!f) return '_____________';
            const d = new Date(f + 'T00:00:00');
            return d.toLocaleDateString('es-MX', { day: '2-digit', month: 'long', year: 'numeric' });
        };

        previewPapel.innerHTML = `
            <div class="doc-header">"2026. Año del Humanismo Mexicano en el Estado de México".</div>
            <div class="doc-title">ANEXO 5.5</div>
            <div class="doc-subtitle">SEGUIMIENTO Y EVALUACIÓN DEL ESTUDIANTE DUAL</div>

            <div class="field-line"><strong>Nombre del Proyecto o Plan de Rotación:</strong> ${proyecto}</div>
            <div class="field-line"><strong>Unidad Económica:</strong> ${ue}</div>
            <div class="field-line"><strong>Institución Educativa:</strong> Tecnológico de Estudios Superiores de Chalco</div>
            <div class="field-line"><strong>Programa Educativo:</strong> ${est.carrera}</div>
            <div class="field-line"><strong>Nombre del Mentor de la UE:</strong> ${mentorUeNombre}</div>
            <div class="field-line"><strong>Nombre del Mentor Académico:</strong> ${mentorAcadNombre}</div>
            <div class="field-line"><strong>Periodo:</strong> &nbsp;&nbsp; Inicio: <strong>${fmtFecha(periodoInicio)}</strong> &nbsp;&nbsp;&nbsp; Término: <strong>${fmtFecha(periodoTermino)}</strong></div>
            <div class="field-line"><strong>Nombre del Estudiante Dual:</strong> ${est.nombre}</div>
            <div class="field-line"><strong>Semestre / Cuatrimestre:</strong> ${semestre} &nbsp;&nbsp;&nbsp; <strong>Horarios (incluir alimentos):</strong> ${horarios}</div>
            <div class="field-line"><strong>Apoyo (cuando aplique):</strong> ${apoyo}</div>

            <div class="section-label">DESCRIPCIÓN DEL PROYECTO (¿QUÉ?, ¿CÓMO?, ¿DÓNDE?, ¿CUÁNDO?, ¿PARA QUÉ?):</div>
            <div class="desc-box">${descProyecto}</div>

            <table>
                <thead>
                    <tr>
                        <th style="width:8%">No.</th>
                        <th>COMPETENCIAS A DESARROLLAR</th>
                        <th>ASIGNATURAS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td style="text-align:center">1</td><td>${c1}</td><td>${c1Asig}</td></tr>
                    <tr><td style="text-align:center">2</td><td>${c2}</td><td>${c2Asig}</td></tr>
                    <tr><td style="text-align:center">3</td><td>${c3}</td><td>${c3Asig}</td></tr>
                </tbody>
            </table>

            <div class="section-label">MATRIZ DE EVALUACIÓN DE LAS COMPETENCIAS</div>
            <table>
                <thead>
                    <tr>
                        <th style="width:8%">No. de Competencia</th>
                        <th style="width:12%">Periodo</th>
                        <th>Actividades</th>
                        <th style="width:10%">Lugar: UE/IE</th>
                        <th style="width:12%">Ponderación de Actividades %</th>
                        <th style="width:12%">Nivel de Desempeño</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td style="text-align:center">1</td><td style="text-align:center">${e1Per}</td><td>${e1Act}</td><td style="text-align:center">${e1Lugar}</td><td style="text-align:center">${e1Pond}</td><td style="text-align:center">${e1Nivel}</td></tr>
                    <tr><td style="text-align:center">2</td><td style="text-align:center">${e2Per}</td><td>${e2Act}</td><td style="text-align:center">${e2Lugar}</td><td style="text-align:center">${e2Pond}</td><td style="text-align:center">${e2Nivel}</td></tr>
                    <tr><td style="text-align:center">3</td><td style="text-align:center">${e3Per}</td><td>${e3Act}</td><td style="text-align:center">${e3Lugar}</td><td style="text-align:center">${e3Pond}</td><td style="text-align:center">${e3Nivel}</td></tr>
                    <tr style="font-weight:bold;background:#f0f0f0">
                        <td colspan="4" style="text-align:right">TOTAL</td>
                        <td style="text-align:center">100%</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <p style="font-size:7pt;font-style:italic;margin-top:-4px">*Repetir la matriz de evaluación de acuerdo con el número de competencias a desarrollar.</p>

            <div class="section-label" style="margin-top:12px">CALENDARIZACIÓN DEL SEGUIMIENTO DE LA IE EN LA UE</div>
            <table>
                <thead>
                    <tr>
                        <th style="width:10%">MES</th>
                        <th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th>
                        <th>7</th><th>8</th><th>9</th><th>10</th><th>11</th><th>12</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td style="text-align:center;font-weight:bold">FP</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                    <tr><td style="text-align:center;font-weight:bold">FR</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                    <tr><td style="text-align:center;font-weight:bold">SD</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                </tbody>
            </table>
            <p style="font-size:7.5pt;margin-top:-4px"><strong>FP</strong> = Fecha Programada / <strong>FR</strong> = Fecha de Realización / <strong>SD</strong> = Seguimiento Dual.</p>

            <div class="signature-block page-break">
                <div style="width:100%;">
                    <div style="text-align:center;font-weight:bold;margin-bottom:20px">ELABORARON</div>

                    <div style="display:flex;justify-content:space-between;gap:20px;margin-bottom:60px">
                        <div style="flex:1;text-align:center">
                            <div class="sig-line">NOMBRE Y FIRMA</div>
                            <div class="sig-role">MENTOR ACADÉMICO</div>
                        </div>
                        <div style="flex:1;text-align:center">
                            <div class="sig-line">NOMBRE Y FIRMA</div>
                            <div class="sig-role">RESPONSABLE DEL PROGRAMA ACADÉMICO</div>
                        </div>
                    </div>

                    <div style="display:flex;justify-content:center;margin-top:80px">
                        <div style="flex:0 0 60%;text-align:center">
                            <div class="sig-line">NOMBRE Y FIRMA</div>
                            <div class="sig-role">ESTUDIANTE DUAL</div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    renderHistorialFirmas(est);
}

function generarImpresionAnexo() {
    const contenidoPrint = document.getElementById('vista-previa-papel').innerHTML;
    const ventanaImpresion = window.open('', '', 'height=800,width=600');
    ventanaImpresion.document.write('<html><head><title>Impresión de Anexo Dual - TecNM</title>');
    ventanaImpresion.document.write(`
        <style>
            @page { size: letter portrait; margin: 0; }
            body { margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; }
            .paper-preview {
                width: 216mm;
                min-height: 279mm;
                padding: 35mm 15mm 12mm 15mm;
                box-sizing: border-box;
                font-size: 9pt;
                line-height: 1.25;
                position: relative;
            }
            .page-break { page-break-before: always; break-before: page; }
            .signature-block.page-break {
                display: flex;
                flex-direction: column;
                justify-content: center;
                min-height: 220mm;
                box-sizing: border-box;
            }
            .doc-header { text-align: center; font-size: 8pt; font-weight: bold; margin-bottom: 6px; }
            .doc-title { text-align: center; font-weight: bold; font-size: 11pt; margin: 4px 0; }
            .doc-subtitle { text-align: center; font-weight: bold; font-size: 10pt; margin: 2px 0 10px 0; }
            .field-line { margin: 3px 0; font-size: 9pt; }
            .field-line strong { font-weight: bold; }
            .desc-box { border: 1px solid #000; min-height: 45px; padding: 4px 6px; margin: 4px 0 8px 0; font-size: 9pt; }
            table { width: 100%; border-collapse: collapse; font-size: 8pt; margin: 4px 0 8px 0; }
            table th, table td { border: 1px solid #000; padding: 3px 4px; vertical-align: top; }
            table th { background: #e8e8e8; font-weight: bold; text-align: center; }
            .section-label { font-weight: bold; font-size: 9pt; margin: 6px 0 3px 0; }
            .signature-block { margin-top: 20px; font-size: 8pt; }
            .sig-line { border-top: 1px solid #000; text-align: center; padding-top: 3px; margin-top: 25px; }
            .sig-name { font-weight: bold; text-align: center; font-size: 8pt; }
            .sig-role { text-align: center; font-size: 8pt; }
        </style>
    `);
    ventanaImpresion.document.write('</head><body>');
    ventanaImpresion.document.write(`<div class="paper-preview">${contenidoPrint}</div>`);
    ventanaImpresion.document.write('</body></html>');
    ventanaImpresion.document.close();
    ventanaImpresion.focus();
    setTimeout(() => {
        ventanaImpresion.print();
        ventanaImpresion.close();
        showToast("Formato enviado a impresión con éxito.");
    }, 500);
}

function procesarCargaAnexoFirmado(event) {
    const file = event.target.files[0];
    const estId = document.getElementById('selector-formato-estudiante').value;
    const tipoAnexo = document.getElementById('selector-tipo-anexo').value;

    if (file && estId) {
        const est = DB.estudiantes.find(e => e.id == estId);
        if (est) {
            showToast(`Archivo "${file.name}" listo para subir (Anexo ${tipoAnexo}).`);
            // Aquí después se implementará la subida real al servidor con FormData
        }
    }
}

function renderHistorialFirmas(est) {
    const container = document.getElementById('historial-firmas-estudiante');
    if (!est || !est.anexosSubidos || est.anexosSubidos.length === 0) {
        container.innerHTML = `<p class="text-gray-400 italic">No hay archivos firmados subidos para el estudiante seleccionado.</p>`;
    } else {
        container.innerHTML = est.anexosSubidos.map(archivo => `
            <div class="flex items-center justify-between p-2 bg-emerald-50 rounded border border-emerald-100 text-xs">
                <div>
                    <span class="font-bold text-emerald-800">${archivo.tipo}</span>
                    <p class="text-[10px] text-gray-500">${archivo.nombreArchivo} (${archivo.fechaCarga})</p>
                </div>
                <span class="text-xs text-emerald-600 font-bold"><i class="fa-solid fa-circle-check"></i> Subido</span>
            </div>
        `).join('');
    }
}

// ============================================================
// ACTUALIZACIÓN EN TIEMPO REAL AL ESCRIBIR EN CUADROS DE TEXTO
// ============================================================
document.addEventListener('DOMContentLoaded', () => {
    const seccionFormatos = document.getElementById('tab-formatos');
    if (seccionFormatos) {
        seccionFormatos.addEventListener('input', (e) => {
            if (e.target.matches('input, textarea, select')) {
                actualizarPrevisualizacionFormatos();
            }
        });
    }
});

// ============================================================
// GUARDAR ANEXO 5.4 EN MYSQL Y GENERAR PDF
// ============================================================
async function guardarAnexo54(event) {
    event.preventDefault();

    const estId = document.getElementById('selector-formato-estudiante').value;
    if (!estId) {
        showToast('Selecciona un estudiante primero', 'error');
        return;
    }

    const formData = new FormData(document.getElementById('form-anexo54-db'));
    formData.append('estudiante_id', estId);

    try {
        const res = await fetch(API_BASE + 'anexo54.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();

        if (res.ok && data.success) {
            showToast(data.message);
            // Abre la ventana de impresión/PDF con los datos ya reflejados
            generarImpresionAnexo();
        } else {
            showToast(data.error || 'Error al guardar el Anexo 5.4', 'error');
        }
    } catch (error) {
        console.error(error);
        showToast('Error de conexión con el servidor', 'error');
    }
}