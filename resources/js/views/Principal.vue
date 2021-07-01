<template>
    <b-container>
        <b-row>
            <b-col md="12" align-self="center" class="mt-4">
                <b-card class="shadow">
                    <h1>Listado de posts</h1>
                    <hr>
                    <b-button variant="success" size="sm" @click="modals.createEdit = true">Crear nuevo post</b-button>
                    <b-pagination
                        :total-rows="pagination.total"
                        :per-page="pagination.per_page"
                        v-model="pagination.current_page"
                        pills
                        size="sm"
                        @change="nextPage($event)"
                        v-if="pagination.total > pagination.per_page"
                        class="float-right"
                    ></b-pagination>
                    <b-table :items="posts" small :fields="fields" :busy="overlays.table" empty-text="No hay posts para mostrar" ref="tabla">
                        <template #table-busy>
                            <div class="text-center">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Cargando...</strong>
                            </div>
                        </template>
                        <template #table-caption v-if="posts.length == 0 && overlays.table == false"
                        >
                            <div class="text-center border p-3">
                                <strong>No hay posts para mostrar</strong>
                            </div>
                        </template>
                        <template #cell(edit)="data">
                            <b-button variant="info" class="text-white" @click="showEdit(data.item, data.index)"><i class="fa fa-edit"></i></b-button>
                        </template>
                        <template #cell(delete)="data">
                            <b-button variant="danger" class="text-white" @click="showDelete(data.item, data.index)"><i class="fa fa-trash"></i></b-button>
                        </template>
                    </b-table>
                    <b-pagination
                        :total-rows="pagination.total"
                        :per-page="pagination.per_page"
                        v-model="pagination.current_page"
                        pills
                        size="sm"
                        @change="nextPage($event)"
                        v-if="pagination.total > pagination.per_page"
                        class="float-right"
                    ></b-pagination>
                </b-card>
            </b-col>
        </b-row>
        <b-modal v-model="modals.createEdit" hide-header hide-footer size="xl" @hide="closedModal()">
            <b-overlay :show="overlays.createEdit" variant="transparent">
                <h1 class="d-inline-block mb-0">{{ dataForm.title }}</h1>
                <div class="float-right">
                    <b-button variant="outline-danger" @click="closedModal()">
                        <i class="fa fa-times fa-lg"></i>
                    </b-button>
                </div>
                <hr class="my-2 mb-3">
                <b-alert variant="danger" show v-for="(err, index) in errors" :key="index">
                    {{ err }}
                </b-alert>
                <label for="titulo" class="mb-0">Titulo</label>
                <b-form-input v-model="dataForm.titulo" placeholder="Ingresar el titulo del post" class="mb-2"></b-form-input>
                <label for="cotenido" class="mb-0">Contenido</label>
                <b-form-textarea v-model="dataForm.contenido" placeholder="Ingrese el contenido del post" rows="4" class="form-control"></b-form-textarea>
                <hr>
                <div class="float-right">
                    <b-button variant="danger" @click="closedModal()">Cancelar</b-button>
                    <b-button variant="info" @click="sendDataForm()" class="text-white">{{ dataForm.title }}</b-button>
                </div>
            </b-overlay>
        </b-modal>
        <b-modal v-model="modals.delete" hide-header hide-footer size="xl">
            <b-overlay :show="overlays.delete" variant="transparent" class="text-center">
                <h1 class="mb-4">¿Esta seguro que desea eliminar el post?</h1>
                <b-button variant="primary" @click="modals.delete = false" size="lg">Cancelar</b-button>
                <b-button variant="danger" @click="sendDelete()" class="text-white" size="lg">Eliminar</b-button>
            </b-overlay>
        </b-modal>
    </b-container>
</template>

