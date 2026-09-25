// ====== CONFIGURACIÓN GLOBAL ======
const API_BASE = 'api/';

// ====== NAVEGACIÓN ======
function switchTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.nav-btn').forEach(btn => {
        btn.classList.remove('bg-tecnm-blue', 'text-white');
        btn.classList.add('text-gray-300', 'hover:bg-white/10');
    });

    document.getElementById(`tab-${tabId}`).classList.remove('hidden');
    const activeBtn = document.getElementById(`btn-tab-${tabId}`);
    activeBtn.classList.add('bg-tecnm-blue', 'text-white');
    activeBtn.classList.remove('text-gray-300', 'hover:bg-white/10');

    if (tabId === 'dashboard') renderDashboard();
    if (tabId === 'estudiantes') renderEstudiantes();
    if (tabId === 'empresas') renderEmpresas();
    if (tabId === 'mentores') renderMentores();
    if (tabId === 'competencias') renderCompetencias();
    if (tabId === 'formatos') {
        llenarSelectoresFormatos();
        actualizarPrevisualizacionFormatos();
    }
}

// ====== TOAST ======
function showToast(mensaje, tipo = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `p-4 rounded-xl shadow-lg text-white font-semibold text-xs transition duration-300 flex items-center justify-between gap-4 pointer-events-auto ${
        tipo === 'success' ? 'bg-emerald-600' : 'bg-red-600'
    }`;
    toast.innerHTML = `
        <div class="flex items-center gap-2">
            <i class="fa-solid ${tipo === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation'}"></i>
            <span>${mensaje}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200"><i class="fa-solid fa-xmark"></i></button>
    `;
    container.appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}

// ====== MODALES ======
function openModal(modalType) {
    const modal = document.getElementById(`modal-${modalType}`);
    if (modal) modal.classList.remove('hidden');
}

function closeModal(modalType) {
    const modal = document.getElementById(`modal-${modalType}`);
    if (modal) modal.classList.add('hidden');
}

// ====== CARGA INICIAL ======
window.addEventListener('DOMContentLoaded', () => {
    renderDashboard();
});