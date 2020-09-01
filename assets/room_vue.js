import Vue from 'https://cdn.jsdelivr.net/npm/vue@2.6.0/dist/vue.esm.browser.js';

const vm = new Vue({
    el: '#app',
    data: {
        popup: false,
        items: {},
        activeTag: "",
        popupContent: "",
        popupMaxContent: 280
    },
    computed: {
        filteredItems() {
            const filterKey = this.activeTag;
            let items = this.items;

            if (filterKey?.length !== 0) {
                let newItems = {};
                for (const key in items) {
                    const tags = items[key].tags.filter(function(obj) { return obj }); // Remove null elements

                    const indexFoundTag = tags.indexOf(filterKey);
                    if (indexFoundTag !== -1) {
                        newItems[key] = {
                            'id': parseInt(key),
                            'content': items[key].content,
                            'date': items[key].date,
                            'tags': items[key].tags
                        };
                    }
                }
                items = newItems;
            }

            return items;
        }
    },
    methods: {
        openPopup() {
            if(this.popup) this.closePopup();
            else this.popup = true;
        },
        closePopup() {
            this.popup = false;
        },
        deleteItem(i) {
            this.api_deleteItem(this.items[i].id);
            const items = { ...this.items };
            delete items[this.items[i].id];
            this.items = items;
        },
        async api_getItems() {
            /**
             * Requête pour récupérer tous les items de la room dans la BDD
             */
            const roomId = parseInt(document.body.dataset.roomId);

            const formulaire = new FormData();
            formulaire.append('type', 'getItemsByRoomId');
            formulaire.append('roomID', roomId);

            const response = await fetch('Api.php', {
                method: 'POST',
                body: formulaire
            });

            const data = await response.json();
            this.items = data;
        },
        async api_deleteItem(itemId) {
            /**
             * Requête pour supprimer un item dans la BDD
             */
            const formulaire = new FormData();
            formulaire.append('type', 'deleteItemById');
            formulaire.append('itemID', parseInt(itemId));

            const response = await fetch('Api.php', {
                method: 'POST',
                body: formulaire
            });

            await response.json();
        }
    },
    mounted() {
        document.getElementById('app').style.display = 'flex';
        this.api_getItems();
    }
});