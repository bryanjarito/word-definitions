<template>
    <div>
        <b-container fluid>
            <b-row class="justify-content-md-center">
                <b-col cols="12" md="auto">
                    <h3 class="mt-3">Word Definition App</h3>
                </b-col>
            </b-row>
            <b-row class="mb-4 mt-2 justify-content-lg-center">
                <b-col col md="12" lg="4">
                    <b-button block variant="info" @click="getPreviousResults">Search History</b-button>
                </b-col>
            </b-row>
            <b-row class="justify-content-lg-center">
                <b-col col md="12" lg="4">
                    <input type="text" placeholder="Enter a word" v-model="word" class="form-control" autofocus>
                </b-col>
            </b-row>
            <b-row class="mt-3 justify-content-lg-center">
                <b-col col md="12" lg="4">
                    <b-button block variant="primary" @click="getWordDefinitions">Get Definitions</b-button>
                </b-col>
            </b-row>
            <div v-if="isSearchDone">
                <b-row class="mt-3 justify-content-lg-center">
                    <h3><b>Word: <i>{{searchWord}}</i></b></h3>
                </b-row>
                <b-row class="mt-3 justify-content-lg-center">
                    <h4 v-if="definitions.length == 0">No definitions found!</h4>
                </b-row>
                <b-row class="justify-content-lg-center" v-if="definitions.length > 0">
                    <b-col col md="10">
                        <b-table striped hover :items="definitions"></b-table>
                    </b-col>
                </b-row>
            </div>
        </b-container>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    name: "WordDefinition",
    data () {
        return {
            word: '',
            searchWord: '',
            searchResult: [],
            definitions: [],
            isSearchDone: false
        }
    },
    methods: {
        async getWordDefinitions () {
            this.definitions = []
            this.searchResult = {}
            this.searchWord = this.word

            const headers = { 
                'x-rapidapi-host': 'mashape-community-urban-dictionary.p.rapidapi.com', 
                'x-rapidapi-key': 'ea3b8b4e2fmsh7b2a875d27dd982p169d1cjsn9e393e514924'
            }

            await axios.get('https://mashape-community-urban-dictionary.p.rapidapi.com/define?term=' + this.searchWord, {headers})
                .then(async (response) => {
                    response.data.list.forEach(definition => {
                        let data = {
                            definition: definition.definition,
                            author: definition.author
                        }

                        this.definitions.push(data);
                    });
                    this.searchResult.word = this.searchWord
                    this.searchResult.definitions = this.definitions

                    return this.searchResult
                })
                .then(async(searchResult) => {
                    await axios.post('api/word-definitions', searchResult)
                    .then(async (response) => {
                        console.log(response)
                    })

                })           
            this.isSearchDone = true
            // console.log(this.searchResult)
        },
        getPreviousResults () {
            this.$router.push('previous-results')
        }
    }
}
</script>