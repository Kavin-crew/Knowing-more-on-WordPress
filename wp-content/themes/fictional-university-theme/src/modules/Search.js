import axios from 'axios';

class Search {
    // 1. Properties
    constructor() {
        this.addSearchHTML();
        this.openButton = document.querySelector('.search-trigger');
        this.closeButton = document.querySelector('.search-overlay__close');
        this.searchOverlay = document.querySelector('.search-overlay');
        this.searchField = document.getElementById('search-term');
        this.resultsDiv = document.getElementById('search-overlay__results');
        this.isOverlayOpen = false;
        this.isSpinnerVisible = false;
        this.previousSeachedValue;
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

        this.searchField.addEventListener('keyup', (e) => {
            this.typingLogic();
        });
    }

    // 3. Methods
    typingLogic() {
        // check search input value is the the same on previous typed searched value, this matters when user uses arrow keys, tab, and so on other than letters
        if (this.searchField.value != this.previousSeachedValue) {
            // resets timer, to only have 1 timer at time
            clearTimeout(this.typingTimer);

            // check search input empty or users delete the searched value or hit backspace
            if (this.searchField.value) {
                if (!this.isSpinnerVisible) {
                    this.resultsDiv.innerHTML = '<div class="spinner-loader"></div>';
                    this.isSpinnerVisible = true;
                }
                // set timer after 2sec to get result and set previous typed searched value to a variable, this will help us when users press arrow keys and so on
                this.typingTimer = setTimeout(() => {
                    this.getResults();
                    this.previousSeachedValue = this.searchField.value;
                }, 750);
            } else {
                this.resultsDiv.innerHTML = '';
                this.isSpinnerVisible = false;
            }
        }
    }

    getResults() {
        const searchTerm = this.searchField.value;

        const postsUrl = `${universityData.root_url}/wp-json/wp/v2/posts?search=${encodeURIComponent(searchTerm)}`;
        const pagesUrl = `${universityData.root_url}/wp-json/wp/v2/pages?search=${encodeURIComponent(searchTerm)}`;

        Promise.all([axios.get(postsUrl), axios.get(pagesUrl)])
            .then(([posts, pages]) => {
                const combinedResults = posts.data.concat(pages.data);
                this.resultsDiv.innerHTML = `<h2 class="search-overlay__section-title">General Information</h2>
            ${combinedResults.length ? '<ul class="link-list min-list">' : '<p>No general information matches that search.</p>'}
            ${combinedResults.map((item) => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
            ${combinedResults.length ? '</ul>' : ''}`;
                this.isSpinnerVisible = false;
            })
            .catch(() => {
                this.resultsDiv.innerHTML = '<p>Unexpected error; please try again.</p>';
                this.isSpinnerVisible = false;
            });
    }

    openOverlay() {
        this.searchOverlay.classList.add('search-overlay--active');
        document.body.classList.add('body-no-scroll');
        this.searchField.value = '';
        setTimeout(() => this.searchField.focus(), 301);
        this.isOverlayOpen = true;
    }

    closeOverlay() {
        this.searchOverlay.classList.remove('search-overlay--active');
        this.searchField.value = '';
        document.body.classList.remove('body-no-scroll');
        this.isOverlayOpen = false;
    }

    addSearchHTML() {
        document.body.insertAdjacentHTML(
            'beforeend',
            `
            <div class="search-overlay">
                <div class="search-overlay__top">
                    <div class="container">
                        <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                        <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
                        <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                    </div>
                </div>

                <div class="container">
                    <div id="search-overlay__results"></div>
                </div>
            </div>`,
        );
    }
}

export default Search;
