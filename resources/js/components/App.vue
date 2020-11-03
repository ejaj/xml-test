<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <span class="text-secondary">Vue Book List</span>
        </div>
        <br/>
        <template>
            <div>
                <h3 class="text-center">All Books</h3><br/>
                <input
                        type="text"
                        v-model="search"
                        placeholder="Search by ISBN"
                        @keyup="searchUnit"
                />


                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>ISBN</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="book in books.data" :key="book.id">
                        <td>{{ book.id }}</td>
                        <td>{{ book.title }}</td>
                        <td>{{ book.isbn }}</td>
                        <td>{{ book.created_at }}</td>
                        <td>{{ book.updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
                <pagination :data="books" @pagination-change-page="fetchBooks"></pagination>
            </div>
        </template>

    </div>
</template>

<script>
    import _ from 'lodash';

    export default {
        data() {
            return {
                search: '',
                books: {}
            }
        },
        methods: {
            fetchBooks() {
                this.axios.get('http://xml.test/api/books')
                    .then(response => {
                        this.books = response.data;
                    });
            },
            fetchBooks(page = 1) {
                this.axios.get('http://xml.test/api/books?page=' + page)
                    .then(response => {
                        this.books = response.data;
                    });
            },
            searchUnit: _.debounce(function () {
                this.axios.get('http://xml.test/api/books/search?isbn=' + this.search)
                    .then((response) => {
                        this.books.data = response.data.book;
                        //console.log('ddd')
                    })
            }),
        },
        created() {
            this.fetchBooks();
        },


    }
</script>