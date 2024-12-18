if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init)
} else {
    init()
}

function init() {
    const data = {
        name: 'Каталог товаров',
        hasChildren: true,
        items: [
            {
                name: 'Мойки',
                hasChildren: true,
                items: [
                    {
                        name: 'Ulgran',
                        hasChildren: true,
                        items: [
                            {
                                name: 'Smth',
                                hasChildren: false,
                                items: []
                            },
                            {
                                name: 'Smth',
                                hasChildren: false,
                                items: []
                            }
                        ]
                    },
                    {
                        name: 'Vigro Mramor',
                        hasChildren: false,
                        items: []
                    },
                    {
                        name: 'Handmade',
                        hasChildren: true,
                        items: [
                            {
                                name: 'Smth',
                                hasChildren: false,
                                items: []
                            },
                            {
                                name: 'Smth',
                                hasChildren: false,
                                items: []
                            }
                        ]
                    },
                    {
                        name: 'Vigro Glass',
                        hasChildren: false,
                        items: []
                    }
                ]
            },{
                name: 'Фильтры',
                hasChildren: true,
                items: [
                    {
                        name: 'Ulgran',
                        hasChildren: true,
                        items: [
                            {
                                name: 'Smth',
                                hasChildren: false,
                                items: []
                            },
                            {
                                name: 'Smth',
                                hasChildren: false,
                                items: []
                            }
                        ]
                    },
                    {
                        name: 'Vigro Mramor',
                        hasChildren: false,
                        items: []
                    }
                ]
            }
        ]
    }


    const items = new ListItems(document.getElementById('list-items'), data)


    items.render();
    items.init();

    /*console.log(items.renderTest(data));*/

    function ListItems(el, data) {
        this.el = el;
        this.data = data;

        this.init = function () {
            console.log("here")

            const parents = this.el.querySelectorAll('[data-parent]')

            console.log(parents)

            parents.forEach(parent => {
                const open = parent.querySelector('[data-open]')

                if (open) {
                    open.addEventListener('click', () => this.toggleItems(parent));
                }
            })
        }

        this.render = function () {
            this.el.insertAdjacentHTML('beforeend', this.renderParent(this.data))
        }

        this.renderParent = function (data) {
            //проверка всех элементов на hasChildren
            //если hasChildren, то запускаем renderParent
            //если !hasChildren, то запускаем renderChildren
            //возвращает рендер родительского элемента

            const children = data.items
                .map((item) => {
                    console.log(item)
                    if (item.hasChildren) {
                        return this.renderParent(item);
                    } else {
                        return this.renderChildren(item);
                    }
                })
                .join('');

            return `
                    <div class="list-item" data-parent>
                        <div class="list-item__inner">
                            ${data.hasChildren ? `<img class="list-item__arrow" src="img/chevron-down.png" alt="arrow" data-open>` : ''}
                            <img class="list-item__folder" src="img/folder.png" alt="folder">
                            <span>${data.name}</span>
                        </div>
                        ${data.hasChildren ? `<div class="list-item__items">${children}</div>` : ''}
                    </div>
                `
        }

        this.renderChildren = function (data) {
            //вовзращает рендер элемента без вложенности

            return `
                    <div class="list-item" data-child>
                        <div class="list-item__inner">
                            <img class="list-item__folder" src="img/folder.png" alt="file">
                            <span>${data.name}</span>
                        </div>
                    </div>
                `
        }

        this.toggleItems = function (parent) {
            parent.classList.toggle('list-item_open')
        }

        /*        this.renderTest = function (data) {
                    return `
                    <div class="test">${data.name}</div>
                    `
                }*/
    }

}
