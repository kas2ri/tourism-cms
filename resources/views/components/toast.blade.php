<div id="toast-notification" class="fixed top-6 right-6 z-50 transform translate-y-[-150%] transition-transform duration-300 max-w-sm w-full bg-forest-900 text-white p-4 rounded-2xl shadow-2xl flex items-center gap-3 border border-forest-light">
    <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0">
        <i class="fa-solid fa-check text-sm"></i>
    </div>
    <div class="text-xs flex-1">
        <div class="font-bold text-sand-100" id="toast-title">Request Received</div>
        <div class="text-sand-200 text-[11px]" id="toast-message">We'll be in touch shortly!</div>
    </div>
    <button type="button" onclick="window.hideToast ? window.hideToast() : null" class="text-stone-400 hover:text-white" aria-label="Close notification">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>

