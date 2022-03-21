require('./bootstrap');
import Vue from 'vue/dist/vue.js';
window.axios = require('axios');

axios.default.baseURL = 'http://localhost:8000'

window.app = new Vue({
    el: '#app',
    data: {
        servers: [],
        filters: {
            options: {
                storage: [0, 250, 500, 1000, 2000, 3000, 4000, 8000, 12000, 24000, 48000, 72000], //In Gigabytes
                ram: [2, 4, 8, 12, 16, 24, 32, 48, 64, 96], //In Gigabytes
                hdd: ['SAS', 'SATA2', 'SSD'],
                location: [],
            },
            selected: {
                text: '',
                storage: 0,
                ram: [],
                hdd: [],
                location: []
            }
        },
        comparison: {
            a: null,
            b: null
        }
    },
    computed: {
        filteredServers() {
            const instance = this;

            //Text filter:
            let servers =  this.servers.filter(function(s) {
                if(!instance.filters.selected.text) {
                    return s;
                }

                if(s.model.toUpperCase().indexOf(instance.filters.selected.text.toUpperCase()) > -1) {
                    return s;
                }
            });

            //Storage filter:
            servers = servers.filter(function(s) {
                let storage = parseInt(instance.filters.selected.storage);
                if(storage <= 0) {
                    return s;
                }

                if(s.hdd.inGigabytes >= storage) {
                    return s;
                }
            });

            //RAM filter:
            servers = servers.filter(function(s) {
                if(!instance.filters.selected.ram || instance.filters.selected.ram.length <= 0) {
                    return s;
                }

                if(instance.filters.selected.ram.indexOf(s.ram.amount) > -1) {
                    return s;
                }
            });

            //HDD filter:
            servers = servers.filter(function(s) {
                if(!instance.filters.selected.hdd || instance.filters.selected.hdd.length <= 0) {
                    return s;
                }

                if(instance.filters.selected.hdd.indexOf(s.hdd.type) > -1) {
                    return s;
                }
            });

            return servers;
        }
    },
    methods: {
        loadServers() {
            const instance = this;
            axios.get('api/servers')
                .then(function(response) {
                    instance.servers = response.data;
                });
        },
        addToComparison(server) {
            server.compared = true;

            if(!this.comparison.a) {
                this.comparison.a = server;
            } else if (!this.comparison.b) {
                this.comparison.b = server;
                this.showComparisonModal();
            } else {
                this.comparison.a = server;
                this.comparison.b = null;
            }
        },
        showComparisonModal() {
            $('#comparisonModal').modal('show');
            this.comparison.a.compared = this.comparison.b.compared = false;
        }
    },
    mounted() {
        this.loadServers();
    }
});
