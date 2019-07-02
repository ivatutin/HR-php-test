Vue.component('price-edit', {
    props: {
        product_id: {
            type: Number,
            required: true
        },
        price: {
            type: Number,
            required: true
        }
    },

    data: function () {
        return {
            state: 'show',
            initPrice: '',
            currentPrice: '',
            data: {}
        }
    },

    created: function() {
        this.initPrice = this.price;
        this.currentPrice = this.price;
    },

    methods: {
        cancel: function() {
            this.state = 'show';
            this.currentPrice = this.initPrice;
        },
        save: function() {
            this.state = 'loading';
            axios.post('/product-list/'+this.product_id, {price: this.currentPrice})
                .then((response) => { this.initPrice = response.data.price; this.currentPrice = response.data.price; this.state = 'show'; } )
                .catch((error) => console.log(error.response.data));


        }
    },

    template: '<div class="price-edit">' +
        '<div v-show="state==\'show\'" class="flex">{{ initPrice }} <i @click="state=\'edit\'" class="ico ico__edit"></i></div>' +
        '<div v-show="state==\'edit\'" class="flex"><input v-model="currentPrice" type="number"> <i @click="save" class="ico ico__save"></i> <i @click="cancel" class="ico ico__cancel"></i></div>' +
        '<div v-show="state==\'loading\'" class="flex">загрузка..</div>' +
        '</div>'
})

new Vue({ el: '#appProducts' })