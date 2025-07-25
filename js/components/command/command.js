export default (searchable = true, active, inactive) => ({
  searchable,
  active,
  inactive,
  search: '',
  activeIndex: 0,
  items: [],
  filteredItems: [],
  selectedItem: null,

  init() {
    this.collectItems();
    this.filterItems();
    this.setActiveItem(0);

    this.$nextTick(() => {
      this.focusSearchInput();
    });

    this.$watch('search', () => {
      this.filterItems();
    });
  },

  /**
   * Collect all command items from the DOM.
   *
   * @return {void}
   */
  collectItems() {
    const itemElements = this.$el.querySelectorAll('[data-command-item]');
    this.items = Array.from(itemElements).map((el, index) => {
      const group = el.closest('[data-command-group]')?.getAttribute('data-command-group') || '';
      return {
        element: el,
        index,
        title: el.textContent.trim(),
        group,
        href: el.getAttribute('data-href'),
        default: el.getAttribute('data-default') === 'true',
        searchable: el.getAttribute('data-searchable') !== 'false'
      };
    });
  },

  /**
   * Filter items based on search term.
   *
   * @return {void}
   */
  filterItems() {
    const allItems = this.$el.querySelectorAll('[data-command-item]');
    const allGroups = this.$el.querySelectorAll('[data-command-group]');

    this.hideAllGroups(allGroups);

    if (!this.searchable || this.search.length === 0) {
      this.showDefaultItems(allItems);
    } else {
      this.showMatchingItems(allItems);
    }

    this.updateVisibleItems();
    this.setActiveItem(0);
  },

  /**
   * Hide all command groups.
   *
   * @param {NodeList} groups
   * @return {void}
   */
  hideAllGroups(groups) {
    groups.forEach(group => {
      group.style.display = 'none';
    });
  },

  /**
   * Show only default items when no search term.
   *
   * @param {NodeList} items
   * @return {void}
   */
  showDefaultItems(items) {
    items.forEach(item => {
      const isDefault = item.getAttribute('data-default') === 'true';
      const wrapper = item.closest('[data-command-group]');
      
      if (isDefault) {
        item.style.display = '';
        if (wrapper) wrapper.style.display = '';
      } else {
        item.style.display = 'none';
      }
    });
  },

  /**
   * Show items matching search term.
   *
   * @param {NodeList} items
   * @return {void}
   */
  showMatchingItems(items) {
    const searchTerm = this.search.toLowerCase().replace(/\*/g, '');
    const visibleGroups = new Set();

    items.forEach(item => {
      const title = item.textContent.trim().toLowerCase();
      const isSearchable = item.getAttribute('data-searchable') !== 'false';
      const wrapper = item.closest('[data-command-group]');

      if (isSearchable && title.includes(searchTerm)) {
        item.style.display = '';
        if (wrapper) {
          visibleGroups.add(wrapper);
        }
      } else {
        item.style.display = 'none';
      }
    });

    visibleGroups.forEach(group => {
      group.style.display = '';
    });
  },

  /**
   * Update the list of visible items.
   *
   * @return {void}
   */
  updateVisibleItems() {
    const visibleItems = this.$el.querySelectorAll('[data-command-item]:not([style*="display: none"])');
    this.filteredItems = Array.from(visibleItems);
  },

  /**
   * Set the active item by index.
   *
   * @param {Number} index
   * @return {void}
   */
  setActiveItem(index) {
    if (this.filteredItems.length === 0) {
      this.activeIndex = -1;
      return;
    }

    this.clearActiveStates();
    this.activeIndex = Math.max(0, Math.min(index, this.filteredItems.length - 1));
    this.applyActiveState();
  },

  /**
   * Clear active states from all items.
   *
   * @return {void}
   */
  clearActiveStates() {
    this.filteredItems.forEach(item => {
      this.active.split(' ').forEach(cls => item.classList.remove(cls));
      this.inactive.split(' ').forEach(cls => item.classList.add(cls));
    });
  },

  /**
   * Apply active state to current item.
   *
   * @return {void}
   */
  applyActiveState() {
    const activeItem = this.filteredItems[this.activeIndex];
    if (activeItem) {
      this.inactive.split(' ').forEach(cls => activeItem.classList.remove(cls));
      this.active.split(' ').forEach((cls) => {
        activeItem.classList.add(cls)
      });
      this.scrollToActiveItem();
    }
  },

  /**
   * Move selection up.
   *
   * @return {void}
   */
  moveUp() {
    this.updateVisibleItems();
    if (this.filteredItems.length === 0) return;

    if (this.activeIndex > 0) {
      this.setActiveItem(this.activeIndex - 1);
    }
  },

  /**
   * Move selection down.
   *
   * @return {void}
   */
  moveDown() {
    this.updateVisibleItems();
    const nextIndex = Math.max(0, this.activeIndex) + 1;
    if (nextIndex < this.filteredItems.length) {
      this.setActiveItem(nextIndex);
    }
  },

  /**
   * Select an item.
   *
   * @param {HTMLElement|null} item
   * @return {void}
   */
  selectItem(item = null) {
    const selectedItem = item || this.filteredItems[this.activeIndex];
    if (!selectedItem) return;

    this.selectedItem = selectedItem;

    this.$el.dispatchEvent(new CustomEvent('command:select', {
      detail: { item: selectedItem }
    }));

    const href = selectedItem.getAttribute('data-href');
    if (href) {
      window.location.href = href;
    } else {
      selectedItem.click();
    }
  },

  /**
   * Scroll to the active item.
   *
   * @return {void}
   */
  scrollToActiveItem() {
    if (this.activeIndex === -1 || !this.$refs.itemsList) return;

    const activeElement = this.filteredItems[this.activeIndex];
    if (!activeElement) return;

    const container = this.$refs.itemsList;
    const elementTop = activeElement.offsetTop;
    const elementBottom = elementTop + activeElement.offsetHeight;
    const containerTop = container.scrollTop;
    const containerBottom = containerTop + container.offsetHeight;

    if (elementTop < containerTop) {
      container.scrollTop = elementTop;
    } else if (elementBottom > containerBottom) {
      container.scrollTop = elementBottom - container.offsetHeight;
    }
  },

  /**
   * Focus the search input.
   *
   * @return {void}
   */
  focusSearchInput() {
    if (this.$refs.searchInput) {
      this.$refs.searchInput.focus();
    }
  },

  /**
   * Handle keyboard navigation.
   *
   * @param {KeyboardEvent} event
   * @return {void}
   */
  handleKeydown(event) {
    const keyActions = {
      ArrowDown: () => {
        this.moveDown();
        this.focusSearchInput();
      },
      ArrowUp: () => {
        this.moveUp();
        this.focusSearchInput();
      },
      Enter: () => {
        this.selectItem();
      },
      Escape: () => {
        this.search = '';
        this.filterItems();
        this.focusSearchInput();
      }
    };

    const action = keyActions[event.key];
    if (action) {
      event.preventDefault();
      action();
    }
  }
});
