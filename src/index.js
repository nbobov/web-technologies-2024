import { Pizza } from '../pizzeria.js';

const pizzaImages = {
    'Маргарита': 'https://cdn.pixabay.com/photo/2017/01/22/19/20/pizza-2000615_960_720.jpg',
    'Пепперони': 'https://cdn.pixabay.com/photo/2018/04/07/15/03/pizza-3298685_960_720.jpg',
    'Баварская': 'https://cdn.pixabay.com/photo/2017/12/10/14/47/pizza-3010062_960_720.jpg'
};

const toppingImages = {
    'Сливочная моцарелла': 'https://cdn.pixabay.com/photo/2010/12/16/12/12/mozarella-3521_1280.jpg',
    'Сырный борт': 'https://cdn.pixabay.com/photo/2020/05/17/04/22/pizza-5179939_960_720.jpg',
    'Чедер и пармезан': 'https://cdn.pixabay.com/photo/2016/10/11/16/44/parmesan-1732086_1280.jpg'
};

document.addEventListener('DOMContentLoaded', init);

let currentPizza = null;

function init() {
    renderPizzaTypes();
    renderPizzaSizes();
    renderToppings();
    selectInitialOptions();
}

function renderPizzaTypes() {
    const container = document.getElementById('pizza-types');

    for (const [pizzaType, data] of Object.entries(Pizza.TYPES)) {
        const card = document.createElement('div');
        card.classList.add('pizza-card');
        card.dataset.type = pizzaType;

        card.innerHTML = `
            <img src="${pizzaImages[pizzaType]}" alt="${pizzaType}" class="pizza-image">
            <div class="pizza-info">
                <div class="pizza-name">${pizzaType}</div>
                <div class="pizza-price">${data.price} ₽</div>
                <div class="pizza-calories">${data.calories} ккал</div>
            </div>
        `;

        card.addEventListener('click', () => selectPizzaType(pizzaType));
        container.appendChild(card);
    }
}

function renderPizzaSizes() {
    const container = document.getElementById('pizza-sizes');

    for (const [size, data] of Object.entries(Pizza.SIZES)) {
        const button = document.createElement('button');
        button.classList.add('size-button');
        button.dataset.size = size;
        button.textContent = `${size} (+${data.price} ₽)`;

        button.addEventListener('click', () => selectPizzaSize(size));
        container.appendChild(button);
    }
}

function renderToppings() {
    const container = document.getElementById('pizza-toppings');
    container.innerHTML = '';

    const currentSize = currentPizza ? currentPizza.getSize() : 'Маленькая';

    for (const [topping, data] of Object.entries(Pizza.TOPPINGS)) {
        const card = document.createElement('div');
        card.classList.add('topping-card');
        card.dataset.topping = topping;

        let priceText;
        if (data.size) {
            priceText = `${data.price[currentSize]} ₽`;
        } else {
            priceText = `${data.price} ₽`;
        }

        card.innerHTML = `
            <img src="${toppingImages[topping]}" alt="${topping}" class="topping-image">
            <div class="topping-info">
                <div class="topping-name">${topping}</div>
                <div class="topping-price">${priceText}</div>
            </div>
        `;

        if (currentPizza && currentPizza.getToppings().includes(topping)) {
            card.classList.add('selected');
        }

        card.addEventListener('click', () => toggleTopping(topping));
        container.appendChild(card);
    }
}

function selectInitialOptions() {
    selectPizzaType('Маргарита');
    selectPizzaSize('Маленькая');
}

function selectPizzaType(type) {
    document.querySelectorAll('.pizza-card').forEach(card => {
        card.classList.remove('selected');
    });

    document.querySelector(`.pizza-card[data-type="${type}"]`).classList.add('selected');

    if (!currentPizza || currentPizza.getType() !== type) {
        const size = currentPizza ? currentPizza.getSize() : Object.keys(Pizza.SIZES)[0];
        const toppings = currentPizza ? currentPizza.getToppings() : [];

        currentPizza = new Pizza(type, size);

        toppings.forEach(topping => currentPizza.addTopping(topping));
    }

    updateTotalDisplay();
}

function selectPizzaSize(size) {
    document.querySelectorAll('.size-button').forEach(button => {
        button.classList.remove('selected');
    });

    document.querySelector(`.size-button[data-size="${size}"]`).classList.add('selected');

    if (currentPizza) {
        const type = currentPizza.getType();
        const toppings = currentPizza.getToppings();

        currentPizza = new Pizza(type, size);

        toppings.forEach(topping => currentPizza.addTopping(topping));
    }

    renderToppings();
    updateTotalDisplay();
}

function toggleTopping(topping) {
    if (!currentPizza) return;

    const toppingElement = document.querySelector(`.topping-card[data-topping="${topping}"]`);

    if (currentPizza.getToppings().includes(topping)) {
        currentPizza.removeTopping(topping);
        toppingElement.classList.remove('selected');
    } else {
        currentPizza.addTopping(topping);
        toppingElement.classList.add('selected');
    }

    updateTotalDisplay();
}

function updateTotalDisplay() {
    if (!currentPizza) return;

    const priceElement = document.getElementById('total-price');
    const caloriesElement = document.getElementById('total-calories');

    priceElement.textContent = currentPizza.calculatePrice();
    caloriesElement.textContent = currentPizza.calculateCalories();
}

document.getElementById('add-to-cart').addEventListener('click', function() {
    if (!currentPizza) return;

    alert('Пицца добавлена в корзину!');
});