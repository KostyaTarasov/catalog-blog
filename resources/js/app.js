document.addEventListener('alpine:init', () => {
    Alpine.store('cart', {
        count: Number(document.querySelector('meta[name="cart-count"]')?.content ?? 0),
    });

    Alpine.data('slider', () => ({
        scrollStep(direction) {
            const track = this.$refs.track;
            const card = track.firstElementChild;

            if (!card) {
                return;
            }

            const gap = parseFloat(getComputedStyle(track).columnGap) || 0;

            track.scrollBy({
                left: direction * (card.getBoundingClientRect().width + gap),
                behavior: 'smooth',
            });
        },
    }));
});

window.addToCart = async (productId, qty = 1) => {
    const response = await fetch('/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ product_id: productId, qty }),
    });

    if (response.ok) {
        Alpine.store('cart').count = (await response.json()).count;
    }
};
