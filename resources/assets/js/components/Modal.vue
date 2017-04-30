<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <slot name="header">
                        </slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="btn btn-default" @click="cancel()">
                                Cancel
                            </button>
                            <button class="btn btn-primary" @click="submit()">
                                OK
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: 'modal',
        methods: {
            submit: function() {
                this.$emit('submit')
            },
            cancel: function() {
                this.$emit('close')
            }
        }
    }
</script>
