<div id="<?= $notificationId ?>" class="notification p-4 flex gap-3 bg-notification text-foreground rounded-lg transition duration-100 ease-linear translate-x-2/4 opacity-75 pointer-events-none">
    <div class="icon self-center shrink">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-7 fill-green-500 stroke-notification">
            <circle cx="12" cy="12" r="10" />
            <path d="m9 12 2 2 4-4" />
        </svg>
    </div>
    <div class="notification-message shrink grow">
        <p class="title font-semibold text-sm"><?= esc($title) ?></p>
        <p class="message mt-0.5 text-sm text-wrap"><?= esc($message) ?></p>
    </div>
    <button class="close-notification shrink-0 self-center text-accent-dark-gray cursor-pointer hover:text-accent-light-gray active:text-accent-light-gray focus:outline-none" tabindex="-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6">
            <path d="M18 6 6 18" />
            <path d="m6 6 12 12" />
        </svg>
    </button>
</div>