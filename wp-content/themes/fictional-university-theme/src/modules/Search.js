class Search {
    // 1. Properties
    constructor() {
        this.openButton = document.querySelector('.search-trigger');
        this.closeButton = document.querySelector('.search-overlay__close');
        this.searchOverlay = document.querySelector('.search-overlay');
        this.events();
    }

    // 2. Events
    events() {
        this.openButton.addEventListener('click', () => this.openOverlay());
        this.closeButton.addEventListener('click', () => this.closeOverlay());
    }

    // 3. Methods
    openOverlay() {
        this.searchOverlay.classList.add('search-overlay--active');
    }

    closeOverlay() {
        this.searchOverlay.classList.remove('search-overlay--active');
    }
}

export default Search;
