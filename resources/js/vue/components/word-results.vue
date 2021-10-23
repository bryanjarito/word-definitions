<template>
    <div>
        <b-container fluid>
            <b-row class="justify-content-md-left mt-2">
                <b-col cols="12">
                    <button class="btn btn-secondary" @click="goBack">Go Back</button>
                </b-col>
            </b-row>
            <b-row class="justify-content-md-center">
                <b-col cols="12" md="auto">
                    <h3 class="mt-3">"<i>{{ word }}"</i> results</h3>
                </b-col>
            </b-row>
            <b-row class="mt-3 justify-content-md-center">
                <h4 v-if="results.length == 0">No definitions found!</h4>
            </b-row>
            <b-row class="justify-content-md-center" v-if="results.length > 0">
                <b-col col md="10">
                    <b-table striped hover :items="results"></b-table>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    name: "WordResults",
    data () {
        return {
            results: [],
            word: ''
        }
    },
    mounted () {
        this.fetchHistory();
    },
    methods: {
        async fetchHistory () {
            await axios.get('/api/word-definitions/' + this.$route.params.id)
                .then(async (response) => {
                    this.word = response.data.word
                    response.data.definitions.forEach(definition => {
                        this.results.push({
                            'author': definition.author,
                            'definition': definition.definition
                        })
                    })
                })
        },
        goBack () {
            this.$router.push('/previous-results')
        }
    }
}
</script>