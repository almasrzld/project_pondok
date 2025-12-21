function galleryLoader() {
    return {
        loading: true,
        loadedItems: 0,
        totalItems: 0,
        skeletonCount: 8,
        minLoadingTime: 500,
        startTime: null,

        init() {
            this.startTime = Date.now();
            this.totalItems = this.getGalleryCount();

            if (this.totalItems === 0) {
                this.hideSkeleton();
                return;
            }

            this.setupImageLoading();

            setTimeout(() => {
                if (this.loading) {
                    this.hideSkeleton();
                }
            }, 3000);
        },

        getGalleryCount() {
            try {
                const galleryItems =
                    document.querySelectorAll('[x-data*="open"]');
                return galleryItems.length;
            } catch (error) {
                return 0;
            }
        },

        setupImageLoading() {
            const images = document.querySelectorAll('img[loading="lazy"]');

            if (images.length === 0) {
                this.hideSkeleton();
                return;
            }

            images.forEach((img) => {
                if (img.complete) {
                    this.itemLoaded();
                } else {
                    img.addEventListener("load", () => this.itemLoaded());
                    img.addEventListener("error", () => this.itemLoaded());
                }
            });
        },

        itemLoaded() {
            this.loadedItems++;

            if (this.loadedItems >= this.totalItems) {
                this.hideSkeleton();
            }
        },

        hideSkeleton() {
            const elapsedTime = Date.now() - this.startTime;
            const remainingTime = Math.max(
                0,
                this.minLoadingTime - elapsedTime
            );

            setTimeout(() => {
                this.loading = false;

                const content = document.querySelector(
                    '[x-data="galleryLoader()"]'
                );
                if (content) {
                    content.classList.add("loaded");
                }
            }, remainingTime);
        },

        reload() {
            this.loading = true;
            this.loadedItems = 0;
            this.startTime = Date.now();
            this.setupImageLoading();
        },
    };
}

if (typeof window !== "undefined") {
    window.GalleryLoader = galleryLoader;

    document.addEventListener("alpine:initialized", () => {
        const galleryElements = document.querySelectorAll(
            '[x-data="galleryLoader()"]'
        );
        galleryElements.forEach((el) => {
            if (!el.__x) {
                Alpine.initTree(el);
            }
        });
    });
}
