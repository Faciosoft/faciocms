export const IsExpanded = (page_id) => {
    const text = localStorage.getItem('pages-expand-state');
    const states = JSON.parse(text);

    return states ? states[page_id] : false;
}