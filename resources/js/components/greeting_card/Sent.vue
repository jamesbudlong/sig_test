<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Sent Greeting Cards</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Recipient</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="(sent_greeting_card,itemKey) in sent_greeting_cards.data" :key="sent_greeting_card.id">
                      <td>{{sent_greeting_card.id}}</td>
                      <td>{{sent_greeting_card.recipient.name}}</td>
                      <td>
                        <a href="#" @click="viewModal(itemKey)">
                            <i class="fa fa-eye blue"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">View Greeting Card</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img style="max-width:100%" id="image" :src="imgSrc" />
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
</template>

<script>
    export default {
        data () {
            return {
              sent_greeting_cards : {},
              imgSrc: '',
            }
        },
        methods: {
          loadSentGreetingCards(){
            axios.get("/api/greeting_card/sentGreetingCard").then(({ data }) => (this.sent_greeting_cards = data.data));
          },
          viewModal(i){
            let img = this.sent_greeting_cards.data[i]['canvas_data'];
            $('#viewModal').modal('show');
            this.imgSrc = img;
          },
        },
        mounted() {

        },
        created() {
            this.$Progress.start();
            this.loadSentGreetingCards();
            this.$Progress.finish();
        }
    }
</script>
