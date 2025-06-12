import { Catalog } from "./src/components/catalog.js"

const renderPostItem = item => `
    <a  
        href="posts.html?id=${item.id}"
        class="post-item"
    >
        <h3 class="post-item__title">
            ${item.title}
        </h3>

        <p class="post-item__body">
            ${item.body}
        </p>
        
        <div class="post-item__footer">
            <span class="post-item__read-more">Читать подробнее</span>
            <span class="post-item__id">ID: ${item.id}</span>
        </div>
    </a>
`

const getPostItems = async ({ limit, page }) => {
    try {
        const response = await fetch(`https://jsonplaceholder.typicode.com/posts?_limit=${limit}&_page=${page}`);

        if (!response.ok) {
            throw new Error(`Ошибка HTTP: ${response.status}`);
        }

        const total = +response.headers.get('x-total-count')
        const items = await response.json()
        return { items, total }
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
        throw error;
    }
}

const renderPhotoItem = item => `
    <a  
        href="photos/${item.id}"
        class="photo-item"
    >
        <span class="photo-item__title">
            ${item.title}
        </span>

        <img 
            src=${item.url}
            class="photo-item__image"
        >
    </a>
`

const getPhotoItems = async ({ limit, page }) => {
    try {
        const response = await fetch(`https://jsonplaceholder.typicode.com/photos?_limit=${limit}&_page=${page}`);

        if (!response.ok) {
            throw new Error(`Ошибка HTTP: ${response.status}`);
        }

        const total = +response.headers.get('x-total-count');
        const items = await response.json();
        return { items, total };
    } catch (error) {
        console.error('Ошибка при получении фотографий:', error);
        throw error;
    }
}

const init = () => {
    const catalog = document.getElementById('catalog')
    new Catalog(catalog, { 
        renderItem: renderPostItem,
        getItems: getPostItems
     }).init()
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init)
} else {
    init()
}
