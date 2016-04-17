<style>
    div.main-container{
        position: relative;
        top:80px;
    }
    div.main-container div.standard{
        margin-left: 5px;
        margin-right: 5px;
    }
    div.main-container div.standard.stream-container{
        margin-left: 210px;
    }
    div.left-side-menu{
        position: fixed;
        top:80px;
        min-height: 300px;
        background: rgba(255,255,255,0.5);
    }
    div.inputContainer{
        background: white;
        padding: 10px;
    }
    div.inputContainer select{
        border-radius: 0;
    }
    div.inputContainer textarea{
        border: none;
        box-shadow: none;
    }
    div.inputContainer textarea:focus{
        box-shadow: none;
    }
    div.inputContainer input[type='submit']{
        border-radius: 0;
    }
    ul.unstyled.list-group li.list-group-item{
        border: none;
        border-radius: 0;
        background-color: transparent;
    }
    ul.unstyled.list-group li.list-group-item a{
       color:black;
    }
    ul.unstyled.list-group{
        border: none;
        color: black;
    }
    div.main-actions{
        background-color: white;
        color:grey;
    }
    div.main-actions div.active{
        color:black;
    }
</style>
<template>
        <div class="standard stream-container col-sm-8 col-md-7" >
             <div class=" main-actions">
                <div class="col-xs-6 active">
                    <p class="text-center">Feed</p>
                </div>
                <div class="col-xs-6">
                    <p class="text-center" @click.prevent="showModal()">Create Event</p>
                </div>
            </div>
            <div class="clearfix inputContainer">
                <form action="" class="form">
                    <div class="form-group">
                        <textarea name="replay" class="form-control" id="" cols="30" rows="3" placeholder="Enter Somthing here"></textarea>
                    </div>
                    <input type="submit"  class="btn btn-default pull-right" value="Update">
                    <div class="col-xs-3 pull-right">
                        <select name="type" class="form-control">
                            <option value="1" selected>Public</option>
                            <option value="2">Private</option>
                        </select>
                    </div>
                </form>
            </div>
            <feed v-for="feed in stream" :feed="feed"></feed>
            <!-- Modal -->
            <div class=" modal fade" style="color:black" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                       <event-creation-form></event-creation-form>
                    </div>
                </div>
            </div>


        </div>
</template>

<script>
    var moment = require('moment');
    import Feed from './components/feed.vue';
    import EventCreationForm from './components/commons/eventCreationForm.vue';
    export default{
        ready:function(){
            console.log('from component');
        },
        components:{
            Feed,
            EventCreationForm
        },
        data:function(){
          return{
              stream:[
                  {
                      id:1,
                      sender:"Xavier",
                      avatarSrc:"/assets/img/team/3.jpg",
                      content:"One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his",
                      created_at:"2016-04-16 17:15:23",
                      numberOfComments:0
                  },
                  {
                      id:2,
                      sender:"Adriane",
                      avatarSrc:"/assets/img/team/3.jpg",
                      content:"ne morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections. The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked. \"What's happened to me?\" he thought. It wasn't a dream. His room, a proper human",
                      created_at:"2016-04-16 17:05:23",
                      numberOfComments:1
                  },
                  {
                      id:3,
                      sender:"Tommy",
                      avatarSrc:"/assets/img/team/3.jpg",
                      content:"The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words. If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages. It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is.The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators.",
                      created_at:"2016-04-16 16:45:23",
                      numberOfComments:2
                  }
              ],
              comments:[
                  {
                      feedId:2,
                      comments:[
                          {
                              id:10,
                              sender:"Tommy",
                              avatarSrc:"/assets/img/team/3.jpg",
                              content:"The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words. If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages. It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is.The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators.",
                              created_at:"2016-04-16 16:45:23",
                              numberOfComments:0
                          }
                      ]
                  },
                  {
                      feedId:3,
                      comments:[
                          {
                              id:11,
                              sender:"Tommy",
                              avatarSrc:"/assets/img/team/3.jpg",
                              content:"The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words. If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages. It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is.The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators.",
                              created_at:"2016-04-16 16:45:23",
                              numberOfComments:0
                          },
                          {
                              id:12,
                              sender:"Tommy",
                              avatarSrc:"/assets/img/team/3.jpg",
                              content:"The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words. If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages. It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is.The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators.",
                              created_at:"2016-04-16 16:45:23",
                              numberOfComments:0
                          }
                      ]
                  }
              ]
          }
        },
        methods:{
            showModal: function () {
                var target = $("#myModal");
                target.modal('show');
            }
        },
        events:{
            fetchComments: function (feedId) {
                var result = this.comments.filter(function(commentCollection){
                    if(commentCollection.feedId == feedId) return commentCollection.comments
                })[0];
                this.$broadcast('pushCommentsCollections', feedId, result.comments);
            }
        }
    }
</script>