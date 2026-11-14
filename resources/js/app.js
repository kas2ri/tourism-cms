import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Default currency rates fallback
const DEFAULT_CURRENCY_RATES = {
    USD: { rate: 1.0, symbol: '$' },
    EUR: { rate: 0.92, symbol: '€' },
    GBP: { rate: 0.79, symbol: '£' },
    AUD: { rate: 1.52, symbol: 'A$' }
};

let currentCurrency = localStorage.getItem('kiyara_currency') || 'USD';

// Trip Builder State
let builderState = {
    party: 'solo',
    partyCount: 1,
    days: 10,
    tierRate: 190
};

let activeModalTourIndex = 0;
let toastTimeout;

// Helper to get currency configuration
function getCurrencyConfig() {
    const rates = window.CURRENCY_RATES || DEFAULT_CURRENCY_RATES;
    return rates[currentCurrency] || rates['USD'] || { rate: 1.0, symbol: '$' };
}

// 1. Currency Management
export function updateCurrency(currency, suppressToast = false) {
    currentCurrency = currency;
    localStorage.setItem('kiyara_currency', currency);

    const currencySelect = document.getElementById('currency-select');
    if (currencySelect && currencySelect.value !== currency) {
        currencySelect.value = currency;
    }

    const { rate, symbol } = getCurrencyConfig();

    // Update all tour cards price displays
    document.querySelectorAll('.price-display').forEach(el => {
        const usd = parseFloat(el.getAttribute('data-usd'));
        if (!isNaN(usd)) {
            const converted = Math.round(usd * rate);
            el.textContent = `${symbol}${converted.toLocaleString()}`;
        }
    });

    // Update active modal drawer price if visible
    const modalPriceEl = document.getElementById('modal-price');
    if (modalPriceEl && window.TOURS_DATA && window.TOURS_DATA[activeModalTourIndex]) {
        const tour = window.TOURS_DATA[activeModalTourIndex];
        const converted = Math.round(tour.usdPrice * rate);
        modalPriceEl.textContent = `${symbol}${converted.toLocaleString()}`;
    }

    // Recalculate trip builder live values
    calculateBuilderPrice();

    if (!suppressToast) {
        showToast('Currency Updated', `All prices now displayed in ${currency}`);
    }
}

// 2. Filter Tours
export function filterTours(category, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => {
        b.classList.remove('bg-forest', 'text-white');
        b.classList.add('bg-white', 'text-stone-700');
    });

    if (btn) {
        btn.classList.add('bg-forest', 'text-white');
        btn.classList.remove('bg-white', 'text-stone-700');
    }

    const cards = document.querySelectorAll('.tour-card');
    cards.forEach(card => {
        const cardCategories = card.getAttribute('data-category') || '';
        if (category === 'all' || cardCategories.includes(category)) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    });
}

// 3. Hero Quick Filter Search
export function handleHeroSearch() {
    const regionEl = document.getElementById('hero-region');
    const styleEl = document.getElementById('hero-style');

    const style = styleEl ? styleEl.value : 'all';

    const expSection = document.getElementById('expeditions');
    if (expSection) {
        expSection.scrollIntoView({ behavior: 'smooth' });
    }

    if (style === 'group') {
        const groupBtn = document.querySelectorAll('.filter-btn')[1];
        if (groupBtn) filterTours('group', groupBtn);
    } else if (style === 'bespoke') {
        const bespokeBtn = document.querySelectorAll('.filter-btn')[2];
        if (bespokeBtn) filterTours('bespoke', bespokeBtn);
    } else if (style === 'wellness') {
        const wellnessBtn = document.querySelectorAll('.filter-btn')[3];
        if (wellnessBtn) filterTours('wellness', wellnessBtn);
    } else {
        const allBtn = document.querySelectorAll('.filter-btn')[0];
        if (allBtn) filterTours('all', allBtn);
    }

    showToast('Journeys Filtered', 'Showing itineraries matching your island preferences.');
}

// 4. Trip Builder Functions
export function selectParty(type, count, btn) {
    builderState.party = type;
    builderState.partyCount = count;

    document.querySelectorAll('#builder-party .builder-btn').forEach(b => {
        b.classList.remove('border-terracotta', 'bg-sand-50/50');
        b.classList.add('border-stone-200');
    });

    if (btn) {
        btn.classList.add('border-terracotta', 'bg-sand-50/50');
        btn.classList.remove('border-stone-200');
    }

    calculateBuilderPrice();
}

export function updateDuration(val) {
    builderState.days = parseInt(val, 10);
    const label = document.getElementById('duration-val');
    if (label) {
        label.textContent = `${val} Days`;
    }
    calculateBuilderPrice();
}

