<template>
    <div>
        <b-container fluid>
            <b-row class="justify-content-md-left mt-2">
                <b-col cols="12">
                    <button class="btn btn-secondary" @click="goToSearch">Go to Search!</button>
                </b-col>
            </b-row>
            <b-row class="justify-content-md-center">
                <b-col cols="12" md="auto">
                    <h3 class="mt-3">Search History</h3>
                </b-col>
            </b-row>
            <b-row class="mt-3 justify-content-md-center">
                <h4 v-if="previousResults.length == 0">No history found!</h4>
            </b-row>
            <b-row class="justify-content-md-center" v-if="previousResults.length > 0">
                <b-col col md="10">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Word</th>
                                <th>Results</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody v-for="history in previousResults" :key="history.id">
                            <tr>
                                <td>{{ history.word }}</td>
                                <td>{{ history.results }}</td>
                                <td><button class="btn btn-info" @click="viewResults(history.id)">View Results</button></td>
                            </tr>
                        </tbody>
                    </table>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    name: "PreviousResults",
    data () {
        return {
            previousResults: []
        }
    },
    mounted() {
        this.fetchHistory();
    },
    methods: {
        async fetchHistory () {
            await axios.get('/api/word-definitions')
                .then(async (response) => {
                    response.data.forEach(data => {
                        let result = {
                            'id': data.id,
                            'word': data.word,
                            'results': data.definitions.length
                        }
                        this.previousResults.push(result)
                    })
                })
        },
        goToSearch () {
            this.$router.push('./')
        },
        viewResults (id) {
            this.$router.push('word-results/' + id)
        }
    }
}
</script>