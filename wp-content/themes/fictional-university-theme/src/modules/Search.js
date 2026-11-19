class Search {
    // 1. Properties
    constructor() {
        this.openButton = document.querySelector('.search-trigger');
        this.closeButton = document.querySelector('.search-overlay__close');
        this.searchOverlay = document.querySelector('.search-overlay');
        this.searchInput = document.querySelector('.search-term');
        this.isOverlayOpen = false;
        this.events();
    }

    // 2. Events
    events() {
        this.openButton.addEventListener('click', () => this.openOverlay());
        this.closeButton.addEventListener('click', () => this.closeOverlay());

        // press S, avoid triggering while use is typing
        document.addEventListener('keydown', (e) => {
            const isTyping =
                e.target.matches('input, textarea, select') || e.target.isContentEditable;

            if (e.key.toLowerCase() === 's' && !isTyping && !this.isOverlayOpen) {
                this.openOverlay();
            }
        });

        // close hitting Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOverlayOpen) {
                this.closeOverlay();
            }
        });
    }

    // 3. Methods
    openOverlay() {
        this.searchOverlay.classList.add('search-overlay--active');
        document.body.classList.add('body-no-scroll');
        this.isOverlayOpen = true;
        this.searchInput.focus();
        console.log('open');
    }

    closeOverlay() {
        this.searchOverlay.classList.remove('search-overlay--active');
        this.searchInput.value = '';
        document.body.classList.remove('body-no-scroll');
        this.isOverlayOpen = false;
        console.log('close');
    }
}

export default Search;
