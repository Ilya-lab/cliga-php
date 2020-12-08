<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Назад</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Создать новую новость</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Наименование</label>
                            <input type="text" v-model="news.title" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Краткое описание</label>
                            <input type="text" v-model="news.desc" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Дата и время публикации</label>
                            <datetime type="datetime" v-model="news.date" class="form-control" :phrases="{ok: 'Продолжить', cancel: 'Выход'}" format="dd.MM.yyyy HH:mm"></datetime>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Содержание</label>
                            <editor :init="{plugins: 'wordcount'}"></editor>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Записать</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            var d = new Date();
            return {
                news: {
                    title: '',
                    desc: '',
                    date: d.toISOString(),
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newCompany = app.company;
                axios.post('/api/v1/companies', newCompany)
                    .then(function (resp) {
                        app.$router.push({path: '/'});
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Не удалось сохранить новость");
                    });
            }
        }
    }
</script>
