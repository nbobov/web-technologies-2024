class Pizza {
    static TYPES = {
        'Маргарита': { price: 500, calories: 300 },
        'Пепперони': { price: 800, calories: 400 },
        'Баварская': { price: 700, calories: 450 }
    };

    static SIZES = {
        'Маленькая': { price: 100, calories: 100 },
        'Большая': { price: 200, calories: 200 }
    };

    static TOPPINGS = {
        'Сливочная моцарелла': { price: 50, calories: 20, size: null },
        'Сырный борт': { price: { 'Маленькая': 150, 'Большая': 300 }, calories: 50, size: true },
        'Чедер и пармезан': { price: { 'Маленькая': 150, 'Большая': 300 }, calories: 50, size: true }
    };

    constructor(type, size) {
        if (!Pizza.TYPES[type]) throw new Error('Неизвестный вид пиццы');
        if (!Pizza.SIZES[size]) throw new Error('Неизвестный размер пиццы');
        this.type = type;
        this.size = size;
        this.toppings = [];
    }

    addTopping(topping) {
        if (!Pizza.TOPPINGS[topping]) throw new Error('Неизвестная добавка');
        if (!this.toppings.includes(topping)) this.toppings.push(topping);
    }

    removeTopping(topping) {
        this.toppings = this.toppings.filter(t => t !== topping);
    }

    getToppings() {
        return [...this.toppings];
    }

    getType() {
        return this.type;
    }

    getSize() {
        return this.size;
    }

    calculatePrice() {
        let price = Pizza.TYPES[this.type].price + Pizza.SIZES[this.size].price;
        for (const topping of this.toppings) {
            const t = Pizza.TOPPINGS[topping];
            if (t.size) {
                price += t.price[this.size];
            } else {
                price += t.price;
            }
        }
        return price;
    }

    calculateCalories() {
        let calories = Pizza.TYPES[this.type].calories + Pizza.SIZES[this.size].calories;
        for (const topping of this.toppings) {
            calories += Pizza.TOPPINGS[topping].calories;
        }
        return calories;
    }
}

export { Pizza };

// Пример использования

const pizza = new Pizza('Баварская', 'Большая');

pizza.addTopping('Чедер и пармезан');
pizza.addTopping('Сырный борт');

console.log('Вид пиццы:', pizza.getType());
console.log('Размер:', pizza.getSize());
console.log('Добавки:', pizza.getToppings());
console.log('Цена:', pizza.calculatePrice(), 'руб.');
console.log('Калорийность:', pizza.calculateCalories(), 'Ккал');