<script>
export default {
    name: 'Principal',
    data() {
        return {
            // Variables de control para los overlays y los modals
            overlays: {
                table: true,
                createEdit: false,
                delete: false
            },
            modals: {
                createEdit: false,
                delete: false,
            },
            posts: [], // Los posts que vienen del backend
            fields: [ // Son las columnas que queremos mostrar en el componente b-table que crea una tabla automaticamente
                {
                    key: 'id',
                    thClass: 'my-3',
                },
                {
                    key: 'titulo',
                    thClass: 'my-3',
                },
                {
                    key: 'contenido',
                    thClass: 'my-3',
                },
                {
                    key: 'edit',
                    thClass: 'my-3',
                },
                {
                    key: 'delete',
                    thClass: 'my-3',
                },
            ],
            pagination: { // Datos necesarios para la paginacion
                current_page: 1,
                per_page: null,
                total: null
            },
            dataForm: { // Datos para el formulacion de crear/editar un post
                title: 'Crear post',
                titulo: null,
                contenido: null,
            },
            select_post: {}, // Post seleccionado para editar o eliminar
            errors: [], // Errores
        }
    },
    methods: {
        /* Funcion para cuando se desea ir a otra pagina */
        async nextPage(page) {
            this.overlays.table = true;
            console.log(page);
            let {data} = await this.$axios.get(`posts?page=${page}`);
            this.posts = data.posts;
            this.$refs.tabla.refresh();
            this.overlays.table = false;
        },
        /* Funcion la cual resetea los valores que se utilizan dentro del modal de crear/editar */
        closedModal(){
            this.dataForm.title = 'Crear post';
            this.dataForm.titulo = null;
            this.dataForm.contenido = null;
            this.errors = [];
            this.modals.createEdit = false;
        },
        /* Funcion con la cual mandamos la informacion correspondiente al backend para crear/editar un post */
        async sendDataForm(){
            this.errors = [];
            /* Verificamos los datos */
            if(this.dataForm.titulo == null || this.dataForm.titulo == '' || this.dataForm.contenido == null || this.dataForm.contenido == ''){
                this.errors.push('Debe ingresar el titulo y el contenido correctamente');
                return;
            }
            this.overlays.createEdit = true;
            try {
                if(this.select_post?.id == undefined){
                    let {data: {post}} = await this.$axios.post('posts', this.dataForm);
                    if(this.posts.length <= this.pagination.per_page){
                        this.posts.push(post);
                    }
                    this.pagination.total++; // Aumentamos el total para que la paginacion se reajuste automaticamente
                    this.$bvToast.toast('Se creo correctamente el post', {
                        title: 'Crear post',
                        variant: 'success',
                        solid: true,
                    });
                }else{
                    let {data: {post}} = await this.$axios.post(`posts/${this.select_post.id}`, this.dataForm);
                    this.posts[this.select_post.index] = post;
                    this.$bvToast.toast('Se editó correctamente el post', {
                        title: 'Editar post',
                        variant: 'info',
                        solid: true,
                    });
                }
            } catch (error) {
                this.$bvToast.toast('Error en el servidor', {
                    title: 'Error',
                    variant: 'danger',
                    solid: true,
                });
            }
            this.overlays.createEdit = false;
            this.closedModal();
            this.$refs.tabla.refresh();
        },
        /* Funcion que abre el modal para editar un post */
        showEdit(dataEdit, index){
            dataEdit.index = index;
            this.select_post = dataEdit;
            this.dataForm.titulo = dataEdit.titulo;
            this.dataForm.contenido = dataEdit.contenido;
            this.dataForm.title = 'Editar post';
            this.modals.createEdit = true;
        },
        /* Funcion que abre el modal para elminar un post */
        showDelete(post, index){
            this.select_post = post;
            this.select_post.index = index;
            this.modals.delete = true;
        },
        /* Funcion que manda al backend el id correspondiente al post para eliminarlo */
        async sendDelete(){
            this.overlays.delete = true;
            try {
                await this.$axios.post(`posts/delete/${this.select_post.id}`);
                this.posts.splice(this.select_post.index, 1);
                this.$bvToast.toast('Se eleminó correctamente el post', {
                    title: 'Eliminar post',
                    variant: 'success',
                    solid: true,
                });
                /* Puede pasar que se elimina el post pero era el unico en la pagina actual, por ende deberia ir hacia atras, para eso restamos uno al current_page, restamos uno al total y finalmente llamamos a la funcion nextPage pasandole la paginacion actual */
                if(this.posts.length == 0){
                    this.pagination.current_page = parseInt(this.pagination.current_page) - parseInt(1);
                    this.pagination.total = this.pagination.total-1;
                    this.nextPage(this.pagination.current_page);
                }
                this.select_post = {};
                this.$refs.tabla.refresh();
            } catch (error) {
                console.log(error);
                this.$bvToast.toast('Error en el servidor', {
                    title: 'Error',
                    variant: 'danger',
                    solid: true,
                });
            }
            this.overlays.delete = false;
            this.modals.delete = false;
        }
    },
    async created(){
        // Obtenemos la informacion del backend
        let {data} = await this.$axios.get('posts');
        this.pagination.per_page = data.per_page;
        this.pagination.total = data.total;
        this.posts = data.posts;
        this.overlays.table = false;
    }
}
</script>