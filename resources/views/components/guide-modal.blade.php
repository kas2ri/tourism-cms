<div id="guide-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white max-w-md w-full rounded-3xl p-6 sm:p-8 shadow-2xl relative border border-sand-200">
        <button type="button" onclick="window.closeGuideModal ? window.closeGuideModal() : null" class="absolute top-5 right-5 text-stone-400 hover:text-stone-800 text-xl" aria-label="Close guide modal">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="text-center">
            <div class="w-16 h-16 bg-sand-100 text-forest rounded-2xl mx-auto flex items-center justify-center text-3xl mb-4">
                <i class="fa-solid fa-book-bookmark text-terracotta"></i>
            </div>
            <span class="text-[10px] uppercase font-bold tracking-widest text-terracotta">2025 Exclusive Edition</span>
            <h3 class="font-serif text-2xl font-bold text-forest mt-1">Download "Secret Ceylon" Guide</h3>
            <p class="text-xs text-stone-600 mt-2">
                40 hand-selected tea estates, safe train booking secrets, boutique villas, and our local etiquette guide.
            </p>
        </div>

        <form onsubmit="window.handleGuideDownload ? window.handleGuideDownload(event) : null" method="POST" action="{{ route('guide.download') }}" class="mt-6 space-y-3">
            @csrf
            <input type="hidden" name="guide_slug" value="secret-ceylon-2025">
            <div>
                <label for="modal-guide-name" class="sr-only">First Name</label>
                <input type="text" id="modal-guide-name" name="name" required placeholder="Your First Name" class="w-full p-3 rounded-xl border border-stone-300 text-xs focus:outline-none focus:border-forest">
            </div>
            <div>
                <label for="modal-guide-email" class="sr-only">Email Address</label>
                <input type="email" id="modal-guide-email" name="email" required placeholder="Where should we email the PDF?" class="w-full p-3 rounded-xl border border-stone-300 text-xs focus:outline-none focus:border-forest">
            </div>
            <button type="submit" class="w-full py-3 bg-forest hover:bg-forest-light text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow">
                Download Guidebook Now (PDF)
            </button>
        </form>
        <p class="text-[10px] text-stone-400 text-center mt-3">Free instant download. We will never share or sell your details.</p>
    </div>
</div>

