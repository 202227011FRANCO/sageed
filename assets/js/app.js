// ============================================================
// SAGEED - app.js
// Núcleo global del sistema: navegación, modales, toasts
// ============================================================

// ====== CONFIGURACIÓN GLOBAL ======
const API_BASE = 'api/';

// Base de datos local en memoria (se llena desde el servidor)
let DB = {
    estudiantes: [],
    empresas: [],
    mentoresAcad: [],
    mentoresUe: [],
    competencias: []
};

// ============================================================
// NAVEGACIÓN ENTRE PESTAÑAS
// ============================================================
function switchTab(tabId) {
    // Ocultar todos los tabs
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));

    // Resetear estilos del sidebar
    document.querySelectorAll('.nav-btn').forEach(btn => {
        btn.classList.remove('bg-tecnm-blue', 'text-white');
        btn.classList.add('text-gray-300', 'hover:bg-white/10');
    });

    // Mostrar el tab activo
    document.getElementById(`tab-${tabId}`).classList.remove('hidden');
    const activeBtn = document.getElementById(`btn-tab-${tabId}`);
    if (activeBtn) {
        activeBtn.classList.add('bg-tecnm-blue', 'text-white');
        activeBtn.classList.remove('text-gray-300', 'hover:bg-white/10');
    }

    // Renderizar el contenido específico del tab
    if (tabId === 'dashboard')    renderDashboard();
    if (tabId === 'estudiantes')  renderEstudiantes();
    if (tabId === 'empresas')     renderEmpresas();
    if (tabId === 'mentores')     renderMentores();
    if (tabId === 'competencias') renderCompetencias();
    if (tabId === 'formatos') {
        llenarSelectoresFormatos();
        actualizarPrevisualizacionFormatos();
    }
}

// ============================================================
// SISTEMA DE NOTIFICACIONES (TOAST)
// ============================================================
function showToast(mensaje, tipo = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `p-4 rounded-xl shadow-lg text-white font-semibold text-xs transition duration-300 flex items-center justify-between gap-4 pointer-events-auto ${
        tipo === 'success' ? 'bg-emerald-600' : 'bg-red-600'
    }`;
    toast.innerHTML = `
        <div class="flex items-center gap-2">
            <i class="fa-solid ${tipo === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation'}"></i>
            <span>${mensaje}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">
            <i class="fa-solid fa-xmark"></i>
        </button>
    `;
    container.appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}

// ============================================================
// MANEJO DE MODALES
// ============================================================
async function openModal(modalType) {
    const modal = document.getElementById(`modal-${modalType}`);
    if (!modal) return;

    modal.classList.remove('hidden');

    // Cargar selectores dinámicos según el tipo de modal
    if (modalType === 'estudiante') {
        await cargarSelectoresEstudiante();
    } else if (modalType === 'mentor-ue') {
        await cargarSelectoresEmpresa();
    }
}

function closeModal(modalType) {
    const modal = document.getElementById(`modal-${modalType}`);
    if (modal) modal.classList.add('hidden');
}

// Cerrar modal al hacer clic fuera (opcional, mejora UX)
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('fixed') && e.target.classList.contains('inset-0')) {
        e.target.classList.add('hidden');
    }
});

// ============================================================
// CARGA INICIAL
// ============================================================
window.addEventListener('DOMContentLoaded', async () => {
    // Renderizar el dashboard al cargar la página
    if (typeof renderDashboard === 'function') {
        renderDashboard();
    }
});