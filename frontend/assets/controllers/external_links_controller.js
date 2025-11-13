import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.processLinks();
    }

    processLinks() {
        const currentHost = window.location.hostname;
        const links = this.element.querySelectorAll('a[href]');

        links.forEach((link) => {
            try {
                const url = new URL(link.href);

                // Check if the link is external (different hostname)
                if (url.hostname && url.hostname !== currentHost) {
                    link.setAttribute('target', '_blank');
                    link.setAttribute('rel', 'noopener noreferrer');
                }
            } catch (e) {
                // Skip invalid URLs (relative links, mailto:, tel:, etc.)
            }
        });
    }
}
