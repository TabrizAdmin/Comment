<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1>Example Post Title</h1></div>

                    <div class="card-body">
                        <img src="/img.jpg" width="100%" /><br><br>
                        <p>Lorem ipsum dolor sit amet, qui omnis disputationi in, eum vidit virtute et. Qui ad odio nusquam maiestatis. Ne putent inermis mei, pro nibh malis maiestatis et. Per id porro consul, at rationibus neglegentur pri.</p>

                        <p>Euismod repudiare ex mei, ne sit iriure consetetur. Esse voluptatum per eu. No eos hinc numquam. Ignota graeco conclusionemque qui id.</p>

                        <p>Vim nemore molestie repudiandae an, justo dicta mea at. Pri case errem perfecto te, per cu vidisse iuvaret. Postea percipit hendrerit ea per, at pertinacia efficiantur mei. Ius primis graeco no, mea cu brute oblique, his dictas dolorum contentiones et. Nec eu laboramus intellegat, in eum magna congue impedit. Sint voluptua complectitur qui at.</p>

                        <p>Nec cu aeque quando utamur, qui ne placerat consetetur reprehendunt. Et quidam commune quo, viderer labitur ne eam. Pri in diceret tractatos, id blandit corrumpit his. Nec at legere abhorreant appellantur. Albucius urbanitas complectitur sit no, pro ei minim molestiae gubergren, mei tota tibique antiopam ex.</p>

                        <p>Eum ea veri eligendi, noster legendos ea vis. Nostrum splendide accommodare eu has, has te aeque movet meliore. Id vel harum adipiscing, at habeo velit mea, vel an natum menandri. Ei qui nibh laboramus neglegentur.</p>
                    </div>
                </div><br>

                <div class="card">
                    <div class="card-header">Comments Section</div>

                    <div class="card-body">
                        <div class="card" v-for="comment in comments">
                            <div class="card-header">{{ comment.full_name }} ({{ comment.created_at }})</div>

                            <div class="card-body">
                                {{ comment.text }}
                                <br>
                                <a href="#commentsection" class="btn btn-link" @click="sendReplay(comment.id)">Replay</a>

                                <div class="card" v-for="comment1 in comment.children">
                                    <div class="card-header">{{ comment1.full_name }} ({{ comment1.created_at }})</div>

                                    <div class="card-body">
                                        {{ comment1.text }}
                                        <br>
                                        <a href="#commentsection" class="btn btn-link" @click="sendReplay(comment1.id)">Replay</a>

                                        <div class="card" v-for="comment2 in comment1.children">
                                            <div class="card-header">{{ comment2.full_name }} ({{ comment2.created_at }})</div>

                                            <div class="card-body">
                                                {{ comment2.text }}
                                            </div>
                                        </div><br>

                                    </div>
                                </div><br>

                            </div>
                        </div><br>
                    </div>
                </div><br>

                <div class="card" id="commentsection">
                    <div class="card-header">Send Comment</div>

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
                comments: [],
                fullName: '',
                commentText: '',
                motherComment: 0,
                motherId: 0
            }
        },
        methods: {
            goBack() {
                this.$router.go(-1);
            },
            sendReplay(commentId) {
                this.motherComment = commentId;
            },
            requiredInfo: function() {
                let self = this;
                axios.get('/api/v1/get-comments')
                .then(function (response) {
                    self.comments = response.data.data;
                });
            },
            send: function() {
                let self = this;
                const formData = new FormData();
                formData.append('full_name', this.fullName);
                formData.append('text', this.commentText);
                formData.append('mother_id', this.motherComment);
                axios.post('/api/v1/send-comment', formData)
                .then(function (response) {
                    self.requiredInfo();
                });
            }
        },
        mounted: function(){
            this.requiredInfo();
            console.log('Component mounted.');
        },
    }
</script>
