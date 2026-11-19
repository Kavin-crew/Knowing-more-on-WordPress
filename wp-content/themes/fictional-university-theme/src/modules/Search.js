class Search {
    // 1. Properties
    constructor() {
        this.openButton = document.querySelector('.search-trigger');
        this.closeButton = document.querySelector('.search-overlay__close');
        this.searchOverlay = document.querySelector('.search-overlay');
        this.searchField = document.getElementById('search-term');
        this.isOverlayOpen = false;
        this.typingTimer;
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

        this.searchField.addEventListener('keydown', (e) => {
            this.typingLogic();
        });
    }

    // 3. Methods
    typingLogic() {
        clearTimeout(this.typingTimer);
        this.typingTimer = setTimeout(function () {
            console.log('typing ends on 2 sec');
        }, 2000);
    }

    openOverlay() {
        this.searchOverlay.classList.add('search-overlay--active');
        document.body.classList.add('body-no-scroll');
        this.isOverlayOpen = true;
        this.searchField.focus();
    }

    closeOverlay() {
        this.searchOverlay.classList.remove('search-overlay--active');
        this.searchField.value = '';
        document.body.classList.remove('body-no-scroll');
        this.isOverlayOpen = false;
    }
}

export default Search;
