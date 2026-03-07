/**
 * Fetches a URL and returns the DOM element matching the selector.
 * @param {string} url
 * @param {string} selector - CSS selector to extract from the response HTML
 * @returns {Promise<Element|null>}
 */
async function fetchPartial(url, selector) {
    const res  = await fetch(url);
    const html = await res.text();
    const doc  = new DOMParser().parseFromString(html, 'text/html');
    return doc.querySelector(selector);
}