export function selectTier(tier, rate, btn) {
    builderState.tierRate = rate;

    document.querySelectorAll('#builder-tier .tier-btn').forEach(b => {
        b.classList.remove('border-terracotta', 'bg-sand-50/50');
        b.classList.add('border-stone-200');
    });

    if (btn) {
        btn.classList.add('border-terracotta', 'bg-sand-50/50');
        btn.classList.remove('border-stone-200');
    }

    calculateBuilderPrice();
}

export function calculateBuilderPrice() {
    const { rate, symbol } = getCurrencyConfig();

    let perPersonUsd = builderState.tierRate * builderState.days;

    // Group economies of scale
    if (builderState.partyCount >= 2) perPersonUsd = perPersonUsd * 0.92;
    if (builderState.partyCount >= 4) perPersonUsd = perPersonUsd * 0.85;

    const totalUsd = perPersonUsd * builderState.partyCount;
    const convertedTotal = Math.round(totalUsd * rate);
    const convertedPerPerson = Math.round(perPersonUsd * rate);

    const totalEl = document.getElementById('builder-calc-total');
    const perPersonEl = document.getElementById('builder-calc-perperson');

    if (totalEl) {
        totalEl.textContent = `${symbol}${convertedTotal.toLocaleString()}`;
    }
    if (perPersonEl) {
        perPersonEl.textContent = `approx. ${symbol}${convertedPerPerson.toLocaleString()} / person`;
    }
}

export function requestEstimatedTrip() {
    let perPersonUsd = builderState.tierRate * builderState.days;
    if (builderState.partyCount >= 2) perPersonUsd = perPersonUsd * 0.92;
    if (builderState.partyCount >= 4) perPersonUsd = perPersonUsd * 0.85;
    const totalUsd = Math.round(perPersonUsd * builderState.partyCount);

    const context = `Custom Trip Estimator (${builderState.days} Days, ${builderState.partyCount} travelers, ${builderState.party} tier)`;
    openInquiryModal(context);

    // Sync form inputs if present
    const durInput = document.getElementById('inquiry-duration');
    if (durInput) durInput.value = builderState.days;
    const guestsInput = document.getElementById('inquiry-guests');
    if (guestsInput) guestsInput.value = builderState.partyCount;
    const costInput = document.getElementById('inquiry-cost');
    if (costInput) costInput.value = totalUsd;
    const tierInput = document.getElementById('inquiry-tier');
    if (tierInput) tierInput.value = builderState.party;
}

