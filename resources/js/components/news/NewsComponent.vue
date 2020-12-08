<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createNews'}" class="btn btn-success">Добавить новость</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Новости</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Заголовок</th>
                        <th class="hidden-xs">Описание</th>
                        <th class="hidden-xs">Дата</th>
                        <th class="hidden-xs">Автор</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="nw, index in news">
                        <td>{{ nw.title }}</td>
                        <td class="hidden-xs">{{ nw.desc }}</td>
                        <td class="hidden-xs">{{ nw.date }}</td>
                        <td class="hidden-xs">{{ nw.name }}</td>
                        <td>
                            <router-link :to="{name: 'editNews', params: {id: nw.id}}" class="btn btn-xs btn-default">
                                Изменить
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(nw.id, index)">
                                Удалить
                            </a>
                            <a href="#"
                               class="btn btn-xs btn-info hidden-xs"
                               v-on:click="arjivEntry(nw.id, index)">
                                В архив
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                news: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/home/news/all')
                .then(function (resp) {
                    app.news = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Не удалось загрузить новости");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Вы действительно хотите удалить новость?")) {
                    var app = this;
                    axios.delete('/api/v1/companies/' + id)
                        .then(function (resp) {
                            app.companies.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Не удалось удалить компанию");
                        });
                }
            }
        }
    }
</script>