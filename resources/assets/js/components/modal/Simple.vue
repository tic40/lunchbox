<template>
    <div class="modal fade" v-bind:id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" v-text="title"></h4>
                </div>
                <div class="modal-body">
                    <p v-text="body_head"></p>
                    <p v-text="body"></p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" v-text="cancel"></button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" v-text="submit"></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            modal_id: {
                type: String,
                required: true
            },
            title: {
                type: String,
                required: true
            },
            body_head: {
            },
            body: {
                required: true
            },
            cancel: {
                type: String,
                default: 'Close'
            },
            submit: {
                type: String,
                default: 'OK'
            }
        }
    }
</script>
