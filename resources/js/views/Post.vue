<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Post Title</div>

                    <div class="card-body">
                        Example Post Body.
                    </div>
                </div><br>

                <div class="card">
                    <div class="card-header">Comments Section</div>

                    <div class="card-body">
                        <form>
                            <div class="form-group row pt-1">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Full Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fullname" required v-model="fullName">
                                </div>
                            </div>
                            <div class="form-group row pt-1">
                                <label for="text" class="col-sm-2 col-form-label">Comment's text</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="text" rows="3" required v-model="commentText"></textarea>
                                </div>
                            </div>
                            <div class="form-group row pt-1">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">
                                    <button type="button" class="btn btn-primary btn-block" @click="send">Send Comment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Post',
        data: () => {
            return {
                fullName: '',
                commentText: '',
                motherComment: 0
            }
        },
        methods: {
            goBack() {
                this.$router.go(-1);
            },
            requiredInfo: function() {
                // let self = this;
                // axios.get('/api/v1/drivers/create')
                // .then(function (response) {
                //     self.users = response.data.data.users_pluck;
                // }).catch(function (error) {
                //     self.errorContent = error.response.data.message[0];
                //     self.errorModal = true;
                // });
            },
            send: function() {
                const formData = new FormData();
                formData.append('fullName', this.fullName);
                formData.append('commentText', this.commentText);
                formData.append('motherComment', this.motherComment);
                console.log('Send comment.');
                axios.post('/api/v1/send-comment', formData)
                .then(function (response) {
                    // self.successModal = true;
                }).catch(function (error) {
                    // self.errorContent = error.response.data.message[0];
                    // self.errorModal = true;
                });
            }
        },
        mounted: function(){
            this.requiredInfo();
            console.log('Component mounted.');
        },
    }
</script>