// 5. Itinerary Drawer / Modal with smooth AJAX enrichment
export async function openItineraryModal(index, packageId) {
    activeModalTourIndex = index;
    const cachedTour = window.TOURS_DATA ? window.TOURS_DATA[index] : null;
    const pkgId = packageId || (cachedTour ? cachedTour.id : null) || (index + 1);

    const titleEl = document.getElementById('modal-tour-title');
    const tagEl = document.getElementById('modal-tour-tag');
    const metaEl = document.getElementById('modal-tour-meta');
    const priceEl = document.getElementById('modal-price');
    const dayContainer = document.getElementById('modal-day-flow');
    const inclusionsEl = document.getElementById('modal-inclusions');

    const { rate, symbol } = getCurrencyConfig();

    // 1. Instant baseline render to eliminate layout shift
    if (cachedTour) {
        if (titleEl) titleEl.textContent = cachedTour.title;
        if (tagEl) tagEl.textContent = cachedTour.tag;
        if (metaEl) metaEl.textContent = `${cachedTour.duration} • ${cachedTour.meta}`;
        if (priceEl) {
            const convertedPrice = Math.round(cachedTour.usdPrice * rate);
            priceEl.textContent = `${symbol}${convertedPrice.toLocaleString()}`;
        }

        if (dayContainer && Array.isArray(cachedTour.days)) {
            dayContainer.innerHTML = cachedTour.days.map(d => `
                <div class="p-4 rounded-2xl bg-sand-50 border border-sand-200 transition-all hover:border-forest/30">
                    <div class="font-bold text-xs uppercase tracking-wider text-forest mb-1">${d.day}</div>
                    <p class="text-xs text-stone-600 leading-relaxed">${d.desc}</p>
                </div>
            `).join('');
        }
    }

    const modal = document.getElementById('itinerary-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // 2. Fetch full package schedule via AJAX smoothly without layout jump
    if (pkgId) {
        try {
            const res = await fetch(`/api/packages/${pkgId}/itinerary`, {
                headers: { 'Accept': 'application/json' }
            });
            if (res.ok) {
                const json = await res.json();
                if (json.success && json.package) {
                    const pkg = json.package;
                    if (titleEl) titleEl.textContent = pkg.title;
                    if (tagEl) tagEl.textContent = pkg.subtitle;
                    if (metaEl) metaEl.textContent = `${pkg.duration_label} • Max ${pkg.group_size_max} Guests • ${pkg.difficulty}`;
                    if (priceEl) {
                        const convertedPrice = Math.round(pkg.starting_price_usd * rate);
                        priceEl.textContent = `${symbol}${convertedPrice.toLocaleString()}`;
                    }

                    if (dayContainer && Array.isArray(pkg.itinerary) && pkg.itinerary.length > 0) {
                        dayContainer.innerHTML = pkg.itinerary.map(item => `
                            <div class="p-4 rounded-2xl bg-sand-50 border border-sand-200 transition-all hover:border-forest/30">
                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                    <span class="font-bold text-xs uppercase tracking-wider text-forest">Day ${item.day_number}: ${item.title}</span>
                                    ${item.location ? `<span class="text-[10px] text-stone-500 bg-sand-200 px-2 py-0.5 rounded-full"><i class="fa-solid fa-location-dot text-terracotta mr-1"></i>${item.location}</span>` : ''}
                                </div>
                                <p class="text-xs text-stone-600 leading-relaxed">${item.full_description}</p>
                                ${item.stay_notes ? `<div class="mt-2 text-[11px] text-forest font-medium flex items-center gap-1.5"><i class="fa-solid fa-bed text-stone-400"></i> ${item.stay_notes}</div>` : ''}
                            </div>
                        `).join('');
                    }

                    if (inclusionsEl && Array.isArray(pkg.inclusions)) {
                        inclusionsEl.innerHTML = pkg.inclusions.map(inc => `<li>&bull; ${inc}</li>`).join('');
                    }
                }
            }
        } catch (e) {
            console.debug('Itinerary drawer AJAX fetch skipped; cached view retained.', e);
        }
    }
}

export function closeItineraryModal() {
    const modal = document.getElementById('itinerary-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

export function bookThisTourFromModal() {
    const tour = window.TOURS_DATA ? window.TOURS_DATA[activeModalTourIndex] : null;
    closeItineraryModal();
    const context = tour ? `Booking Request: ${tour.title}` : 'Booking Request';
    openInquiryModal(context);
}

// 6. Inquiry Modal
export function openInquiryModal(context = 'General Inquiry') {
    const contextInput = document.getElementById('inquiry-context');
    if (contextInput) {
        contextInput.value = context;
    }

    const modal = document.getElementById('inquiry-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

export function closeInquiryModal() {
    const modal = document.getElementById('inquiry-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

export async function handleInquirySubmit(e) {
    if (e && e.preventDefault) e.preventDefault();
    const form = e?.target || document.querySelector('#inquiry-modal form');
    if (!form) return;

    const formData = new FormData(form);

    try {
        const response = await fetch('/inquiries', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: formData
        });

        const data = await response.json();
        closeInquiryModal();
        form.reset();
        showToast(
            data.toast?.title || 'Proposal Requested!',
            data.toast?.message || 'Ayubowan! Our founder or travel curator will craft your journey and email you within 24 hours.'
        );
    } catch (err) {
        closeInquiryModal();
        showToast('Proposal Requested!', 'Ayubowan! Our founder or travel curator will craft your journey and email you within 24 hours.');
    }
}

// 7. Guide Download Modals
export function openGuideModal() {
    const modal = document.getElementById('guide-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

export function closeGuideModal() {
    const modal = document.getElementById('guide-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

export async function handleGuideDownload(e) {
    if (e && e.preventDefault) e.preventDefault();
    const form = e?.target || document.querySelector('#guide-modal form');
    if (!form) return;

    const formData = new FormData(form);
    const email = formData.get('email') || 'your email';

    try {
        const response = await fetch('/guide-download', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: formData
        });

        const data = await response.json();
        closeGuideModal();
        form.reset();
        showToast(
            data.toast?.title || 'Guidebook On Its Way!',
            data.toast?.message || `We've dispatched "Secret Ceylon 2025" to ${email}`
        );
    } catch (err) {
        closeGuideModal();
        showToast('Guidebook On Its Way!', `We've dispatched "Secret Ceylon 2025" to ${email}`);
    }
}

export function handleInlineGuide(e) {
    if (e && e.preventDefault) e.preventDefault();
    const emailInput = document.getElementById('inline-guide-email');
    const email = emailInput ? emailInput.value : 'your email';
    if (emailInput) emailInput.value = '';
    showToast('Guide Downloaded!', `Thank you! Your PDF link has been sent to ${email}`);
}

// 8. Insiders Modal
export function openInsidersModal() {
    const modal = document.getElementById('insiders-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

export function closeInsidersModal() {
    const modal = document.getElementById('insiders-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// 9. WhatsApp Concierge Widget
export function toggleWhatsAppChat() {
    const box = document.getElementById('wa-chatbox');
    if (box) {
        box.classList.toggle('hidden');
        if (!box.classList.contains('hidden')) {
            const input = document.getElementById('wa-input');
            if (input) setTimeout(() => input.focus(), 100);
        }
    }
}

export function sendWhatsAppMessage(customMsg = null) {
    const input = document.getElementById('wa-input');
    const message = (typeof customMsg === 'string' && customMsg.trim()) 
        ? customMsg.trim() 
        : (input ? input.value.trim() : '');

    if (!message) return;

    const rawPhone = window.WHATSAPP_PHONE || '94771234567';
    const cleanPhone = String(rawPhone).replace(/\D/g, '') || '94771234567';

    const url = `https://wa.me/${cleanPhone}?text=${encodeURIComponent(message)}`;

    if (input) {
        input.value = '';
    }

    if (typeof showToast === 'function') {
        showToast('Connecting to WhatsApp', 'Opening your WhatsApp chat with Kiyara Concierge...');
    }

    // Open WhatsApp in a new tab
    window.open(url, '_blank', 'noopener,noreferrer');

    const chatbox = document.getElementById('wa-chatbox');
    if (chatbox) {
        chatbox.classList.add('hidden');
    }
}

export function sendSimulatedWhatsApp(customMsg = null) {
    return sendWhatsAppMessage(customMsg);
}

// 10. Mobile Menu Toggle
export function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const icon = document.getElementById('menu-icon');
    if (!menu) return;

    menu.classList.toggle('hidden');
    if (icon) {
        if (menu.classList.contains('hidden')) {
            icon.classList.remove('fa-xmark');
            icon.classList.add('fa-bars');
        } else {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-xmark');
        }
    }
}

// 11. Toast Notifications
export function showToast(title, message) {
    const toast = document.getElementById('toast-notification');
    if (!toast) return;

    const titleEl = document.getElementById('toast-title');
    const msgEl = document.getElementById('toast-message');

    if (titleEl) titleEl.textContent = title;
    if (msgEl) msgEl.textContent = message;

    toast.classList.remove('translate-y-[-150%]');
    toast.classList.add('translate-y-0');

    clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => {
        hideToast();
    }, 5000);
}

export function hideToast() {
    const toast = document.getElementById('toast-notification');
    if (toast) {
        toast.classList.remove('translate-y-0');
        toast.classList.add('translate-y-[-150%]');
    }
}

// Expose functions globally to window for Blade inline handlers
window.updateCurrency = updateCurrency;
window.filterTours = filterTours;
window.handleHeroSearch = handleHeroSearch;
window.selectParty = selectParty;
window.updateDuration = updateDuration;
window.selectTier = selectTier;
window.calculateBuilderPrice = calculateBuilderPrice;
window.requestEstimatedTrip = requestEstimatedTrip;
window.openItineraryModal = openItineraryModal;
window.closeItineraryModal = closeItineraryModal;
window.bookThisTourFromModal = bookThisTourFromModal;
window.openInquiryModal = openInquiryModal;
window.closeInquiryModal = closeInquiryModal;
window.handleInquirySubmit = handleInquirySubmit;
window.openGuideModal = openGuideModal;
window.closeGuideModal = closeGuideModal;
window.handleGuideDownload = handleGuideDownload;
window.handleInlineGuide = handleInlineGuide;
window.openInsidersModal = openInsidersModal;
window.closeInsidersModal = closeInsidersModal;
window.toggleWhatsAppChat = toggleWhatsAppChat;
window.sendWhatsAppMessage = sendWhatsAppMessage;
window.sendSimulatedWhatsApp = sendSimulatedWhatsApp;
window.toggleMobileMenu = toggleMobileMenu;
window.showToast = showToast;
window.hideToast = hideToast;

// Navbar scroll readability
function initNavbarScroll() {
    const nav = document.getElementById('main-nav');
    if (!nav) return;

    const handleScroll = () => {
        if (window.scrollY > 15) {
            nav.classList.add('bg-[#f4efe6]/95', 'backdrop-blur-md', 'shadow-sm');
        } else {
            nav.classList.add('bg-[#f4efe6]/95', 'backdrop-blur-md', 'shadow-sm');
        }
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    initNavbarScroll();

    // Restore saved currency or default
    updateCurrency(currentCurrency, true);

    // Initial trip builder calculation
    calculateBuilderPrice();

    // Close modals on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeItineraryModal();
            closeInquiryModal();
            closeGuideModal();
            closeInsidersModal();
        }
    });

    // Close modals on clicking backdrop
    ['itinerary-modal', 'inquiry-modal', 'guide-modal', 'insiders-modal'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('click', (e) => {
                if (e.target === el) {
                    if (id === 'itinerary-modal') closeItineraryModal();
                    if (id === 'inquiry-modal') closeInquiryModal();
                    if (id === 'guide-modal') closeGuideModal();
                    if (id === 'insiders-modal') closeInsidersModal();
                }
            });
        }
    });
});
