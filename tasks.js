/* Задание 1 */

const students = [
    { name: 'Павел', age: 20 },
    { name: 'Иван', age: 20 },
    { name: 'Эдем', age: 20 },
    { name: 'Денис', age: 20 },
    { name: 'Виктория', age: 20 },
    { age: 40 },
]

const pickPropArray = (array, property) => {
    let result = []

    array.forEach((item) => {
        if (item[property])
            result.push(item[property]);
    })

    return result
}

const result = pickPropArray(students, 'age')

console.log(result)

/* Задание 2 */

function createCounter() {
    let count = 0;

    return function () {
        count++;

        console.log(count);
    }
}

const counter1 = createCounter()
counter1()
counter1()

const counter2 = createCounter()
counter2()
counter2()

/* Задание 3 */

const spinWords = (string) => {
    let result = [];

    string.split(' ').forEach((word) => {
        const cleanWord = word.replace(/[^\p{L}\p{N}]/gu, '');

        if (cleanWord.length >= 5) {
            word = word.split('').reverse().join('');
        }

        result.push(word);
    })

    return result.join(' ');
}

const result1 = spinWords( "Привет от Legacy" )
console.log(result1)

const result2 = spinWords( "This is a test" )
console.log(result2)

/* Задание 4 */

const sumNumsToGetTarget = (nums, target) => {
    const map = new Map();

    for(let i = 0; i < nums.length; i++) {
        if (map.has(target - nums[i])) {
            return [map.get(target - nums[i]), i];
        }

        map.set(nums[i], i);
    }

    return null;
}

const nums = [2, 7, 11, 5];
const target = 9;

console.log(sumNumsToGetTarget(nums, target));

/* Задание 5 */

const maxSuffix = (array) => {
    if (array.length === 0) {
        return '';
    } else if (array.length === 1) {
        return array[0];
    }

    let suffix = array[0];

    for (let i = 1; i < array.length; i++) {
        while (array[i].lastIndexOf(suffix) !== array[i].length - suffix.length) {
            suffix = suffix.substring(1);
        }
    }

    return suffix.length >= 2 ? suffix : '';
}

console.log(maxSuffix(["цветок","поток","хлопок"]));
console.log(maxSuffix(["собака","гоночная машина","машина"]));