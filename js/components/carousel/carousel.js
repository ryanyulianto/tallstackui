export default (images, cover = 1, autoplay, interval, withoutLoop, shuffle, cardCarousel = false, cardsPerView = 3) => ({
  images: images,
  time: interval,
  current: cover,
  interval: null,
  paused: false,
  cardCarousel: cardCarousel,
  cardsPerView: cardsPerView,
  defaultCardsPerView: cardsPerView,
  init() {
    if (shuffle) this.shuffle();
    if (cardCarousel) {
      this.updateCardsPerView();
      window.addEventListener('resize', () => this.updateCardsPerView());
    }
    if (autoplay) this.play();
  },
  updateCardsPerView() {
    const width = window.innerWidth;
    if (width >= 1024) {
      this.cardsPerView = this.defaultCardsPerView;
    } else if (width >= 768) {
      this.cardsPerView = Math.min(2, this.defaultCardsPerView);
    } else {
      this.cardsPerView = 1;
    }
  },
  /**
   * Shuffle the carousel images.
   *
   * @returns {void}
   */
  shuffle() {
    for (let i = this.images.length - 1; i > 0; i--) {
      const number = Math.floor(Math.random() * (i + 1));

      [this.images[i], this.images[number]] = [this.images[number], this.images[i]];
    }
  },
  /**
   * Start the carousel automation.
   *
   * @returns {void}
   */
  play() {
    this.interval = setInterval(() => {
      if (!this.paused) {
        this.next();
      }
    }, this.time);
  },
  /**
   * Reset the carousel automation.
   *
   * @returns {void}
   */
  reset() {
    if (!autoplay) return;

    clearInterval(this.interval);

    this.time = interval;

    this.play();
  },
  /**
   * Advance to the next carousel image.
   *
   * @returns {void}
   */
  next() {
    if (cardCarousel) {
      const maxSlide = this.images.length - this.cardsPerView + 1;
      if (withoutLoop && this.current >= maxSlide) {
        return;
      }
      if (this.current < maxSlide) {
        this.current = this.current + 1;
      } else {
        this.current = 1;
      }
    } else {
      if (withoutLoop && this.current === this.images.length) {
        return;
      }
      if (this.current < this.images.length) {
        this.current = this.current + 1;
      } else {
        this.current = 1;
      }
    }

    this.event('next');
  },
  /**
   * Back to the previous carousel image.
   *
   * @returns {void}
   */
  previous() {
    if (cardCarousel) {
      const maxSlide = this.images.length - this.cardsPerView + 1;
      if (withoutLoop && this.current === 1) {
        return;
      }
      if (this.current > 1) {
        this.current = this.current - 1;
      } else {
        this.current = maxSlide;
      }
    } else {
      if (withoutLoop && this.current === 1) {
        return;
      }
      if (this.current > 1) {
        this.current = this.current - 1;
      } else {
        this.current = this.images.length;
      }
    }

    this.event('previous');
  },
  /**
   * Dispatch events.
   *
   * @param {String} type
   */
  event(type) {
    this.$refs.carousel.dispatchEvent(
      new CustomEvent(type, {
        detail: { current: this.current, image: this.images[this.current] },
      })
    );
  },
});
