<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center rounded-btn-m border border-border-control bg-bg-main p-btn-icon-m text-text-main transition-colors hover:bg-bg-button-light focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-1 disabled:pointer-events-none disabled:opacity-50']) }}>
    <span class="flex size-6 items-center justify-center">{{ $slot }}</span>
</button>
